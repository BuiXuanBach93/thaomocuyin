<?php

namespace App\Repositories;

use App\Models\FbPost;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class FbPostRepository
 * @package App\Repositories
 * @version August 17, 2019, 8:25 pm UTC
 *
 * @method FbPost findWithoutFail($id, $columns = ['*'])
 * @method FbPost find($id, $columns = ['*'])
 * @method FbPost first($columns = ['*'])
*/
class FbPostRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'url',
        'fanpage_id',
        'keyword',
        'status',
        'note'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return FbPost::class;
    }
}
