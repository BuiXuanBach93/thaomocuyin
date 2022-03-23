<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class NewsCategory
 * @package App\Models
 * @version February 19, 2020, 9:42 am UTC
 *
 * @property string(255) title
 * @property string(255) slug
 * @property string(255) seo_keyword
 */
class NewsCategory extends Model
{
    use SoftDeletes;

    public $table = 'news_categories';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'slug',
        'content',
        'seo_title',
        'seo_keyword',
        'seo_description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];


     /**
     * Get all categories nane
     * return array [category_id]['category_name']
     */
    public function getAllName() {
        $categories = NewsCategory::all();
        $result = [];
        foreach($categories as $cate) {
            $result[$cate->id] = $cate->title;
        }

        return $result;
    }
    
}
