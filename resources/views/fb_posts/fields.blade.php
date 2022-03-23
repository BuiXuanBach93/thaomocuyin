
<div class="form-group col-sm-12">
    {!! Form::label('url', 'url:') !!}
    {!! Form::text('url', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('fanpage_id', 'fanpage_id:') !!}
    {!! Form::text('fanpage_id', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('keyword', 'keyword:') !!}
    {!! Form::text('keyword', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('post_id', 'post_id:') !!}
    {!! Form::text('post_id', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('post_link', 'post_link:') !!}
    {!! Form::text('post_link', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('status', 'status:') !!}
    {!! Form::select('status', $listStatus, $selectedStatus, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('note', 'note:') !!}
    {!! Form::text('note', null, ['class' => 'form-control']) !!}
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.fb-posts.index') !!}" class="btn btn-default">Cancel</a>
</div>
