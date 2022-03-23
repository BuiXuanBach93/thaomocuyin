<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Tag
 * @package App\Models
 * @version May 15, 2019, 1:50 pm UTC
 *
 * @property string title
 * @property string slug
 */
class Notification extends Model
{
    use SoftDeletes;

    public $table = 'notification';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'content',
        'slug',
        'title',
        'status',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function countReport(){
        try {
            $countNotification = $this->where('status', 0)->count();
            return $countNotification;
        } catch (\Exception $e) {
            return 0;
        }

    }
}
