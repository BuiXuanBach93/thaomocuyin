<?php

namespace App\Repositories;

use App\Models\RatingNews;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RatingNewsRepository
 * @package App\Repositories
 * @version July 30, 2020, 7:20 pm UTC
 *
 * @method RatingNews findWithoutFail($id, $columns = ['*'])
 * @method RatingNews find($id, $columns = ['*'])
 * @method RatingNews first($columns = ['*'])
*/
class RatingNewsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'news_id',
        'rating',
        'ip'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RatingNews::class;
    }
}
