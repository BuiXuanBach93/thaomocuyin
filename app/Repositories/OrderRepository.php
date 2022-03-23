<?php

namespace App\Repositories;

use App\Models\Order;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class OrderRepository
 * @package App\Repositories
 * @version August 11, 2019, 4:42 pm UTC
 *
 * @method Order findWithoutFail($id, $columns = ['*'])
 * @method Order find($id, $columns = ['*'])
 * @method Order first($columns = ['*'])
*/
class OrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'product_id',
        'number',
        'color',
        'user_name',
        'phone_number',
        'address',
        'note'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Order::class;
    }
}
