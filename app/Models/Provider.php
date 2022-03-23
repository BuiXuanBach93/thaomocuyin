<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Provider
 * @package App\Models
 * @version March 14, 2020, 9:34 am UTC
 *
 * @property string title
 * @property string slug
 * @property string from
 */
class Provider extends Model
{
    use SoftDeletes;

    public $table = 'providers';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'slug',
        'from',
        'from_slug',
        'content',
        'seo_title',
        'seo_keyword',
        'seo_description'        
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'slug' => 'string',
        'from' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
    /**
     * Get name of providers
     */
    public function getNameProviders() {
        $providers = Provider::get();
        
        $result = [''=>'---Tạo mới---'];
        foreach($providers as $provider) {
            $result[$provider->id] = $provider->title . " - " . $provider->from;
        }

        return $result;
    }


    /**
     * Get all categories by in a category
     * TODO: Need to refactor this source code
     */
    public function getProviderByCate($cateID) {
        $providers = Provider::join('products', 'providers.id', '=', 'products.provider_id')
                                ->where('products.category_id', '=', $cateID)->get();

        $provider_ids = [];
        foreach($providers as $provider) {
            if (!in_array($provider->provider_id, $provider_ids)) {
                $provider_ids[] = $provider->provider_id;
            }
        }
        if ($provider_ids) {
            return Provider::whereIn('id', $provider_ids)->get();
        }
        return null;
    }
}
