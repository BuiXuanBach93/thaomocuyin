<?php

namespace App\Repositories;

use App\Models\Tag;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TagRepository
 * @package App\Repositories
 * @version May 15, 2019, 1:50 pm UTC
 *
 * @method Tag findWithoutFail($id, $columns = ['*'])
 * @method Tag find($id, $columns = ['*'])
 * @method Tag first($columns = ['*'])
*/
class TagRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'slug'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Tag::class;
    }
}
