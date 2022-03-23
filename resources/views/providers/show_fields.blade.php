<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $provider->id !!}</p>
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{!! $provider->title !!}</p>
</div>

<!-- Slug Field -->
<div class="form-group">
    {!! Form::label('slug', 'Slug:') !!}
    <p>{!! $provider->slug !!}</p>
</div>

<!-- From Field -->
<div class="form-group">
    {!! Form::label('from', 'From:') !!}
    <p>{!! $provider->from !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $provider->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $provider->updated_at !!}</p>
</div>

