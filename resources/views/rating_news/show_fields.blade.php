<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $ratingNews->id }}</p>
</div>

<!-- News Id Field -->
<div class="form-group">
    {!! Form::label('news_id', 'News Id:') !!}
    <p>{{ $ratingNews->news_id }}</p>
</div>

<!-- Rating Field -->
<div class="form-group">
    {!! Form::label('rating', 'Rating:') !!}
    <p>{{ $ratingNews->rating }}</p>
</div>

<!-- Ip Field -->
<div class="form-group">
    {!! Form::label('ip', 'Ip:') !!}
    <p>{{ $ratingNews->ip }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $ratingNews->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $ratingNews->updated_at }}</p>
</div>

