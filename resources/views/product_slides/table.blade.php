<div class="table-responsive">
    <table class="table" id="productSlides-table">
        <thead>
            <tr>
                <th>Product Id</th>
        <th>Is Main</th>
        <th>Name</th>
        <th>Created At</th>
        <th>Updaated At</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($productSlides as $productSlide)
            <tr>
                <td>{!! $productSlide->product_id !!}</td>
            <td>{!! $productSlide->is_main !!}</td>
            <td>{!! $productSlide->name !!}</td>
            <td>{!! $productSlide->created_at !!}</td>
            <td>{!! $productSlide->updaated_at !!}</td>
                <td>
                    {!! Form::open(['route' => ['productSlides.destroy', $productSlide->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('productSlides.show', [$productSlide->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('productSlides.edit', [$productSlide->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
