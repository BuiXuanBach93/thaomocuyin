<div class="table-responsive">
    <table class="table" id="logs-table">
        <thead>
            <tr>
                <th>Number Crawled</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($logs as $log)
            <tr>
                <td>{!! $log->number_crawled !!}</td>
                <td>
                    {!! Form::open(['route' => ['logs.destroy', $log->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('logs.show', [$log->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('logs.edit', [$log->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
