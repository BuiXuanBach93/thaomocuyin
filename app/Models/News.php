<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class News
 * @package App\Models
 * @version February 10, 2020, 8:55 am UTC
 *
 * @property string title
 * @property string slug
 * @property string thumbnail
 * @property string thumbnail_home
 * @property string description
 * @property string content
 * @property string seo_title
 * @property string seo_keyword
 * @property string seo_description
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */
class News extends Model
{
    use SoftDeletes;

    public $table = 'news';
    

    protected $dates = ['deleted_at'];

    const STATUS_ACTIVE = 1;
    const STATUS_UNACTIVE = 2;


    public $fillable = [
        'title',
        'slug',
        'thumbnail',
        'thumbnail_home',
        'description',
        'short_description',
        'content',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'created_at',
        'updated_at',
        'news_category_id',
        'seo_image',
        'status',
        'user_id',
        'public_at',
        'assignee_id',
        'pay_status'
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
        'thumbnail' => 'string',
        'thumbnail_home' => 'string',
        'description' => 'string',
        'content' => 'string',
        'seo_title' => 'string',
        'seo_keyword' => 'string',
        'seo_description' => 'string',
        'seo_image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'updated_at' => 'featured boolean'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function news_category()
    {
        return $this->hasOne('App\Models\NewsCategory', 'id', 'news_category_id');
    }


    /**
     * Truong hop nhieu du lieu: lay 6 bai cung category & order từ mới nhất
     * Truong hop it du lieu: ; lay 6 bai cung category & order từ cũ nhất
     */
    public function getRelated($news, $category) {
        $newses = News::where('news_category_id', $category->id)
                    ->where('id', '<', $news->id)
                    ->where('status', '=', News::STATUS_ACTIVE)
                    ->whereNull('canonical')
                    ->orderBy('id', 'DESC')
                    ->limit(6)->get();
        
        if (count($newses) == 6) {
            return $newses;
        }

        return News::where('news_category_id', $category->id)
                    ->where('id', '!=', $news->id)
                    ->where('status', '=', News::STATUS_ACTIVE)
                    ->whereNull('canonical')
                    ->orderBy('id', 'ASC')
                    ->limit(6)->get();
    }


    public function getNewsets($news, $categoryID, $limit=10) {
        return News::where('news_category_id', $categoryID)
                    ->where('status', '=', News::STATUS_ACTIVE)
                    ->whereNull('canonical')
                    ->orderBy('id', 'DESC')
                    ->limit($limit)->get();
    }
}
