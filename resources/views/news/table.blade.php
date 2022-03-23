<div class="table-responsive">
    <table class="table" id="news-table">
        <thead>
        <tr>
        <th>id</th>
        <th>Title</th>
        <th>Status</th>
        <th>Creator</th>
        <th>Created At</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($news as $news)
            <tr>
            <td>{!! $news->id !!}</td>
            <td>{!! $news->title !!}</td>
            <td>{!! $news->status == 1 ? 'Publish' : 'Unpublish'!!}</td>
            <td>{!! $news->user['name']!!}</td>
            <td>{!! $news->created_at !!}</td>
                <td>
                    <?php
                        $newsLink = genProductLink($news->news_category->slug, $news->slug); 
                        $newsLink = $news->status == 1 ?  $newsLink : '/preview'.$newsLink;
                    ?>
                    {!! Form::open(['route' => ['admin.news.destroy', $news->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a target="_blank" href="{{$newsLink}}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('admin.news.edit', [$news->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
