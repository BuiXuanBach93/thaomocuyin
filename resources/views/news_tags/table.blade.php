<table class="table table-responsive" id="newsTags-table">
    <thead>
        <tr>
            <th>News Id</th>
        <th>Tag Id</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($productTags as $productTag)
        <tr>
            <td>{!! $productTag->product_id !!}</td>
            <td>{!! $productTag->tag_id !!}</td>
            <td>
                {!! Form::open(['route' => ['newsTags.destroy', $productTag->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('newsTags.show', [$productTag->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('newsTags.edit', [$productTag->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
