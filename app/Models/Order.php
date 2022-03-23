<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * Class Order
 * @package App\Models
 * @version August 11, 2019, 4:42 pm UTC
 *
 * @property integer product_id
 * @property integer number
 * @property string color
 * @property string user_name
 * @property string phone_number
 * @property string address
 * @property string note
 */
class Order extends Model
{
    use SoftDeletes;

    public $table = 'orders';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'total_price',
        'shipping_address',
        'shipping_city',
        'shipping_name',
        'shipping_email',
        'shipping_phone',
        'status',
        'is_redeem_origin',
        'is_shared_profit',
        'method_payment',
        'cost_ship',
        'cost_point',
        'customer_ship',
        'shipping_code',
        'ip_customer',
        'note_admin',
        'note_stock',
        'customer_note',
        'current_city',
        'is_delivery',
        'order_source',
        'have_refund_order',
        'is_mail_customer',
        'visiable',
        'deleted_at',
        'created_at',
        'updated_at',
        'delivery_at',
        'product_names',
        'promotion_type',
        'promotion_discount'
    ];


    public static function countOrder() {
        try {
            $orderItems = session('orderItems');
            return count($orderItems);
        } catch (\Exception $e) {
            return 0;
        }
    }

    public static function  getOrderItems() {
        try {
            $orderItems = session('orderItems');
            if(!isset($orderItems)){
                $ipClient = get_client_ip();
                $cartItems = DB::select('SELECT it.product_id FROM cart_items it WHERE it.deleted_at IS NULL AND it.ip_customer = :ipClient ORDER BY id DESC LIMIT 1',['ipClient'=>$ipClient]);  
                if(sizeof($cartItems) > 0){
                    $orderItems = array();
                    $orderItems[0]['quantity'] = 1;
                    $orderItems[0]['product_id'] = $cartItems[0]->product_id;
                }else{
                    return $orderItems = null;
                }
            }
            
            $productIds = array();
            $quantityWithProduct = array();
            foreach ($orderItems as $orderItem) {
                $productIds[] = $orderItem['product_id'];
                $quantityWithProduct[$orderItem['product_id']] = $orderItem['quantity'];
            }
            $orderItemDetail = Product::join('categories', 'products.category_id', '=', 'categories.id')
                ->select('products.*','categories.slug as category_slug')
                ->whereIn('products.id', $productIds)->get();
            foreach ($orderItemDetail as $id => $orderItem ) {
                $orderItemDetail[$id]->quantity = $quantityWithProduct[$orderItem->id];
            }

            return $orderItemDetail;
        } catch (\Exception $e) {
            Log::error('Entity->Order->getOrderItems: Lỗi lấy ra tất cả thành phần của đơn hàng');

            return array();
        }
    }


    public static function  getOrderFreeGiftItems($freeGiftId) {
        
            $orderItemDetail = Product::where('id', $freeGiftId)
                ->get();
            foreach ($orderItemDetail as $id => $orderItem ) {
                $orderItemDetail[$id]->quantity = 1;
            }
            return $orderItemDetail;
        
    }

    public static function getUserOrderProduct($productId ) {
        try {
            $orderModel = new Order();

            $userIds = $orderModel->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
                ->join('products', 'products.product_id', '=', 'order_items.product_id')
                ->select('user_id', 'orders.created_at')
                ->where('user_id', '>', 0)
                ->where('products.post_id', $productId)
                ->get()->toArray();

            return $userIds;
        } catch(\Exception $e) {
            Log::error('Entity->Order->getUserOrderProduct: Lỗi lấy user id của đơn hàng');

            return null;
        }
    }

    public static function getTotalOrder ($userId) {
        $totalOrder = static::where('user_id', $userId)->count();

        return $totalOrder;
    }
    
}
