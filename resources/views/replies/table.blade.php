<div class="table-responsive">
    <table class="table" id="replies-table">
        <thead>
        <th>Comment Id</th>
        <th>Message</th>
        <th>Read</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <?php $commentIDs = [];?>
        @foreach($replies as $reply)
            <td><?php if(!in_array($reply->comment_id, $commentIDs)) {$commentIDs[]=$reply->comment_id; echo $reply->comment_id;}?></td>
            <td class="reply-link">
                <a target="_blank" href="//fb.com/{!! $reply->reply_id !!}" reply-id="{{$reply->id}}">
                    {!! $reply->message !!}
                </a>
            </td>
            <td>
                <label class="switch">
                    <input type="checkbox" class="checkbox" {{ $reply->read==1 ? 'checked':''}}>
                    <span class="slider round"></span>
                    <input type="hiddden" class='post_id' name="post_id" value="{{$reply->id}}">
                </label>
            </td>
                <td>
                    {!! Form::open(['route' => ['admin.replies.destroy', $reply->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('admin.replies.show', [$reply->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('admin.replies.edit', [$reply->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
