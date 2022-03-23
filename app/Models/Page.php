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
class Page extends Model
{
    use SoftDeletes;

    public $table = 'pages';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'slug',
        'content',
        'seo_description',
        'seo_keyword',
        'seo_image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'slug' => 'string',
        'content' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'slug' => 'required',
        'content' => 'required'
    ];
}
