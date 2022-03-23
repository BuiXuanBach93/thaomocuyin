<div class="table-responsive">
    <table class="table" id="orders-table">
        <thead>
            <tr>
                <th>Product Id</th>
        <th>Number</th>
        <th>Color</th>
        <th>User Name</th>
        <th>Phone Number</th>
        <th>Address</th>
        <th>Note</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{!! $order->product_id !!}</td>
            <td>{!! $order->number !!}</td>
            <td>{!! $order->color !!}</td>
            <td>{!! $order->user_name !!}</td>
            <td>{!! $order->phone_number !!}</td>
            <td>{!! $order->address !!}</td>
            <td>{!! $order->note !!}</td>
                <td>
                    {!! Form::open(['route' => ['orders.destroy', $order->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('orders.show', [$order->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('orders.edit', [$order->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
