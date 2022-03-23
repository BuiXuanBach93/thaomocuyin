<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Reply
 * @package App\Models
 * @version August 23, 2019, 4:17 pm UTC
 *
 * @property string reply_id
 * @property string comment_id
 * @property string message
 * @property boolean read
 */
class Reply extends Model
{
    // use SoftDeletes;

    public $table = 'replies';


    protected $dates = ['deleted_at'];

    const UNREAD = 1;
    const READ = 2;


    public $fillable = [
        'reply_id',
        'comment_id',
        'message',
        'read',
        'total_number'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'reply_id' => 'string',
        'comment_id' => 'string',
        'message' => 'string',
        'read' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'reply_id' => 'required',
        'comment_id' => 'required'
    ];


}
