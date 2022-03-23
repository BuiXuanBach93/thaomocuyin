<?php

namespace App\Repositories;

use App\Models\News;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class NewsRepository
 * @package App\Repositories
 * @version February 10, 2020, 8:55 am UTC
 *
 * @method News findWithoutFail($id, $columns = ['*'])
 * @method News find($id, $columns = ['*'])
 * @method News first($columns = ['*'])
*/
class NewsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'slug',
        'thumbnail',
        'thumbnail_home',
        'description',
        'content',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return News::class;
    }
}
