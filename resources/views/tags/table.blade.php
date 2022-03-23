<table class="table table-responsive" id="tags-table">
    <thead>
        <tr>
            <th>Title</th>
        <th>Slug</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($tags as $tag)
        <tr>
            <td>{!! $tag->title !!}</td>
            <td>{!! $tag->slug !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.tags.destroy', $tag->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.tags.show', [$tag->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.tags.edit', [$tag->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
