<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category
 * @package App\Models
 * @version May 14, 2019, 4:29 am UTC
 *
 * @property string title
 * @property string slug
 * @property string seo_keyword
 * @property string seo_description
 */
class Contact extends Model
{
    use SoftDeletes;

    public $table = 'contacts';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'email',
        'phone_number',
        'address',
        'message',
        'reply',
        'content',
        'is_ordered',
        'order_id',
        'admin_note',
        'appointment_date',
        'type',
        'status',
        'content',
        'pass_to',
        'ip_customer'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'        => 'integer',
        'name'      => 'string',
        'email'     => 'string',
        'phone_number' => 'string',
        'message'   => 'string',
        'reply'     => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name'      => 'required',
        'phone_number' => 'required',
        'message'   => 'required'
    ];
}
