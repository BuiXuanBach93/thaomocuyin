<div class="table-responsive">
    <table class="table" id="fanpages-table">
        <thead>
            <tr>
                <th>Fanpage Id</th>
        <th>Status</th>
        <th>Note</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($fanpages as $fanpage)
            <tr>
                <td>{!! $fanpage->fanpage_id !!}</td>
            <td>{!! $fanpage->status !!}</td>
            <td>{!! $fanpage->note !!}</td>
                <td>
                    {!! Form::open(['route' => ['admin.fanpages.destroy', $fanpage->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('admin.fanpages.show', [$fanpage->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('admin.fanpages.edit', [$fanpage->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
