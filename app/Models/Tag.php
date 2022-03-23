<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Tag
 * @package App\Models
 * @version May 15, 2019, 1:50 pm UTC
 *
 * @property string title
 * @property string slug
 */
class Tag extends Model
{
    use SoftDeletes;

    public $table = 'tags';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'slug',
        'order',
        'seo_keyword',
        'seo_description'
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
        'seo_keyword' => 'string',
        'seo_description' => 'string',
        'order' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'slug' => 'required'
    ];


    public function newses() {
        return $this->belongsToMany('App\Models\Product', 'news_tags', 'product_id', 'tag_id');
    }

    /**
     * Get all tagss nane
     * return array [tag_id]['tag_name']
     */
    public function getAllName() {
        $tags = Tag::all();
        $result = [];
        foreach($tags as $tag) {
            $result[$tag->id] = $tag->title;
        }

        return $result;
    }

}
