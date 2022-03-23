<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $fanpage->id !!}</p>
</div>

<!-- Fanpage Id Field -->
<div class="form-group">
    {!! Form::label('fanpage_id', 'Fanpage Id:') !!}
    <p>{!! $fanpage->fanpage_id !!}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{!! $fanpage->status !!}</p>
</div>

<!-- Note Field -->
<div class="form-group">
    {!! Form::label('note', 'Note:') !!}
    <p>{!! $fanpage->note !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $fanpage->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $fanpage->updated_at !!}</p>
</div>

