<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $log->id !!}</p>
</div>

<!-- Number Crawled Field -->
<div class="form-group">
    {!! Form::label('number_crawled', 'Number Crawled:') !!}
    <p>{!! $log->number_crawled !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $log->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $log->updated_at !!}</p>
</div>

