

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('seo_title', 'SEO Title:') !!}
    {!! Form::text('seo_title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('slug', 'Slug:') !!}
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
</div>

<!-- <div class="form-group col-sm-12">
    {!! Form::label('thumbnail', 'Thumbnail (350 x 300):') !!}
    {!! Form::File('thumbnail', null, ['class' => 'form-control']) !!}
    @if(isset($news))
    <img src="{{genImage($news->thumbnail, 100)}}" alt="" width="50">
    @endif
</div> -->

<div class="form-group col-sm-12">
                                <label>Ảnh thumb + SEO 350x300 </label>
                                <input type="button" onclick="return uploadImage(this);" value="Chọn Thumbnail"
                                       size="20"/>
                                <img src="" width="100"/>
                                <input name="thumbnail" type="hidden" value=""/>
    @if(isset($news))
    <img src="{{genImage($news->thumbnail)}}" alt="" width="100">
    @endif
</div>

<div class="form-group col-sm-12">
    {!! Form::label('seo_image', 'Seo image: (Auto)') !!}
    {!! Form::text('seo_image', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('news_category', 'Category:') !!}
    {!! Form::select('news_category_id', $listCategory, null, ['class' => 'form-control']) !!}
</div>

{{-- <div class="form-group col-sm-12">
    {!! Form::label('short_description', 'Short description:') !!}
    {!! Form::text('short_description', null, ['class' => 'form-control']) !!}
</div> --}}

<div class="form-group col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control ckeditor', 'rows'=> 3]) !!}
</div>
<div class="form-group col-sm-12">
    {!! Form::label('seo_description', 'SEO Description: (dưới 160 ký tự)') !!}
    {!! Form::textarea('seo_description', null, ['class' => 'form-control', 'rows'=> 3]) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('content', 'Content:') !!}
    {!! Form::textarea('content', null, ['class' => 'form-control ckeditor']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('seo keywords', 'Seo keywords:') !!}
    {!! Form::text('seo_keyword', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('Payment Status', 'Đã thanh toán') !!}
    {!! Form::checkbox('pay_status', null, null, array('id'=>'pay_status')) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('assignee_id', 'Người phụ trách:') !!}
    {!! Form::select('assignee_id', $listEditor, null, ['class' => 'form-control chosen-select']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    {!! Form::submit('Save to draft', ['class' => 'btn btn-primary', 'preview'=> 1]) !!}
    <a href="{!! route('admin.news.index') !!}" class="btn btn-default">Cancel</a>
</div>