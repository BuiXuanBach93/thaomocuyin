<?php

namespace App\Repositories;

use App\Models\Provider;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProviderRepository
 * @package App\Repositories
 * @version March 14, 2020, 9:34 am UTC
 *
 * @method Provider findWithoutFail($id, $columns = ['*'])
 * @method Provider find($id, $columns = ['*'])
 * @method Provider first($columns = ['*'])
*/
class ProviderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'slug',
        'from'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Provider::class;
    }
}
