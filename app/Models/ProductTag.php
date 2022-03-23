<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductTag
 * @package App\Models
 * @version May 15, 2019, 2:08 pm UTC
 *
 * @property integer product_id
 * @property integer tag_id
 */
class ProductTag extends Model
{
    use SoftDeletes;

    public $table = 'product_tags';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'product_id',
        'tag_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'product_id' => 'integer',
        'tag_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'product_id' => 'required',
        'tag_id' => 'required'
    ];

    public function tag()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

}
