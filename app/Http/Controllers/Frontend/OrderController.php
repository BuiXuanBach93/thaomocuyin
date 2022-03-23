<?php

namespace App\Http\Controllers\Frontend;


use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\CartItem;
use App\Models\TrackingItem;
use App\Models\Notification;
use App\Http\Controllers\Controller;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use kcfinder\session;
use Validator;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use PhpParser\Node\Stmt\TryCatch;
use App\Constant;

class OrderController extends Controller
{

   public function __construct()
    {
        $this->categoryModel = new Category();

        $menuCached = Redis::get('menus');
        if($menuCached) {
            $this->menuCategories = json_decode($menuCached, true);
        } else {
            $this->menuCategories = $this->categoryModel->getMenuCategory();
            Redis::set('menus', json_encode($this->menuCategories));
        }
        View::share([
            'cookieOrders' => Product::getOrderFromCookie(),
            'menuCategories'    => $this->menuCategories,
        ]);
    } 

    /*===== giỏ hàng =====*/
   public function cart(Request $request) {
       try {
           $orderItems = Order::getOrderItems();
           $hasPromotion = 0;
           $showPromotion = 0;
           $freeShip = 0;
           foreach($orderItems as $orderItem) {
              if($orderItem->promotion_type == 2 && $orderItem->free_gift_id > 0){
                 $hasPromotion = 1;
                 $orderFreeGiftItem = Order::getOrderFreeGiftItems($orderItem->free_gift_id);
                 if(sizeof($orderFreeGiftItem) > 0){
                    $orderItems[sizeof($orderItems)] = $orderFreeGiftItem[0];
                    if($orderItem->promotion_threshold <= $orderItem->quantity){
                      $showPromotion = 1;
                    }
                    $orderItem->is_promotion = 2;
                 }
                 break;
              }
           }

           $freeShipThreshold = Constant::FREESHIP_THRESHOLD;
           $shippingFee = Constant::SHIPPING_FEE;
           $shippingFeeDefault = Constant::SHIPPING_FEE;
           $productAmount = 0;
           $totalAmount = 0;
           foreach($orderItems as $orderItem) {
              $productAmount += $orderItem->price * $orderItem->quantity;
           }
           foreach($orderItems as $orderItem) {
              if($orderItem->promotion_type == 1){
                 $freeShip = 1;
                 $shippingFee = 0;
                 break;
              }
           }

           if($productAmount < $freeShipThreshold){
              $totalAmount = $productAmount + $shippingFee;
           }else{
              $shippingFee = 0;
              $totalAmount = $productAmount;
           }

           $totalDiscount = 0;
           $discount = 0;
           $fixDiscount = 0;
           foreach($orderItems as $orderItem) {
              if($orderItem->promotion_type == 3){
                if($orderItem->promotion_threshold <= $orderItem->quantity){
                  $totalDiscount =  $totalDiscount + $orderItem->promotion_discount;
                }
                $discount = 1;
              }
           }               

           return view('order', [
                'orderItems'   => $orderItems,
                'hasPromotion' => $hasPromotion,
                'showPromotion' => $showPromotion,
                'freeShip'      => $freeShip,
                'shippingFee'   => $shippingFee,
                'totalAmount'   => $totalAmount,
                'freeShipThreshold' => $freeShipThreshold,
                'shippingFeeDefault' => $shippingFeeDefault,
                'discount' => $discount,
                'totalDiscount' => $totalDiscount,
                'pageTitle'     => 'Giỏ hàng của bạn',
                'pageKeyword'   => 'Giỏ hàng',
                'pageDesc'      => 'Nhập thông tin nhận hàng',
            ]);
       } catch (\Exception $e) {
           return redirect(URL::to('/'));
       }
   }

   /* ===== add to cart ======*/
   public function addToCart(Request $request) {
      try{
         if (empty($request->input('quantity'))
           || empty($request->input('product_id'))) {
           return response('Error', 404)
               ->header('Content-Type', 'text/plain');
       }

       $quantities = $request->input('quantity');
       $productIds = $request->input('product_id');

       $this->insertOrder($request, $productIds,$quantities);
       $orderItems = $this->productAddToCart($request, $productIds);

       foreach($orderItems as $orderItem) {
           $cost = $orderItem->price;
           CartItem::insert([
                 'product_id' => $orderItem->id,
                 'product_name' => $orderItem->short_name,
                 'quantity' => 1,
                 'cost' => $cost,
                 'ip_customer' => get_client_ip(),
                 'created_at' =>   new \DateTime(),
                 'updated_at' =>   new \DateTime()
          ]);
       }

       TrackingItem::insert([
             'source_product_name' => "SẢN PHẨM : " . $orderItem->short_name,
             'target_product_name' => "GIỎ HÀNG : " . $orderItem->short_name,
             'ip_customer' => get_client_ip(),
             'type' => 4,
             'created_at' =>   new \DateTime(),
             'updated_at' =>   new \DateTime()
          ]);

       return response([
           'status' => 200,
           'orderItems' => $orderItems,
           'quantities' =>  $quantities
       ])->header('Content-Type', 'text/plain'); 
      } catch (\Exception $e) {
             Log::error('http->site->OrderController->addToCart: add to cart');
             return redirect('/');
      }
   }

    private function productAddToCart($request, $productIds) {
        $orderItemDetail = Product::join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.*','categories.slug as category_slug')
        ->whereIn('products.id', $productIds)
            ->get();
        
        return $orderItemDetail;

    }
    private function insertOrder($request, $productIds, $quantities, $isSend = false) {
        // update order new;
        $orderNew = array();
        $statusUpdate = array();
        foreach($productIds as $id => $productId) {
            $orderNew[$productId]['quantity'] = $quantities[$id];
            $statusUpdate[$productId] = false;
        }

        if($request->session()->has('orderItems')) {
            $orderItemOlds = $request->session()->pull('orderItems');
            foreach ($orderItemOlds as $orderItemOld) {
                if (isset($orderNew[$orderItemOld['product_id']]) && !$isSend) {
                    $orderItem = [
                        'quantity' => ($orderNew[$orderItemOld['product_id']]['quantity'] + $orderItemOld['quantity']),
                        'product_id' => $orderItemOld['product_id']
                    ];
                    $request->session()->push('orderItems', $orderItem);
                    $statusUpdate[$orderItemOld['product_id']] = true;
                    continue;
                }

                $request->session()->push('orderItems', $orderItemOld);
            }
        }


        foreach ($orderNew as $productId => $orderItem) {
            if(!$statusUpdate[$productId]) {
                $orderItem = [
                    'quantity' => $orderItem['quantity'],
                    'product_id' => $productId
                ];
                $request->session()->push('orderItems', $orderItem);
            }
        }
    }

   public function deleteItemCart(Request $request) {
       $productId = $request->input('product_id');

       if($request->session()->has('orderItems')) {
           $orderItemOlds = $request->session()->pull('orderItems');

           if(sizeof($orderItemOlds) <= 1){
              foreach ($orderItemOlds as $orderItemOld) { 
                  $request->session()->push('orderItems', $orderItemOld);
              }
              return redirect('/gio-hang');
           }

           foreach ($orderItemOlds as $orderItemOld) { 
               if ($productId != $orderItemOld['product_id']) {
                   $request->session()->push('orderItems', $orderItemOld);
               }
           }
       }

       return redirect('/gio-hang');
   }


   public function submitCheckout(Request $request){
        try{
          $shipName = $request->input('name');
          $shipName = str_replace("<","",$shipName);
          $shipName = str_replace(">","",$shipName);
          $shipName = str_replace(";","",$shipName);  

          $customerNote = $request->input('customer_note');
          $customerNote = str_replace("<","",$customerNote);
          $customerNote = str_replace(">","",$customerNote);
          $customerNote = str_replace(";","",$customerNote);  

          $shipPhone = $request->input('phone_number');
          $shipPhone = str_replace("<","",$shipPhone);
          $shipPhone = str_replace(">","",$shipPhone);
          $shipPhone = str_replace(";","",$shipPhone);   

          $shipAddress = $request->input('address');
          $shipAddress = str_replace("<","",$shipAddress);
          $shipAddress = str_replace(">","",$shipAddress);
          $shipAddress = str_replace(";","",$shipAddress);  
          
          $customer = [
               'ship_name' => $shipName,
               'customer_note' => $customerNote,
               'ship_phone' => $shipPhone,
               'ship_address' => $shipAddress,
           ];
           // insert order item
            $quantities = $request->input('quantity');
            $productIds = $request->input('product_id');
            $this->insertOrder($request, $productIds,$quantities, true);
            $orderItems = Order::getOrderItems();
            if(sizeof($orderItems) <= 0){
              return redirect('/');
            }

           $order = new Order();
           $orderId = $order->insertGetId([
               'status' => '1', // trang thai đặt hàng thành công
               'shipping_name' => $shipName,
               'customer_note' => $customerNote,
               'shipping_phone' => $shipPhone,
               'shipping_address' => $shipAddress,
               'total_price' => 0,
               'method_payment' =>  1,
               'ip_customer' => get_client_ip(),
               'created_at' =>   new \DateTime(),
               'updated_at' =>   new \DateTime()
           ]);
           $notifyAdmin = new Notification();
           $notifyAdmin->insert([
               'title' => 'Đơn hàng',
               'content' => 'Bạn vừa có đơn hàng mới',
               'status' => '0',
               'slug' => '/admin/orders',
               'created_at' => new \DateTime(),
               'updated_at' => new \DateTime()
           ]);

            $hasPromotion = 0;
            $showPromotion = 0;

            // populate free gift
            $freeGift = 0;  
            foreach($orderItems as $orderItem) {
              if($orderItem->promotion_type == 2 && $orderItem->free_gift_id > 0 && $orderItem->promotion_threshold <= $orderItem->quantity){
                 $orderFreeGiftItem = Order::getOrderFreeGiftItems($orderItem->free_gift_id);
                 if(sizeof($orderFreeGiftItem) > 0){
                    $orderItems[sizeof($orderItems)] = $orderFreeGiftItem[0];
                 }
                 $freeGift = 1;
                 break;
              }
           }

           // check free ship promotion
           $freeShip = 0;
           foreach($orderItems as $orderItem) {
              if($orderItem->promotion_type == 1 && $orderItem->promotion_threshold <= $orderItem->quantity){
                 $freeShip = 1;
                 break;
              }
           }

           $discount = 0;
           foreach($orderItems as $orderItem) {
              if($orderItem->promotion_type == 3 && $orderItem->promotion_threshold <= $orderItem->quantity){
                 $discount = 1;
                 break;
              }
           }

           $promotionType = 0;
           if($freeShip ==1){
             $promotionType = 1;
           }
           if($freeGift ==1){
             $promotionType = 2;
           }
           if($discount == 1){
             $promotionType = 3;
           }

           $productName = ""; 
           $totalDiscount = 0; 
           foreach($orderItems as $orderItem) {
               if($orderItem->price > 0){
                   $cost = $orderItem->price;
               }else if($orderItem->hiden_price > 0){
                   $cost = $orderItem->hiden_price;
               }else{
                   $cost = 0;
               }

              $discountItem = 0;
              if($promotionType == 3){
                  if($orderItem->promotion_type == 3 && $orderItem->promotion_threshold <= $orderItem->quantity){
                       $discountItem = $orderItem->promotion_discount;
                       $totalDiscount += $orderItem->promotion_discount;
                    }
               }

               $productName =  $productName . "- " . $orderItem->short_name;
               OrderItem::insert([
                   'product_id' => $orderItem->id,
                   'product_name' => $orderItem->short_name,
                   'quantity' => $orderItem->quantity,
                   'order_id' => $orderId,
                   'cost' => $cost,
                   'promotion_discount' => $discountItem,
                   'origin_price' => $orderItem->origin_price,
                   'free_gift' => $orderItem->is_free_gift,
                   'created_at' =>   new \DateTime(),
                   'updated_at' =>   new \DateTime()
               ]);
           }

           // recalculate total price
           $totalPrice = $this->calculatePrice();
           $costShip = Constant::SHIPPING_FEE;
           if($freeShip == 1){
               $costShip = 0;
           }
           if($totalPrice < Constant::FREESHIP_THRESHOLD){
               $totalPrice += $costShip;
           }else{
               $costShip = 0;
           }
           if($promotionType == 3){
               $totalPrice = $totalPrice - $totalDiscount; 
           }  
           $orderCurrent = Order::where('id', $orderId)->first();
           $orderCurrent->update([
                'total_price' => $totalPrice,
                'customer_ship' => $costShip,
                'product_names'=> $productName,
                'promotion_type' => $promotionType,
                'promotion_discount' => $totalDiscount
            ]);
          
           // giải phóng session
           $request->session()->pull('orderItems');

           return view('order-result', [
                'orderItems'   => $orderItems,
                'orderId'      => $orderId,
                'hasPromotion' => $hasPromotion,
                'showPromotion' => $showPromotion,
                'freeShip'      => $freeShip,
                'shippingFee'   => $costShip,
                'totalAmount'   => $totalPrice,
                'totalDiscount' => $totalDiscount,
                'shippingFeeDefault' => Constant::SHIPPING_FEE,
                'freeShipThreshold' => Constant::FREESHIP_THRESHOLD,
                'customer'      => $customer,
                'pageTitle'     => 'Đơn hàng của bạn',
                'pageKeyword'   => 'Đơn hàng',
                'pageDesc'      => 'Thông tin chi tiết đơn hàng',
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/');
        }
   }

   private function calculatePrice() {
       $orderItems = Order::getOrderItems();
       $totalPrice = 0;
       foreach ($orderItems as $orderItem) {
         if($orderItem->price > 0){
             $totalPrice += $orderItem->price*$orderItem->quantity;
         }else{
             $totalPrice += $orderItem->hiden_price*$orderItem->quantity;
         } 
       }
       return $totalPrice;
   }

    public function trackingCart(Request $request) {
        
            $phone = $request->input('phone');
            $productId = $request->input('productId');
            $productName = $request->input('productName');
            $name = $request->input('name');
            
            TrackingItem::insert([
             'source_product_name' => "GIỎ HÀNG : " . $productName,
             'target_product_name' => "CART INFO : " .$name . " - " . $phone,
             'ip_customer' => get_client_ip(),
             'type' => 4,
             'created_at' =>   new \DateTime(),
             'updated_at' =>   new \DateTime()
            ]);
            
           $orderDb = new Notification();
           $orderDb->insert([
               'title' => 'Giỏ hàng',
               'content' => 'Khách nhập thông tin giỏ hàng',
               'status' => '0',
               'slug' => asset('/admin/trackingitems'),
               'created_at' => new \DateTime(),
               'updated_at' => new \DateTime()
           ]);

            return response([
                'httpCode' => 200
            ])->header('Content-Type', 'text/plain');

        
    }

    
}
