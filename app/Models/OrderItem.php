<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Page
 * @package App\Models
 * @version June 30, 2020, 10:41 am UTC
 *
 * @property string title
 * @property string slug
 * @property string content
 */
class OrderItem extends Model
{
    use SoftDeletes;

    public $table = 'order_items';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'product_id',
        'product_name',
        'order_id',
        'description',
        'currency',
        'quantity',
        'cost',
        'origin_price',
        'free_gift',
        'promotion_discount',
        'properties',
        'created_at',
        'deleted_at',
        'updated_at'
    ];
}
