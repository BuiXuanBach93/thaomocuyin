<?php

namespace App\Repositories;

use App\Models\Reply;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ReplyRepository
 * @package App\Repositories
 * @version August 23, 2019, 4:17 pm UTC
 *
 * @method Reply findWithoutFail($id, $columns = ['*'])
 * @method Reply find($id, $columns = ['*'])
 * @method Reply first($columns = ['*'])
*/
class ReplyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'reply_id',
        'comment_id',
        'message',
        'read'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Reply::class;
    }
}
