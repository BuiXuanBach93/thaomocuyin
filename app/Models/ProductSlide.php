<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductSlide
 * @package App\Models
 * @version August 8, 2019, 4:00 pm UTC
 *
 * @property integer product_id
 * @property integer is_main
 * @property varchar name
 */
class ProductSlide extends Model
{
    use SoftDeletes;

    const IS_MAIN_TRUE = 1;
    const IS_MAIN_FALSE = 2;

    public $table = 'product_slides';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'product_id',
        'is_main',
        'name',
        'alt',
        'created_at',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'product_id' => 'integer',
        'is_main' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'product_id' => 'require',
        'is_main' => 'require',
        'name' => 'require'
    ];


    public static function updateSlides($product, $slides, $isMainNumber, $alts) {
        $existSlides = ProductSlide::where('product_id', $product->id)->orderBy('id', 'ASC')->get();

        if (!$slides) {
            return;
        }

        foreach ($slides as $key=>$slide) {
            if (isset($existSlides[$key])) { # update
                $tmp = $existSlides[$key];
                $tmp->name = $slide;
                $tmp->save();

            } else { # create new
                $productSlide = new ProductSlide();
                $productSlide->product_id = $product->id;
                $productSlide->name = $slide;
                if ($key == $isMainNumber) {
                    $productSlide->is_main = ProductSlide::IS_MAIN_TRUE;
                } else {
                    $productSlide->is_main = ProductSlide::IS_MAIN_FALSE;
                }
                $productSlide->alt = $alts[$key];
                $productSlide->save();
            }
        }
    }

}
