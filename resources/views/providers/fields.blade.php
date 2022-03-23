
<div class="form-group col-sm-12">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('slug', 'Slug:') !!}
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('from', 'From address:') !!}
    {!! Form::text('from', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('from_slug', 'From slug address:') !!}
    {!! Form::text('from_slug', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-12">
    {!! Form::label('content', 'Content:') !!}
    {!! Form::textarea('content', null, ['class' => 'form-control ckeditor']) !!}
</div>
<div class="form-group col-sm-12">
    {!! Form::label('seo title', 'Seo title:') !!}
    {!! Form::text('seo_title', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-12">
    {!! Form::label('seo keywords', 'Seo keywords:') !!}
    {!! Form::textarea('seo_keyword', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('seo description', 'Seo description:') !!}
    {!! Form::textarea('seo_description', null, ['class' => 'form-control']) !!}
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.providers.index') !!}" class="btn btn-default">Cancel</a>
</div>
