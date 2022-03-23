<?php

namespace App\Repositories;

use App\Models\Page;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PageRepository
 * @package App\Repositories
 * @version June 30, 2020, 10:41 am UTC
 *
 * @method Page findWithoutFail($id, $columns = ['*'])
 * @method Page find($id, $columns = ['*'])
 * @method Page first($columns = ['*'])
*/
class PageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'slug',
        'content',
        'seo_image'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Page::class;
    }
}
