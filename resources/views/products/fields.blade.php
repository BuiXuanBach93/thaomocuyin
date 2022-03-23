<div class="form-group col-sm-12">
    {!! Form::label('title', 'Title: (*)') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('seo_title', 'SEO Title:') !!}
    {!! Form::text('seo_title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('seo keywords', 'Seo keywords:') !!}
    {!! Form::text('seo_keyword', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('seo description', 'Seo description:') !!}
    {!! Form::text('seo_description', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('Short Name', 'Tên ngắn:') !!}
    {!! Form::text('short_name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('sku', 'SKU:') !!}
    {!! Form::text('sku', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('slug', 'Slug: (*)') !!}
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
                                <label>Ảnh thumb + SEO</label>
                                <input type="button" onclick="return uploadImage(this);" value="Chọn Thumbnail"
                                       size="20"/>
                                <img src="" width="100"/>
                                <input name="thumbnail" type="hidden" value=""/>
    @if(isset($product))
    <img src="{{genImage($product->thumbnail)}}" alt="" width="50">
    @endif
</div>

<div class="form-group col-sm-12">
                                <label>Ảnh block home</label>
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="" width="100"/>
                                <input name="thumbnail_home" type="hidden" value=""/>
    @if(isset($product))
    <img src="{{genImage($product->thumbnail_home)}}" alt="" width="50">
    @endif
</div>

<div class="form-group col-sm-12">
                                <label>Danh sách hình ảnh</label>
                                <input type="button" onclick="return openKCFinder(this);" value="Chọn ảnh"
                                       size="20"/>
                                <div class="imageList">
                                    @if(isset($product) && !empty($product->image_list))
                                        @foreach(explode(',',$product->image_list) as $image)
                                            <img src="{{$image}}" width="100" style="margin-left: 5px; margin-bottom: 5px;"/>
                                        @endforeach
                                    @endif
                                </div>
                                <input name="image_list" type="hidden" value=""/>
                            </div>

<div class="form-group col-sm-12">
    {!! Form::label('seo_image', 'Seo image:') !!}
    {!! Form::text('seo_image', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('category', 'Category:') !!}
    {!! Form::select('category_id', $listCategory, null, ['class' => 'form-control chosen-select']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('provider', 'Provider:') !!}
    {!! Form::select('provider_id', $providers, null, ['class' => 'form-control chosen-select provider-select']) !!}
</div>

<div class="form-group col-sm-12 provider">
    <div class="col-sm-6">
        {!! Form::label('provider_name', 'Provider Name:') !!}
        {!! Form::text('provider_name', null, ['class' => 'form-control']) !!}
    </div>
    <div class="col-sm-6">
        {!! Form::label('nation', "Nation:") !!}
        {!! Form::text('nation', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows'=> 3]) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('content', 'Content: (*)') !!}
    {!! Form::textarea('content', null, ['class' => 'form-control ckeditor']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('just_view', 'Câu view') !!}
    {!! Form::checkbox('just_view', null, null, array('id'=>'just_view')) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('featured', 'Sản phẩm gợi ý:') !!}
    {!! Form::checkbox('featured', null, null, array('id'=>'featured')) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('featured_home', 'Home Block') !!}
    {!! Form::checkbox('featured_home', null, null, array('id'=>'featured_home')) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('order', 'Độ ưu tiên') !!}
    {!! Form::text('order', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('notes', 'notes:') !!}
    {!! Form::text('notes', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('tag_list', 'Tags') !!}
    {!! Form::text('tag_list', null, ['class' => 'form-control']) !!}
</div>
@if(\App\Models\User::isManager(\Illuminate\Support\Facades\Auth::user()->role))
<div class="form-group col-sm-12">
    <strong>CẤU HÌNH THÔNG TIN GIÁ</strong>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('Price', 'Giá bán:') !!}
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('Origin Price', 'Giá nhập:') !!}
    {!! Form::text('origin_price', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    <?php
    $types = [0=>'Not discount', 1=>'Money', 2=>'Percent'];
    ?>
    {!! Form::label('Discount type', 'Loại giảm giá:') !!}
    {!! Form::select('discount_type', $types, isset($product) ? $product->discount_type: 0, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('Discount', 'Giá trị giảm:') !!}
    {!! Form::text('discount', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('Hidden Price', 'Giá ẩn:') !!}
    {!! Form::text('hidden_price', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    <?php
    $types = [0=>'Chọn Loại KM', 1=>'Freeship', 2=>'Quà tặng', 3=>'Chiết khấu'];
    ?>
    {!! Form::label('Promotion type', 'Khuyến mãi:') !!}
    {!! Form::select('promotion_type', $types, isset($product) ? $product->promotion_type: 0, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('Threshold', 'Hạn mức KM:') !!}
    {!! Form::text('promotion_threshold', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('Promotion Content', 'Nội dung KM:') !!}
    {!! Form::text('promotion_content', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('Promotion Product', 'ID Quà tặng:') !!}
    {!! Form::text('free_gift_id', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('Promotion Product', 'Tiền chiết khấu:') !!}
    {!! Form::text('promotion_discount', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('ATS', 'Tồn kho:') !!}
    {!! Form::text('ats', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('Expired Date', 'Hạn sử dụng:') !!}
    {!! Form::text('expired_date', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('Free Gift', 'Là quà tặng') !!}
    {!! Form::checkbox('is_free_gift', null, null, array('id'=>'is_free_gift')) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('Payment Status', 'Đã thanh toán') !!}
    {!! Form::checkbox('pay_status', null, null, array('id'=>'pay_status')) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('assignee_id', 'Người phụ trách:') !!}
    {!! Form::select('assignee_id', $listEditor, null, ['class' => 'form-control chosen-select']) !!}
</div>
@endif

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    {!! Form::submit('Save to draft', ['class' => 'btn btn-primary', 'preview'=> 1]) !!}
    <a href="{!! route('admin.product.index') !!}" class="btn btn-default">Cancel</a>
</div>
