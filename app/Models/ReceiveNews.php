<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class receive_news
 * @package App\Models
 * @version June 10, 2019, 12:00 pm UTC
 *
 * @property string email
 * @property string ip
 */
class ReceiveNews extends Model
{
    use SoftDeletes;

    public $table = 'receive_news';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'email',
        'ip'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'email' => 'string',
        'ip' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'email' => 'required|email'
    ];


}
