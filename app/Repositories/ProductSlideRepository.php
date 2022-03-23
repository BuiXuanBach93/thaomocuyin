<?php

namespace App\Repositories;

use App\Models\ProductSlide;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProductSlideRepository
 * @package App\Repositories
 * @version August 8, 2019, 4:00 pm UTC
 *
 * @method ProductSlide findWithoutFail($id, $columns = ['*'])
 * @method ProductSlide find($id, $columns = ['*'])
 * @method ProductSlide first($columns = ['*'])
*/
class ProductSlideRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'product_id',
        'is_main',
        'name',
        'created_at',
        'updaated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProductSlide::class;
    }
}
