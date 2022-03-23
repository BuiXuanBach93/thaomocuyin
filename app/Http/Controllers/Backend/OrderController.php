<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Support\Facades\View;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class OrderController extends AppBaseController
{

    protected $role;

    public function __construct()
    {
        try {
            $countNotification = new Notification();
            $countReport = $countNotification->countReport();
            $notifications = Notification::orderBy('id', 'desc')
                ->offset(0)->limit(10)->get();

        } catch (\Exception $e) {
            $countReport = 0;
            $notifications = array();
            $typeSubPostsAdmin = array();
        } finally {
            view()->share([
                'countRp'=>$countReport,
                'notifications'=>$notifications
            ]);
        }
    }

    public function listOrder(Request $request) {
        
            $orders = Order::orderBy('id', 'desc')
                ->where('status', '>=', 0);

            if (!empty($request->input('order_id'))) {
                $orders = $orders->where('id', '=', $request->input('order_id'));
            }
            if (!empty($request->input('phone'))) {
                $orders = $orders->where('shipping_phone', 'like', '%'.$request->input('phone').'%');
            }
            if (!empty($request->input('email'))) {
                $orders = $orders->where('shipping_email', 'like', '%'.$request->input('email').'%');
            }
            if (!empty($request->input('name'))) {
                $orders = $orders->where('shipping_name', 'like', '%'.$request->input('name').'%');
            }
            if (!empty($request->input('user_id'))) {
                $orders = $orders->where('user_id', '=', $request->input('user_id'));
            }
            if (!empty($request->input('status')) && $request->input('status') >= 0) {
                $status = $request->input('status') - 1;
                $orders = $orders->where('status', '=', $status);
            }
            if (!empty($request->input('order_source')) && $request->input('order_source') >= 0) {
                $orderSource = $request->input('order_source') - 1;
                $orders = $orders->where('order_source', '=', $orderSource);
            }
    
            if (!empty($request->input('is_delivery')) && $request->input('is_delivery') >= 0) {
                $stockStatus = $request->input('is_delivery') - 1;
                $orders = $orders->where('is_delivery', '=', $stockStatus)->where('status', '>', 0);
            }   
            if (!empty($request->input('current_city'))) {
                $orders = $orders->where('current_city', '=', 1);
            }
            if (!empty($request->input('product_names'))) {
                $productName = $request->input('product_names');
                $orders = $orders->where('product_names', 'like', '%'.strtoupper($productName).'%');
            }
            if (!empty($request->input('user_id'))) {
                $orders = $orders->where('user_id', '=', $request->input('user_id'));
            }
            if ($request->input('is_search_time') == 1) {
                $startEnd = $request->input('search_start_end');
                $time = explode('-', $startEnd);
                $start = $time[0];
                $end = $time[1];
                $orders = $orders->where('created_at', '>=', new \DateTime($start))
                    ->where('created_at', '<=', new \DateTime($end));
            }
            $totalRevenue = 0;
            $totalPrice = 0;
            $totalShip = 0;
            $totalOrigin = 0;
            $totalOrders = 0;
            $closeOrders = 0;
            $deliveryOrders = 0;
            $confirmOrders = 0;
            $notConfirmOrders = 0;
            $returnOrders = 0;
            $cancelOrders = 0;
            $currentCity = 0;
            if (!empty($request->input('is_cal_revenue'))) {
                $orderIdCalFrom = 0;
                $orderIdCalTo = 0;
                $ordersCalQr =  Order::where('status', '>=', 0);
                if(!empty($request->input('order_id'))){
                    $orderIdCal = explode(",",$request->input('order_id'));
                    if(sizeof($orderIdCal) > 1){
                        $orderIdCalFrom = $orderIdCal[0];
                        $orderIdCalTo = $orderIdCal[1];
                    }else{
                        $orderIdCalFrom = $orderIdCal[0];
                    }

                    $ordersCalQr = $ordersCalQr->where('id', '>=', $orderIdCalFrom)->where('status', '>=', 0);
                    if($orderIdCalTo > 0){
                        $ordersCalQr =  $ordersCalQr->where('id', '>=', $orderIdCalFrom)->where('id', '<=', $orderIdCalTo)->where('status', '>=', 0);
                    }
                }

                if ($request->input('is_search_time') == 1) {
                $startEnd = $request->input('search_start_end');
                $time = explode('-', $startEnd);
                $start = $time[0];
                $end = $time[1];

                $ordersCalQr = $ordersCalQr->where('created_at', '>=', new \DateTime($start))->where('created_at', '<=', new \DateTime($end))->where('status', '>=', 0);
                }
                $ordersCal = $ordersCalQr->get();
                foreach($ordersCal as $id => $order) {
                $ordersCal[$id]->orderItems = OrderItem::join('products','products.id','=', 'order_items.product_id')
                    ->select(
                        'products.*',
                        'order_items.*'
                    )
                    ->where('order_id', $order->id)->get();
                    if($order->status > 0){
                        if($order->status < 5){
                            $totalPrice += $order->total_price;
                            foreach ($ordersCal[$id]->orderItems as $orderItem) {
                                $totalOrigin += $orderItem->origin_price * $orderItem->quantity;
                            }
                        }
                        $totalShip += $order->cost_ship;
                    }
                    $totalOrders += 1;
                    if($order->status == 0){
                       $cancelOrders +=1;     
                    }
                    if($order->status == 1){
                       $notConfirmOrders +=1;     
                    }
                    if($order->status == 2){
                       $confirmOrders +=1;     
                    }
                    if($order->status == 3){
                       $deliveryOrders +=1;     
                    }
                    if($order->status == 4){
                       $closeOrders +=1;     
                    }
                    if($order->status == 5){
                       $returnOrders +=1;     
                    }
                    if($order->current_city == 1){
                        $currentCity +=1;
                    }
                }

                $totalRevenue = $totalPrice - $totalOrigin - $totalShip;

                $orders = Order::orderBy('id', 'desc')
                ->where('ưid', '>=', $orderIdCalFrom)->where('status', '>=', 0);

                if($orderIdCalTo > 0){
                    $orders = Order::orderBy('id', 'desc')
                ->where('id', '>=', $orderIdCalFrom)->where('id', '<=', $orderIdCalTo)->where('status', '>=', 0);
                }

                if ($request->input('is_search_time') == 1) {
                $startEnd = $request->input('search_start_end');
                $time = explode('-', $startEnd);
                $start = $time[0];
                $end = $time[1];

                $orders = Order::orderBy('id', 'desc')->where('created_at', '>=', new \DateTime($start))->where('created_at', '<=', new \DateTime($end))->where('status', '>=', 0);
                }

                $orders = $orders->paginate(100);
                $orders->appends(['status' => $request->input('status')]);
                $orders->appends(['current_city' => $request->input('current_city')]);
                $orders->appends(['is_search_time' => $request->input('is_search_time')]);
                $orders->appends(['search_start_end' => $request->input('search_start_end')]);

                foreach($orders as $id => $order) {
                    $orders[$id]->orderItems = OrderItem::join('products','products.id','=', 'order_items.product_id')
                        ->select(
                            'products.*',
                            'order_items.*'
                        )
                        ->where('order_id', $order->id)->get();
                }

                return view('orders.list', compact('orders','totalPrice','totalOrigin','totalShip', 'totalRevenue', 'totalOrders','cancelOrders','notConfirmOrders','confirmOrders','deliveryOrders','closeOrders','returnOrders','currentCity'));
            }

            $orders = $orders->paginate(100);
            $orders->appends(['status' => $request->input('status')]);
            $orders->appends(['order_source' => $request->input('order_source')]);
            $orders->appends(['is_search_time' => $request->input('is_search_time')]);
            $orders->appends(['search_start_end' => $request->input('search_start_end')]);
            $orders->appends(['current_city' => $request->input('current_city')]);
            $orders->appends(['is_delivery' => $request->input('is_delivery')]);
            $orders->appends(['phone' => $request->input('phone')]);
            $orders->appends(['email' => $request->input('email')]);
            $orders->appends(['product_names' => $request->input('product_names')]);
            $orders->appends(['user_id' => $request->input('user_id')]);

            foreach($orders as $id => $order) {
                $orders[$id]->orderItems = OrderItem::join('products','products.id','=', 'order_items.product_id')
                    ->select(
                        'products.*',
                        'order_items.*'
                    )
                    ->where('order_id', $order->id)->get();
            }
            return view('orders.list', compact('orders','totalPrice','totalOrigin','totalShip', 'totalRevenue','totalOrders','cancelOrders','notConfirmOrders','confirmOrders','deliveryOrders','closeOrders','returnOrders','currentCity'));
        

    }


    public function updatePriceOrder(Request $request) {
        
            $orderId = $request->input('order_id');
            $order = Order::where('id', $orderId)->first();
            $customer_ship = !empty($request->input('customer_ship')) ? str_replace(".", "", $request->input('customer_ship')) : 0;
            $promotionDiscount = !empty($request->input('promotion_discount')) ? str_replace(".", "", $request->input('promotion_discount')) : 0;
            $orderItems = OrderItem::where('order_id', $orderId)->get();
            $leng = count($orderItems);
            for($i = 0; $i < $leng; $i++){
                $originPrice = !empty($request->input('origin_price')[$i]) ? str_replace(".", "", $request->input('origin_price')[$i]) : 0;

                $cost = !empty($request->input('cost')[$i]) ? str_replace(".", "", $request->input('cost')[$i]) : 0;
                $quantity = $request->input('quantity')[$i];  
                $itemId = $request->input('item_id')[$i]; 
                $orderItem = OrderItem::where('id', $itemId)->first();

                $orderItem->update([
                    'origin_price' => $originPrice,
                    'cost' => $cost,
                    'quantity' => $quantity,
                ]);

            }

            $orderItems = OrderItem::where('order_id', $orderId)->get();
            $totalPrice = 0;
            foreach ($orderItems as $orderItem) {
                $totalPrice += $orderItem->cost*$orderItem->quantity;
            }

            $totalPrice = $totalPrice + $customer_ship - $promotionDiscount;
            $order->update([
                'customer_ship' => $customer_ship,
                'promotion_discount' => $promotionDiscount,
                'total_price' => $totalPrice,
                'shipping_address' => $request->input('shipping_address'),
                'shipping_name' => $request->input('shipping_name'),
                'shipping_phone' => $request->input('shipping_phone'),
            ]);
        

        return redirect(route('admin.orderAdmin.show', ['order_id' => $orderId]));

    }

    public function updateStatusOrder(Request $request) {
        
            $orderId = $request->input('order_id');
            $status = $request->input('status');
            $noteStock = $request->input('note_stock');
            $orderSource = $request->input('order_source');
            $noteAdmin = $request->input('noteAdmin');
            $noteCustomer = $request->input('customer_note');
            $shippingCode = $request->input('shipping_code');
            $costShip = !empty($request->input('cost_ship')) ? str_replace(".", "", $request->input('cost_ship')) : 0;
            $order = Order::where('id', $orderId)->first();
            $currentStatus = $order->status;
            $current_date_time = date('Y-m-d H:i:s');
            $order->update([
                'status' => $status,
                'order_source' => $orderSource,
                'note_admin' => $noteAdmin,
                'customer_note' => $noteCustomer,
                'cost_ship' => $costShip,
                'shipping_code' => $shippingCode,
                'note_stock' => $noteStock,
                'is_delivery' => $request->has('is_delivery') ? 1 : 0,
                'current_city' => $request->has('current_city') ? 1 : 0,   
            ]);

            if($status == 0){
                if($order->is_delivery == 1){
                    $order->update([
                    'delivery_at' => null,
                    'is_delivery' => 0
                    ]);

                   // $orderItems = OrderItem::where('order_id', $orderId)->get();
                    /*foreach($orderItems as $orderItem) {
                        $product = Product::where('id', $orderItem->product_id)->first();
                        $vitualAts = $product->available + $orderItem->quantity;    
                        $realAts = $product->ats + $orderItem->quantity;
                        $product->update([
                            'available' =>  $vitualAts,
                            'ats' => $realAts
                        ]);
                    }*/
                }
            }

            if($request->has('is_delivery')){
                $statusUpdated = $order->status;
                if($statusUpdated == 2){
                    $statusUpdated = 3;
                    $order->update([
                    'delivery_at' => $current_date_time,
                    'status' => $statusUpdated
                    ]);

                   // $orderItems = OrderItem::where('order_id', $orderId)->get();
                    /*foreach($orderItems as $orderItem) {
                        $product = Product::where('product_id', $orderItem->product_id)->first();
                        $currentAvailable = $product->available;
                        $vitualAts = 88;
                        if($currentAvailable > ($orderItem->quantity + 5)){
                            $vitualAts = $currentAvailable - $orderItem->quantity;    
                        }
                        $realAts = $product->ats;
                        if($realAts > $orderItem->quantity){
                            $realAts = $realAts - $orderItem->quantity;
                        }
                        $product->update([
                            'available' =>  $vitualAts,
                            'ats' => $realAts
                        ]);
                    }*/
                }
                
            }else{
                $status = $order->status;
                if($status == 3){
                    $status = 2;
                    $order->update([
                    'delivery_at' => null,
                    'status' => $status
                    ]);

                    /*$orderItems = OrderItem::where('order_id', $orderId)->get();
                    foreach($orderItems as $orderItem) {
                        $product = Product::where('product_id', $orderItem->product_id)->first();
                        $vitualAts = $product->available + $orderItem->quantity;    
                        $realAts = $product->ats + $orderItem->quantity;
                        $product->update([
                            'available' =>  $vitualAts,
                            'ats' => $realAts
                        ]);
                    }*/
                }
                
            }
             
            $this->insertAppointment($request, $order);



        return redirect(route('admin.orderAdmin'));

    }

    public function deleteOrder(Order $order) {

            OrderItem::where('order_id', $order->id)->delete();

            $order->delete();
        
            return redirect(route('admin.orderAdmin'));
        
    }

    public function showOrder(Order $order) {
            //update refund order
           $orderRefund = Order::where('shipping_phone', $order->shipping_phone)->where('status', 5)->count();
           if($orderRefund > 0){
              $orderRefund = 1;
           }else{
              $orderRefund = 0;
           } 
           $order->have_refund_order = $orderRefund; 
            // get order items
            $orderItems = OrderItem::join('products','products.id','=', 'order_items.product_id')
                ->select(
                    'products.*',
                    'order_items.*'
                )
                ->where('order_id', $order->id)->get();

            return view('orders.detail', compact('order', 'orderItems'));
    }

    
    public function listOrderForStocker(Request $request) {
       
            $orders = Order::orderBy('created_at', 'desc')
                ->whereIn('status', [0, 2, 3]);

            if (!empty($request->input('order_id'))) {
                $orders = $orders->where('id', 'like', '%'.$request->input('order_id').'%');
            }
            if (!empty($request->input('phone'))) {
                $orders = $orders->where('shipping_phone', 'like', '%'.$request->input('phone').'%');
            }
            if (!empty($request->input('email'))) {
                $orders = $orders->where('shipping_email', 'like', '%'.$request->input('email').'%');
            }
            if (!empty($request->input('name'))) {
                $orders = $orders->where('shipping_name', 'like', '%'.$request->input('name').'%');
            }
            if (!empty($request->input('current_city'))) {
                $orders = $orders->where('current_city', '=', 1);
            }
            
            if (!empty($request->input('is_delivery')) && $request->input('is_delivery') >= 0) {
                $stockStatus = $request->input('is_delivery') - 1;
                $orders = $orders->where('is_delivery', '=', $stockStatus)->where('status', '>', 0);
            }
        
            $totalOrders = 0;
            $closeOrders = 0;
            $deliveryOrders = 0;
            $confirmOrders = 0;
            $notConfirmOrders = 0;
            $returnOrders = 0;
            $cancelOrders = 0;

            $orders = $orders->paginate(100);
            $orders->appends(['phone' => $request->input('phone')]);
            $orders->appends(['email' => $request->input('email')]);
            $orders->appends(['user_id' => $request->input('user_id')]);
            $orders->appends(['current_city' => $request->input('current_city')]);

            foreach($orders as $id => $order) {
                $orders[$id]->orderItems = OrderItem::join('products','products.id','=', 'order_items.product_id')
                    ->select(
                        'products.*',
                        'order_items.*'
                    )
                    ->where('order_id', $order->id)->get();
            }
            return view('orders.list_stock', compact('orders','totalOrders','cancelOrders','notConfirmOrders','confirmOrders','deliveryOrders','closeOrders','returnOrders'));
        

    }


    public function showOrderForStocker(Order $order) {
       
            $orderItems = OrderItem::join('products','products.id','=', 'order_items.product_id')
                ->select(
                    'products.*',
                    'order_items.*'
                )
                ->where('order_id', $order->id)->get();

            return view('orders.detail_stock', compact('order', 'orderItems'));
       

    }

    public function updateOrderStock(Request $request) {
       
            $orderId = $request->input('order_id');
            $noteStock = $request->input('note_stock');
            $shippingCode = $request->input('shipping_code');
            $current_date_time = date('Y-m-d H:i:s');
            $order = Order::where('id', $orderId)->first();
            $order->update([
                'note_stock' => $noteStock,
                'delivery_at' => $current_date_time,
                'shipping_code'=>$shippingCode,
                'is_delivery' => $request->has('is_delivery') ? 1 : 0
            ]);

            if($request->has('is_delivery')){
                $status = $order->status;
                if($status == 2){
                    $status = 3;
                    $order->update([
                    'delivery_at' => $current_date_time,
                    'status' => $status
                    ]);

                    $orderItems = OrderItem::where('order_id', $orderId)->get();
                    foreach($orderItems as $orderItem) {
                        $product = Product::where('id', $orderItem->product_id)->first();
                        $currentAvailable = $product->available;
                        $vitualAts = 88;
                        if($currentAvailable > ($orderItem->quantity + 5)){
                            $vitualAts = $currentAvailable - $orderItem->quantity;    
                        }
                        $realAts = $product->ats;
                        if($realAts > $orderItem->quantity){
                            $realAts = $realAts - $orderItem->quantity;
                        }
                        $product->update([
                            'available' =>  $vitualAts,
                            'ats' => $realAts
                        ]);
                    }
                }
            }else{
                $status = $order->status;
                if($status == 3){
                    $status = 2;
                    $order->update([
                    'delivery_at' => null,
                    'status' => $status
                    ]);

                    $orderItems = OrderItem::where('order_id', $orderId)->get();
                    foreach($orderItems as $orderItem) {
                        $product = Product::where('id', $orderItem->product_id)->first();   
                        $realAts = $product->ats + $orderItem->quantity;
                        $product->update([
                            'ats' => $realAts
                        ]);
                    }
                }
            }

        
            return redirect(route('admin.orderStocker'));
        

    }

    private function insertAppointment($request, $order) {
        
            $orderId = $order->id;
            $currentContact = Contact::where('order_id', $orderId)->first();
            if($currentContact != null){
                if($request->input('status') == 0){
                    $currentContact->delete();
                }else{
                    return;
                }
            }
            if($request->input('status') != 2){
                return;
            }
            $appDateStr = $request->input('appointment_date_str');
            $appDate = null;
            if($appDateStr){
                $appDate = new \DateTime($appDateStr);
            }else{
                return;
            }
            $contact = new Contact();
            $contact->insert([
                'name' => $order->shipping_name,
                'phone_number' => $order->shipping_phone,
                'email' => 'no-email@gmail.com',
                'address' => $order->shipping_address,
                'message' => $order->product_names,
                'type' => 1,
                'reply' => 0,
                'appointment_date'=>$appDate,
                'order_id' => $orderId,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
        
    }

}
