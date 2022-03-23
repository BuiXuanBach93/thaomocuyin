<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RatingNews
 * @package App\Models
 * @version July 30, 2020, 7:20 pm UTC
 *
 * @property string news_id
 * @property integer rating
 * @property string ip
 */
class RatingNews extends Model
{
    use SoftDeletes;

    public $table = 'rating_news';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'news_id',
        'rating',
        'ip'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'news_id' => 'string',
        'rating' => 'integer',
        'ip' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'news_id' => 'required',
        'rating' => 'required'
    ];

    
}
