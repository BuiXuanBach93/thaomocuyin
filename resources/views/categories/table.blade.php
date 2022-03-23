<table class="table table-responsive" id="categories-table">
    <thead>
        <tr>
            <th>Title</th>
        <th>Slug</th>
        <th>Seo Keyword</th>
        <th>Seo Description</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($categories as $category)
        <tr>
            <td>{!! $category->title !!}</td>
            <td>{!! $category->slug !!}</td>
            <td>{!! $category->seo_title !!}</td>
            <td>{!! $category->seo_description !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.categories.destroy', $category->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.categories.show', [$category->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.categories.edit', [$category->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
