<?php

namespace App\Repositories;

use App\Models\Product;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProductRepository
 * @package App\Repositories
 * @version May 8, 2019, 4:39 am UTC
 *
 * @method Product findWithoutFail($id, $columns = ['*'])
 * @method Product find($id, $columns = ['*'])
 * @method Product first($columns = ['*'])
*/
class ProductOldRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'slug',
        'created',
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
