<div class="table-responsive">
    <table class="table" id="ratingNews-table">
        <thead>
            <tr>
                <th>News Id</th>
        <th>Rating</th>
        <th>Ip</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($ratingNews as $ratingNews)
            <tr>
                <td>{{ $ratingNews->news_id }}</td>
            <td>{{ $ratingNews->rating }}</td>
            <td>{{ $ratingNews->ip }}</td>
                <td>
                    {!! Form::open(['route' => ['ratingNews.destroy', $ratingNews->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('ratingNews.show', [$ratingNews->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('ratingNews.edit', [$ratingNews->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
