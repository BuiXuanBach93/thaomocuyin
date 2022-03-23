<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $comment->id !!}</p>
</div>

<!-- Post Id Field -->
<div class="form-group">
    {!! Form::label('post_id', 'Post Id:') !!}
    <p>{!! $comment->post_id !!}</p>
</div>

<!-- Comment Id Field -->
<div class="form-group">
    {!! Form::label('comment_id', 'Comment Id:') !!}
    <p>{!! $comment->comment_id !!}</p>
</div>

<!-- Read Field -->
<div class="form-group">
    {!! Form::label('read', 'Read:') !!}
    <p>{!! $comment->read !!}</p>
</div>

<!-- New Comment Field -->
<div class="form-group">
    {!! Form::label('new_comment', 'New Comment:') !!}
    <p>{!! $comment->new_comment !!}</p>
</div>

<!-- Phone Number Field -->
<div class="form-group">
    {!! Form::label('phone_number', 'Phone Number:') !!}
    <p>{!! $comment->phone_number !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $comment->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $comment->updated_at !!}</p>
</div>

