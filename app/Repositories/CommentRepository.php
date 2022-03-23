<?php

namespace App\Repositories;

use App\Models\Comment;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CommentRepository
 * @package App\Repositories
 * @version August 23, 2019, 11:09 am UTC
 *
 * @method Comment findWithoutFail($id, $columns = ['*'])
 * @method Comment find($id, $columns = ['*'])
 * @method Comment first($columns = ['*'])
*/
class CommentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'post_id',
        'comment_id',
        'read',
        'new_comment',
        'phone_number'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Comment::class;
    }
}
