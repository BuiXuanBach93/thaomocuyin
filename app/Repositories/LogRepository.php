<?php

namespace App\Repositories;

use App\Models\Log;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LogRepository
 * @package App\Repositories
 * @version August 19, 2019, 5:11 pm UTC
 *
 * @method Log findWithoutFail($id, $columns = ['*'])
 * @method Log find($id, $columns = ['*'])
 * @method Log first($columns = ['*'])
*/
class LogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'number_crawled'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Log::class;
    }
}
