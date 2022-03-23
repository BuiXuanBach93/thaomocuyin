<div class="table-responsive">
    <table class="table" id="providers-table">
        <thead>
            <tr>
                <th>Title</th>
        <th>Slug</th>
        <th>From</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($providers as $provider)
            <tr>
                <td>{!! $provider->title !!}</td>
            <td>{!! $provider->slug !!}</td>
            <td>{!! $provider->from !!}</td>
                <td>
                    {!! Form::open(['route' => ['admin.providers.destroy', $provider->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('admin.providers.show', [$provider->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('admin.providers.edit', [$provider->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
