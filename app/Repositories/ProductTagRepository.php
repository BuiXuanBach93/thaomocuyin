<?php

namespace App\Repositories;

use App\Models\ProductTag;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class NewsTagRepository
 * @package App\Repositories
 * @version May 15, 2019, 2:08 pm UTC
 *
 * @method NewsTag findWithoutFail($id, $columns = ['*'])
 * @method NewsTag find($id, $columns = ['*'])
 * @method NewsTag first($columns = ['*'])
*/
class ProductTagRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'product_id',
        'tag_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return NewsTag::class;
    }
}
