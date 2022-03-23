<div class="table-responsive">
    <table class="table" id="admin.fb-posts-table">
        <thead>
            <tr>
                <th>Id</th>
        <th>Fanpage Id</th>
        <th>Keyword</th>
        <th>New comment</th>
        <th>Comment's number</th>
        <th>Post_link</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($fbPosts as $fbPost)
            <tr>
                <td>{!! $fbPost->id !!}</td>
            <td>{!! $fbPost->fanpage_id !!}</td>
            <td>{!! $fbPost->keyword !!}</td>
            <td>
                <label class="switch">
                    <input type="checkbox" class="is_new_comment" {{ $fbPost->new_comment==1 ? 'checked':''}}>
                    <span class="slider round"></span>
                    <input type="hiddden" class='post_id' name="post_id" value="{{$fbPost->id}}">
                </label>
            </td>
            <td>{!! $fbPost->total_comment !!}</td>
            <td><a href="{!! $fbPost->post_link !!}" target="_blank">{!! $fbPost->post_link !!}</a></td>
                <td>
                    {!! Form::open(['route' => ['admin.fb-posts.destroy', $fbPost->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('admin.fb-posts.show', [$fbPost->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('admin.fb-posts.edit', [$fbPost->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
