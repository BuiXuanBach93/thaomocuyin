<div class="table-responsive">
    <table class="table" id="pages-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Slug</th>        
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pages as $page)
            <tr>
                <td>{{ $page->title }}</td>
            <td>{{ $page->slug }}</td>
                <td>
                    {!! Form::open(['route' => ['admin.pages.destroy', $page->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.pages.show', [$page->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('admin.pages.edit', [$page->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
