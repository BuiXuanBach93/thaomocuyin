<div class="table-responsive">
    <table class="table" id="newsCategories-table">
        <thead>
            <tr>
                <th>Title</th>
        <th>Slug</th>
        <th>Seo Keywords</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($newsCategories as $newsCategory)
            <tr>
                <td>{!! $newsCategory->title !!}</td>
            <td>{!! $newsCategory->slug !!}</td>
            <td>{!! $newsCategory->seo_keyword !!}</td>
                <td>
                    {!! Form::open(['route' => ['admin.newsCategories.destroy', $newsCategory->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('admin.newsCategories.show', [$newsCategory->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('admin.newsCategories.edit', [$newsCategory->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
