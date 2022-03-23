<?php

namespace App\Repositories;

use App\Models\Category;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CategoryRepository
 * @package App\Repositories
 * @version May 14, 2019, 4:29 am UTC
 *
 * @method Category findWithoutFail($id, $columns = ['*'])
 * @method Category find($id, $columns = ['*'])
 * @method Category first($columns = ['*'])
*/
class CategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'slug',
        'seo_keyword',
        'seo_description',
        'parent_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Category::class;
    }
}
