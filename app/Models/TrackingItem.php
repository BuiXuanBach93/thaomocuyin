<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class rating
 * @package App\Models
 * @version June 10, 2019, 5:26 am UTC
 *
 * @property required product_id
 * @property required rating
 * @property string ip
 */
class 
TrackingItem extends Model
{
    use SoftDeletes;

    public $table = 'tracking_items';

    const IS_ADMIN_FALSE = 2;
    const IS_ADMIN_TRUE = 1;

    protected $dates = ['deleted_at'];


    public $fillable = [
        'id',
        'type',
        'source_product_id',
        'source_product_name',
        'target_product_name',
        'target_product_id',
        'ip_customer'
    ];

}
