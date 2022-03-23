<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $productTag->id !!}</p>
</div>

<!-- News Id Field -->
<div class="form-group">
    {!! Form::label('product_id', 'News Id:') !!}
    <p>{!! $productTag->product_id !!}</p>
</div>

<!-- Tag Id Field -->
<div class="form-group">
    {!! Form::label('tag_id', 'Tag Id:') !!}
    <p>{!! $productTag->tag_id !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $productTag->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $productTag->updated_at !!}</p>
</div>

