<?php

namespace App\Repositories;

use App\Models\Product;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class NewsRepository
 * @package App\Repositories
 * @version May 8, 2019, 4:38 am UTC
 *
 * @method News findWithoutFail($id, $columns = ['*'])
 * @method News find($id, $columns = ['*'])
 * @method News first($columns = ['*'])
*/
class ProductRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'slug',
        'category_id',
        'thumbnail',
        'description',
        'content',
        'seo_keyword',
        'seo_description',
        'image_list',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Product::class;
    }
}
