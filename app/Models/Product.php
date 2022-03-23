<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use App\Models\Category;
use Illuminate\Foundation\Console\Presets\None;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 * @package App\Models
 * @version May 8, 2019, 4:38 am UTC
 *
 * @property string title
 * @property string slug
 * @property integer category_id
 * @property string thumbnail
 * @property string description
 * @property string content
 * @property string
 * @property string seo_title
 * @property string seo_description
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */
class Product extends Model
{

    public $table = 'products';

    const FEATURED_TRUE = 1;
    const FEATURED_FALSE = 0;

    const DISCOUNT_TYPE_MONEY = 1;
    const DISCOUNT_TYPE_PERCENT = 2;

    const STATUS_ACTIVE = 1;
    const STATUS_UNACTIVE = 2;

    use SoftDeletes;

    public $fillable = [
        'title',
        'slug',
        'category_id',
        'thumbnail',
        'thumbnail_home',
        'description',
        'content',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'created_at',
        'updated_at',
        'featured',
        'featured_home',
        'price',
        'origin_price',
        'hidden_price',
        'color',
        'sku',
        'quantity',
        'quantity_sold',
        'discount_type',
        'discount',
        'notes',
        'order',
        'provider_id',
        'seo_image',
        'status',
        'just_view',
        'user_id',
        'image_list',
        'assignee_id',
        'tag_list',
        'ats',
        'expired_date',
        'is_free_gift',
        'promotion_type',
        'promotion_content',
        'promotion_threshold',
        'promotion_discount',
        'free_gift_id',
        'short_name',
        'popular_tag',
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
        'category_id' => 'integer',
        'thumbnail' => 'string',
        'thumbnail_home' => 'string',
        'description' => 'string',
        'content' => 'string',
        'seo_title' => 'string',
        'seo_keyword' => 'string',
        'seo_description' => 'string',
        'price'     => 'integer',
        'color'     => 'string',
        'discount_type' => 'tinyinteger',
        'discount' => 'float',
        'notes' => 'notes',
        'quantity' => 'integer',
        'quantity_sold' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        // 'content' => 'required',
        'slug' => 'required|unique:products,id',
        'category_id' => 'required',
        // 'thumbnail' => 'required',
        // 'seo_title' => 'required',
        // 'description' => 'required',
        'updated_at' => 'exit'
    ];

    public function provider()
    {
        return $this->belongsTo('App\Models\Provider');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\Rating', 'product_id', 'id');
    }

    public function productTags()
    {
        return $this->hasMany('App\Models\ProductTag', 'product_id', 'id');
    }

    public function tags() {
        return $this->belongsToMany('App\Models\Tag', 'product_tags', 'product_id', 'tag_id');
    }

    public function getCateNameByID($cateID) {
        $cate = Category::findOrFail($cateID);
        return $cate->title;
    }

    public function getAssignee($assigneeID) {
        $users = User::where('id', $assigneeID)->get();
        if($users->count() > 0){
            return $users[0]->name;
        }else{
            return "Chưa giao";
        }
    }

    public function getFeaturedHome($limit=4) {
        $query = Product::select('products.*', 'categories.slug as category_slug', 'categories.title as category_title')
                        ->join('categories', 'category_id', 'categories.id')
                        ->where('products.status', '=', Product::STATUS_ACTIVE);
        return $query->where([
            ['featured_home', '=', Product::FEATURED_TRUE]
        ])->limit($limit)->orderBy('order', 'DESC')->get();
    }


    public function getNewest($ignoreProductIDs=[], $limit=8, $cateID=0, $isPopular=False, $keyword='') {
        $query = Product::select('products.*', 'categories.slug as category_slug', 'categories.title as category_title')
                        ->join('categories', 'category_id', 'categories.id')
                        ->where('products.status', '=', Product::STATUS_ACTIVE);

        $condition = [];
        if ($isPopular) {
            $condition[] = ['featured', '=', Product::FEATURED_TRUE];
        }

        if ($cateID) {
            $cateModel = Category::where('id', $cateID)->first();
            if ($cateModel->parent_id) { # it is child
                $condition[] = ['category_id', '=', $cateID];
            } else {
                $childs = Category::where('parent_id', $cateID)->get();
                $child_ids = [];
                foreach ($childs as $child) {
                    $child_ids[] = $child->id;
                }
                $query->whereIn('category_id', $child_ids);
            }
        }
        $query = $query->where($condition);

        if ($ignoreProductIDs) {
            $query = $query->whereNotIn('products.id', $ignoreProductIDs);
        }

        if ($keyword) {
            $query = $query->where('products.title', 'like', '%'.$keyword.'%');
        }

        $query = $query->whereNull('products.deleted_at');
        if ($limit) {
            $query = $query->limit($limit);
        }
        return $query->orderBy('id', 'DESC');
    }


     /**
     * Get popular products
     */
    public function getPopular($ignoreProductIDs=[], $limit=5, $cateID=0) {
        return $this->getNewest($ignoreProductIDs=[], $limit, $cateID, true)->get();
    }


    /**
     * Adminsite: update tags
     */
    public function updateTags($product, $tagIDs) {
        $productTags = $product->productTags;

        $existTags = [];
        foreach($productTags as $productTag) {
            $existTags[] = $productTag['tag_id'];
        }
        $newTagIDs = array_diff($tagIDs, $existTags);

        foreach($newTagIDs as $newTagID) {
            $productTagModel = new ProductTag();
            $productTagModel->product_id = $product->id;
            $productTagModel->tag_id = $newTagID;
            $productTagModel->save();
        }

        $deletedTagIDs = array_diff($existTags, $tagIDs);
        if ($deletedTagIDs) {
            ProductTag::whereIn('tag_id', $deletedTagIDs)->delete();
        }
    }


    public function getSlide($productID) {
        return ProductSlide::where('product_id', $productID)->get();
    }

    /**
     * Get 5 related product
     * The first items are featured
     */
    public function getRelated($product) {
        $cateID = $product->category_id;
        $featuredProducts = Product::select('products.*', 'categories.slug as category_slug', 'categories.title as category_title')
                        ->join('categories', 'category_id', 'categories.id')
                        ->where('products.status', '=', Product::STATUS_ACTIVE);
        $featuredProducts = $featuredProducts->where([
            ['featured', '=', Product::FEATURED_TRUE],
            ['category_id', '=', $cateID],
        ])->limit(5)->get();

        $leftProductNumber = 5 - count($featuredProducts);
        $leftProducts = [];
        if ($leftProductNumber) {
            $ignoreProductIDs = [];
            foreach($featuredProducts as $featuredProduct) {
                $ignoreProductIDs[] = $featuredProduct->id;
            }
            $leftProducts = $this->getNewest($ignoreProductIDs=[], $leftProductNumber, $cateID)->get();
        }

        if ($leftProducts && $featuredProducts) {
            return array_merge($featuredProducts->toArray(), $leftProducts->toArray());
        } elseif ($leftProducts) {
            return $leftProducts->toArray();
        } else {
            return $featuredProducts->toArray();
        }
    }

    /**
     * Get related products
     * id more than current product id
     */
    public function getRelated2($product, $limit = 3) {
        $id = $product->id;
        $products = $this->getNewest([$id], $limit, $product->category_id);
        $products->getQuery()->orders = null;
        $products->orderBy('id', 'ASC');
        
        return $products->get();
    }

    public static function getOrderFromCookie() {
        $cookies = Cookie::get('orders');
        if (!$cookies) {
            return [];
        }
        $cookies = json_decode($cookies);
        if(!$cookies or  !property_exists($cookies, 'data')) {
            return [];
        }
        $cookieOrders = $cookies->data;
        $orders = [];
        foreach($cookieOrders as $cookieOrder) {
            $product = Product::where('id', $cookieOrder->product_id)->first();
            $orders[] = [
                'product_id'    => $product['id'],
                'thumbnail'     => $product['thumbnail'],
                'title'         => $product['title'],
                'price'         => $product['price'],
                'quantity'      => $cookieOrder->quantity,
                'category_slug' => $product['category_slug'],
                'slug' => $product['slug'],
            ];
        }
        return $orders;
    }
}
