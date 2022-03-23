<div class="table-responsive">
    <table class="table" id="comments-table">
        <thead>
            <tr>
                <th>Post Id</th>
        <th>Comment Id</th>
        <th>Read</th>
        <th>New Comment</th>
        <th>Phone Number</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @foreach($comments as $comment)
            <tr>
                <td>{!! $comment->post_id !!}</td>
                <td class="comment-link">
                    <a target="_blank" href="//fb.com/{!! $comment->comment_id !!}" comment-id="{{$comment->id}}">{!! $comment->message !!}</a>
                </td>
                <td>
                    <label class="switch">
                        <input type="checkbox" class="is_new_comment" {{ $comment->read==1 ? 'checked':''}}>
                        <span class="slider round"></span>
                        <input type="hiddden" class='post_id' name="post_id" value="{{$comment->id}}">
                    </label>
                </td>
                <td>{!! $comment->new_comment !!}</td>
                <td>{!! $comment->phone_number !!}</td>
                    <td>
                        {!! Form::open(['route' => ['admin.comments.destroy', $comment->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{!! route('admin.comments.show', [$comment->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                            <a href="{!! route('admin.comments.edit', [$comment->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
