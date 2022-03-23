<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FbPost
 * @package App\Models
 * @version August 17, 2019, 8:25 pm UTC
 *
 * @property string url
 * @property string fanpage_id
 * @property string keyword
 * @property tinyinter status
 * @property string note
 */
class FbPost extends Model
{
    // use SoftDeletes;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    const NEW_COMMENT_TRUE = 1;
    const NEW_COMMENT_FALSE = 2;

    public $table = 'fb_posts';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'url',
        'fanpage_id',
        'post_id',
        'post_link',
        'keyword',
        'status',
        'note'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'url' => 'string',
        'fanpage_id' => 'string',
        'keyword' => 'string',
        'note' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'fanpage_id' => 'required',
    ];

    public static $listStatus = [
        FbPost::STATUS_ACTIVE => 'Active',
        FbPost::STATUS_INACTIVE => 'Inactive'
    ];

    public function getAll() {
        return FbPost::all();
    }
}
