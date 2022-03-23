<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Log
 * @package App\Models
 * @version August 19, 2019, 5:11 pm UTC
 *
 * @property integer number_crawled
 */
class Log extends Model
{
    use SoftDeletes;

    public $table = 'logs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'number_crawled'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'number_crawled' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'number_crawled' => 'required'
    ];

    
}
