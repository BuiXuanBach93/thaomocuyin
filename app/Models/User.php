<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use App\Models\Category;
use Illuminate\Foundation\Console\Presets\None;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 * @package App\Models
 * @version May 8, 2019, 4:38 am UTC
 *
 * @property string title
 * @property string slug
 * @property integer category_id
 * @property string thumbnail
 * @property string description
 * @property string content
 * @property string
 * @property string seo_title
 * @property string seo_description
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */
class User extends Model
{

    public $table = 'users';

    protected $softDelete = true;

    protected $dates = ['deleted_at'];

    // thành viên
    protected static $manager = 1;
    // Biên tập viên
    protected static $editor = 2;

    // Nhân viên kho
    protected static $stocker = 3;

    // Nhân viên tư vấn
    protected static $advisor = 4;

    const ROLE_ADMIN = 1;
    const ROLE_WRITER = 2;
    const ROLE_STOCKER = 3;
    const ROLE_ADVISOR = 4;

    public $fillable = [
        'name',
        'email',
        'role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function isManager($role) {
        if ($role == User::$manager) {
            return true;
        }

        return false;
    }

    public static function isEditor($role) {
        if ($role == User::$editor) {
            return true;
        }

        return false;
    }

    public static function isStocker($role) {
        if ($role == User::$stocker) {
            return true;
        }

        return false;
    }

    public static function isAdvisor($role) {
        if ($role == User::$advisor) {
            return true;
        }

        return false;
    }

    public function getEditors() {
        $editors =  User::where('role', User::ROLE_WRITER)->get();
        $result = [];
        foreach($editors as $editor) {
            $result[$editor->id] = $editor->name;
        }
        return $result;
    }

    public static function getAdvisors() {
        $advisors =  User::where('role', User::ROLE_ADVISOR)->get();
        $result = [];
        foreach($advisors as $advisor) {
            $result[$advisor->id] = $advisor->name;
        }
        return $result;
    }
}
