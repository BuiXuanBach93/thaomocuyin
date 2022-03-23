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
class Category extends Model
{
    use SoftDeletes;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    public function __construct()
    {
        parent::__construct();
    }

    public $table = 'categories';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'title',
        'slug',
        'content',
        'seo_keyword',
        'seo_title',
        'seo_description',
        'parent_id',
        'status',
        'image',
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
        'seo_title' => 'string',
        'seo_description' => 'string',
        'parent_id',
        'status'
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

    /**
     * Get all categories nane
     * return array [category_id]['category_name']
     */
    public function getAllName($onlyParent = false) {
        if ($onlyParent) {
            $categories = Category::whereNull('parent_id')->where('status', Category::STATUS_ACTIVE)->get();
        } else {
            $categories = Category::where('status', Category::STATUS_ACTIVE);
        }
        $result = [];
        foreach($categories as $cate) {
            $result[$cate->id] = $cate->title;
        }

        return $result;
    }

    /**
     * Get name of all sub categories
     * return array [category_id]['category_name']
     */
    public function getNameSubCategories() {
        $categories = Category::whereNotNull('parent_id')->where('status', Category::STATUS_ACTIVE)->get();
        
        $result = [];
        foreach($categories as $cate) {
            $result[$cate->id] = $cate->title;
        }

        return $result;
    }


    /**
     * Get name of all sub categories
     * return array [category_id]['category_name']
     */
    public function getNameAllCategories() {
        $categories = Category::where('status', Category::STATUS_ACTIVE)->get();
        
        $result = [];
        foreach($categories as $cate) {
            $result[$cate->id] = $cate->title;
        }

        return $result;
    }

        /**
     * Get name of all sub categories
     * return array [category_id]['category_name']
     */
    public function getNameAllCategoriesToUpdate() {
        $categories = Category::where('status', Category::STATUS_ACTIVE)->get();
        
        $result = [];
        $result[0] = '-- Chọn --';
        foreach($categories as $cate) {
            $result[$cate->id] = $cate->title;
        }

        return $result;
    }

    /**
     * Get all categories slug
     * return array [category_id]['category_name']
     */
    public function getAllSlug() {
        $categories = Category::where('status', Category::STATUS_ACTIVE);
        $result = [];
        foreach($categories as $cate) {
            $result[$cate->id] = $cate->slug;
        }

        return $result;
    }

    public function getProductNumber() {
        $categories = Category::all();
        $result = [];
        foreach($categories as $cate) {
            if ($cate->parent_id) { # It is child
                $result[$cate->id] = $cate->hasMany(Product::class)->whereNull('deleted_at')->count();
            } else {
                $childrenIDs = [];
                foreach($categories as $child) {
                    if ($child->parent_id == $cate->id) {
                        $childrenIDs[] = $child->id;
                    }
                }
                $result[$cate->id] = Product::whereIn('category_id', $childrenIDs)->whereNull('deleted_at')->count();
            }
        }

        return $result;
    }

    /**
     * Get all category
     */
    public function getMenuCategory() {
        $parentCategories = Category::whereNull('parent_id')
                                    ->where('id','<>',1)
                                    ->where('status', Category::STATUS_ACTIVE)->get();
        $result = [];
        foreach($parentCategories as $cate) {
            $children = Category::where('parent_id', $cate->id)
                                ->where('status', Category::STATUS_ACTIVE)->get();
            $childrenInfo = [];
            if ($children) {
                foreach ($children as $child) {
                    $childrenInfo[$child->id] = [
                        'id'    => $cate->id,
                        'title'=> $child->title,
                        'slug' => $child->slug,
                    ];
                }
            }
            $result[$cate->id] = [
                'id'    => $cate->id,
                'title' => $cate->title,
                'slug'  => $cate->slug,
                'image'  => $cate->image,
                'children'  => $childrenInfo
            ];
        }

        return $result;
    }

    /**
     * Get product and category
     */
    public function getCategoryProduct($ignoreProductIDs=[]) {
        $parentCategories = Category::whereNull('parent_id')
                                    ->where('status', Category::STATUS_ACTIVE)->get();
        $productModel = new Product();
        $result = [];
        foreach($parentCategories as $cate) {
            $children = Category::where('parent_id', $cate->id)
                                ->where('status', Category::STATUS_ACTIVE)->get();
            $childrenInfo = [];
            if ($children) {
                foreach ($children as $child) {
                    $childrenInfo[$child->id] = [
                        'title'=> $child->title,
                        'slug' => $child->slug,
                        'product' => $productModel->getNewest($ignoreProductIDs, 20, $child->id)->get(),
                        'is_important' => $child->is_important,
                    ];
                }
            }
            $result[$cate->id] = [
                'title'=> $cate->title,
                'slug' => $cate->slug,
                'product' => $productModel->getNewest($ignoreProductIDs, 20, $cate->id)->get(),
                'children'  => $childrenInfo
            ];
        }

        return $result;
    }
}
