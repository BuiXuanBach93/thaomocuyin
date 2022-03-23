<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $newsCategory->id !!}</p>
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{!! $newsCategory->title !!}</p>
</div>

<!-- Slug Field -->
<div class="form-group">
    {!! Form::label('slug', 'Slug:') !!}
    <p>{!! $newsCategory->slug !!}</p>
</div>

<!-- Seo Keywords Field -->
<div class="form-group">
    {!! Form::label('seo_keyword', 'Seo Keywords:') !!}
    <p>{!! $newsCategory->seo_keyword !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $newsCategory->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $newsCategory->updated_at !!}</p>
</div>

