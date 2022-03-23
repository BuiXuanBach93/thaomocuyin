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
Rating extends Model
{
    use SoftDeletes;

    public $table = 'ratings';

    const IS_ADMIN_FALSE = 2;
    const IS_ADMIN_TRUE = 1;

    protected $dates = ['deleted_at'];


    public $fillable = [
        'product_id',
        'rating',
        'customer_name',
        'content',
        'ip',
        'phone_number',
        'is_admin',
        'parent_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'ip' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'rating' => 'integer'
    ];

    public function subRating()
    {
        return $this->hasMany('App\Models\Rating', 'parent_id');
    }

}
