<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Comment
 * @package App\Models
 * @version August 23, 2019, 11:09 am UTC
 *
 * @property integer post_id
 * @property integer comment_id
 * @property boolean read
 * @property boolean new_comment
 * @property string phone_number
 */
class Comment extends Model
{
    // use SoftDeletes;

    public $table = 'comments';


    protected $dates = ['deleted_at'];

    const UNREAD = 1;
    const READ = 2;


    public $fillable = [
        'message',
        'post_id',
        'comment_id',
        'read',
        'new_comment',
        'phone_number',
        'reply_number'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'post_id' => 'string',
        'comment_id' => 'string',
        'read' => 'integer',
        'new_comment' => 'boolean',
        'phone_number' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'post_id' => 'required',
        'comment_id' => 'required',
        'read' => 'required'
    ];


}
