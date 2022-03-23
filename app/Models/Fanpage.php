<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Fanpage
 * @package App\Models
 * @version August 20, 2019, 6:34 pm UTC
 *
 * @property string fanpage_id
 * @property tinyinteger status
 * @property string note
 */
class Fanpage extends Model
{
    use SoftDeletes;

    const CRAWLED_TRUE = 2;
    const CRAWLED_FALSE = 1;

    public $table = 'fanpages';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'fanpage_id',
        'status',
        'note',
        'crawled'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'fanpage_id' => 'string',
        'crawled' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'fanpage_id' => 'required',
    ];


}
