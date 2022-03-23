<?php

namespace App\Repositories;

use App\Models\Contact;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ContactRepository
 * @package App\Repositories
 * @version May 14, 2019, 4:29 am UTC
 *
 * @method User findWithoutFail($id, $columns = ['*'])
 * @method User find($id, $columns = ['*'])
 * @method User first($columns = ['*'])
*/
class ContactRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'phone_number',
        'message'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Contact::class;
    }
}
