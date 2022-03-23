<?php

namespace App\Repositories;

use App\Models\NewsCategory;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class NewsCategoryRepository
 * @package App\Repositories
 * @version February 19, 2020, 9:42 am UTC
 *
 * @method NewsCategory findWithoutFail($id, $columns = ['*'])
 * @method NewsCategory find($id, $columns = ['*'])
 * @method NewsCategory first($columns = ['*'])
*/
class NewsCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'slug',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'content'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return NewsCategory::class;
    }
}
