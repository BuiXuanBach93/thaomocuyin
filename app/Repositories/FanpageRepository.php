<?php

namespace App\Repositories;

use App\Models\Fanpage;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class FanpageRepository
 * @package App\Repositories
 * @version August 20, 2019, 6:34 pm UTC
 *
 * @method Fanpage findWithoutFail($id, $columns = ['*'])
 * @method Fanpage find($id, $columns = ['*'])
 * @method Fanpage first($columns = ['*'])
*/
class FanpageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'fanpage_id',
        'status',
        'note'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Fanpage::class;
    }
}
