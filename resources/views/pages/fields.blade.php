

<div class="form-group col-sm-12">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('slug', 'Slug:') !!}
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('seo_description', 'Seo description:') !!}
    {!! Form::text('seo_description', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('seo_keyword', 'Seo keyword:') !!}
    {!! Form::text('seo_keyword', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('seo_image', 'Seo Image:') !!}
    {!! Form::text('seo_image', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('content', 'Content:') !!}
    {!! Form::textarea('content', null, ['class' => 'form-control ckeditor', 'rows'=> 3]) !!}
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('admin.pages.index') }}" class="btn btn-default">Cancel</a>
</div>
