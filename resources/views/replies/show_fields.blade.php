<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $reply->id !!}</p>
</div>

<!-- Reply Id Field -->
<div class="form-group">
    {!! Form::label('reply_id', 'Reply Id:') !!}
    <p>{!! $reply->reply_id !!}</p>
</div>

<!-- Comment Id Field -->
<div class="form-group">
    {!! Form::label('comment_id', 'Comment Id:') !!}
    <p>{!! $reply->comment_id !!}</p>
</div>

<!-- Message Field -->
<div class="form-group">
    {!! Form::label('message', 'Message:') !!}
    <p>{!! $reply->message !!}</p>
</div>

<!-- Read Field -->
<div class="form-group">
    {!! Form::label('read', 'Read:') !!}
    <p>{!! $reply->read !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $reply->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $reply->updated_at !!}</p>
</div>

