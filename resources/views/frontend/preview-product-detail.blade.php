<?php use App\Constant;?>
@extends('layouts.frontend_noindex')
@section('style')
<style>
.tt-product-single-info .tt-price .tt-label-sale {
    position: relative;
    top: -5px;
    padding-left: 10px;
    padding-right: 10px;
    font-size: 14px;
  }
  
  .tt-product-single-info .tt-price .old-price {
    position: relative;
    top: -3px;
    color: #676464;
    font-size: 18px;
  }
  
  .tt-product-single-info .tt-price .new-price {
    margin-left: 10px;
    margin-right: 10px;
    color: #FF0000;
  }
  .tt-product-single-info .tt-price .main-price{
    color: #FF0000;
    margin: 0px 20px;
  }
  
  .tt-product-single-info .tt-row-custom-01 .btn {
    width:auto;
  }
  
  .tt-product-single-info .tt-row-custom-01 .buy-now {
    background-color:#FF0000;
  }

  .tt-product-single-info .tt-add-info {
    background: #f5f5f5;
    padding: 10px 20px;   
  }
  
  .tt-product-single-info .tt-add-info p {
    margin:0px;
    padding: 0px;
  }
  
  .tt-product-single-info .tt-price {
    margin: 30px 0px;    
  }
  .tt-product-single-info .tt-collapse-block {
    border-top: 1px solid #e9e7e7;
    margin-top:30px;
    color: #0a0808;
  }
  /* Product signal page */
.tt-product-single-info {
  overflow-x: hidden;
  text-align: justify;
}

.tt-product-single-info .detail-title {
  font-size: 1.5em;
  margin-block-start: 0.83em;
  margin-block-end: 0.83em;
  margin-inline-start: 0px;
  margin-inline-end: 0px;
  font-weight: bold;
  margin-bottom: 30px;
}

.tt-product-single-info h2 {
  font-size: 1.3em;
  margin-top:25px;
}
.tt-product-single-info h3 {
  margin-top:15px;
  font-size: 15px;
  font-style: italic;
}
.tt-product-single-info .tt-collapse-block .tt-item:not(:last-child) {
  padding-bottom: 25px;
}
.tt-product-single-info .detail-content ul li p{
  margin-top: 8px;
}
.tt-product-single-info .detail-content img, .tt-post-single .tt-post-content img{
  display: block;
  margin: 15px auto;
}
.tt-product-single-info .detail-content img + caption, .tt-post-single .tt-post-content img + caption{
  display: block;
  color: #6c757d;
  font-size: 14px;
  padding-top: 0px;
  text-align: center;
  font-weight: normal;
}
.tt-product-single-info .detail-content ol{
  padding-left: 20px;
  margin-top: 15px;
}
.tt-product-single-info .detail-content img, .tt-post-single .tt-post-content img, .tt-product-single-info .detail-content table {
  max-width: 100% !important;
}
@media (max-width: 640px) {
  .tt-product-single-info .detail-content table {
    width: 100% !important;
  }
}
.tt-product-single-info .detail-content ul {
    padding-left: 30px;
}
.tt-product-single-info .detail-content table, .tt-product-single-info .detail-content ul {
  margin-top:15px;
}

.tt-product-single-info .detail-content ol li {
  margin-bottom: 10px;
}
.tt-product-single-info .detail-content table caption{
  display: none;
}
.tt-product-single-info .detail-content table td {
  padding: 4px 6px;
}
.tt-product-single-info blockquote {
font-style: italic;
color: #1e1e1e;
position: relative;
}
.tt-product-single-info blockquote::before{
content: open-quote;
font-size: 4em;
line-height: 0.1em;
margin-right: 0.25em;
vertical-align: -0.4em;
position: absolute;
top: 20px;
left: -35px;
}
.tt-product-single-info .more-info {
color: #191919;
}
.tt-product-single-info .more-info label {
font-weight: bold;
margin-right: 8px;
}
.tt-product-single-info .more-info span:not(:last-child){
padding-right: 30px;
}
.tt-product-single-info {
padding-left: 39px;
margin: -5px 0 0 0; }
.tt-product-single-info img {
max-width: 100%;
height: auto; }
.tt-product-single-info .tt-add-info ul li {
color: #191919; }
.tt-product-single-info .tt-add-info ul li span:first-child {
letter-spacing: 0.02em;
color: #191919; }
.tt-product-single-info .tt-add-info ul li span {
letter-spacing: 0.02em; }
.tt-product-single-info .tt-add-info ul li a {
color: #191919;
transition: all 0.2s linear;
-ms-transition: all 0.2s linear;
-webkit-transition: all 0.2s linear;
-o-transition: all 0.2s linear; }
.tt-product-single-info .tt-add-info ul li a:hover {
color: #288ad6; }
.tt-product-single-info .tt-add-info ul li:not(:first-child) {
margin-top: 6px; }
.tt-product-single-info .tt-add-info span:fist-child {
color: #191919;
display: inline-block;
padding-right: 4px; }
.tt-product-single-info .tt-title {
font-size: 26px;
line-height: 40px;
font-weight: 500;
margin-top: 19px;
color: #191919; }
.tt-product-single-info .tt-price {
font-size: 30px;
line-height: 40px;
font-family: Arial, Helvetica, sans-serif;
font-weight: 500;
color: #288ad6; }
.tt-product-single-info .tt-price span {
display: inline-block; }
.tt-product-single-info .tt-price .sale-price {
color: #FF0000;
margin-right: 7px; }
.tt-product-single-info .tt-price .old-price,
.tt-product-single-info .tt-price .old-price .money {
color: #288ad6;
text-decoration: line-through; }
.tt-product-single-info .tt-review {
margin-top: 5px; }
.tt-product-single-info .tt-review .tt-rating {
margin-right: 8px;
margin-top: 3px; }
.tt-product-single-info .tt-review .tt-rating .icon-star:before {
color: #ffb503; }
.tt-product-single-info .tt-review .tt-rating .icon-star-half:before {
color: #ffb503; }
.tt-product-single-info .tt-review .tt-rating .icon-star-empty:before {
color: #d4d4d4; }
.tt-product-single-info .tt-review a {
color: #288ad6;
display: inline-block;
transition: all 0.2s linear;
-ms-transition: all 0.2s linear;
-webkit-transition: all 0.2s linear;
-o-transition: all 0.2s linear; }
.tt-product-single-info .tt-review a:hover {
color: #191919; }
.tt-product-single-info .tt-review a:not(:last-child) {
margin-right: 10px; }
.tt-product-single-info .tt-row-custom-01 {
display: -ms-flexbox;
display: -webkit-flex;
display: flex;
-webkit-flex-direction: row;
-ms-flex-direction: row;
flex-direction: row;
-webkit-flex-wrap: wrap;
-ms-flex-wrap: wrap;
flex-wrap: nowrap;
-webkit-justify-content: flex-start;
-ms-flex-pack: start;
justify-content: flex-start;
-webkit-align-content: flex-start;
-ms-flex-line-pack: start;
align-content: flex-start;
-webkit-align-items: flex-start;
-ms-flex-align: start;
align-items: flex-start; }
.tt-product-single-info .tt-row-custom-01 .col-item:not(:last-child) {
margin-right: 20px; }
.tt-product-single-info .tt-row-custom-01 .col-item:nth-child(2) {
-webkit-flex: 1 1 auto;
-ms-flex: 1 1 auto;
flex: 1 1 auto; }
.tt-product-single-info .tt-row-custom-01 .btn.btn-lg {
font-size: 14px; }
.tt-product-single-info .tt-row-custom-01 .btn.btn-lg i {
font-size: 20px;
position: relative;
top: -3px; }
.tt-product-single-info .tt-wrapper {
margin-top: 33px; }
.tt-product-single-info .tt-wrapper + .tt-title,
.tt-product-single-info .tt-wrapper + .tt-price,
.tt-product-single-info .tt-wrapper + .tt-review,
.tt-product-single-info .tt-wrapper + .tt-add-info,
.tt-product-single-info .tt-swatches-container + .tt-title,
.tt-product-single-info .tt-swatches-container + .tt-price,
.tt-product-single-info .tt-swatches-container + .tt-review,
.tt-product-single-info .tt-swatches-container + .tt-add-info {
margin-top: 33px; }
.tt-product-single-info .tt-swatches-container .tt-wrapper:not(:first-child) {
margin-top: 12px; }
.tt-product-single-info .tt-swatches-container form {
margin-top: 7px; }
.tt-product-single-info .tt-options-swatch {
margin-top: -3px; }
.tt-product-single-info .tt-review + .tt-wrapper {
margin-top: 11px; }

.tt-product-single-info > *:nth-child(1) {
margin-top: 0; }
.tt-product-single-info .tt-list-btn {
display: -ms-flexbox;
display: -webkit-flex;
display: flex;
-webkit-flex-direction: row;
-ms-flex-direction: row;
flex-direction: row;
-webkit-flex-wrap: wrap;
-ms-flex-wrap: wrap;
flex-wrap: wrap;
-webkit-justify-content: flex-start;
-ms-flex-pack: start;
justify-content: flex-start;
-webkit-align-content: stretch;
-ms-flex-line-pack: stretch;
align-content: stretch;
list-style: none;
padding: 0;
margin: -10px 0 0 -20px; }
.tt-product-single-info .tt-list-btn li {
margin-left: 20px;
margin-top: 10px; }
@media (max-width: 1024px) {
.tt-product-single-info {
margin: 0;
padding-left: 0; }
.tt-product-single-info .tt-title {
font-size: 24px; }
.tt-product-single-info .tt-price {
font-size: 24px; } }
@media (max-width: 767px) {
.tt-product-single-info {
padding-top: 25px; } }
@media (max-width: 575px) {
.tt-product-single-info {
padding-top: 34px;
padding-left: 10px;
padding-right: 10px; }
.tt-product-single-info .tt-title {
margin-top: 14px;
font-size: 20px;
line-height: 30px; }
.tt-product-single-info .tt-row-custom-01 {
-webkit-flex-direction: column;
-ms-flex-direction: column;
flex-direction: column; }
.tt-product-single-info .tt-row-custom-01 .col-item {
width: 100%; }
.tt-product-single-info .tt-row-custom-01 .col-item .tt-input-counter.style-01 {
    max-width: 100%; }
.tt-product-single-info .tt-row-custom-01 .col-item:not(:first-child) {
margin-top: 31px; } }
.tt-product-single-info .tt-label {
margin-left: -10px;
margin-top: -10px; }
.tt-product-single-info .tt-label [class^="tt-label"] {
font-family: Arial, Helvetica, sans-serif;
font-weight: 500;
font-size: 12px;
line-height: 17px;
padding: 4px 10px 2px;
display: inline-block;
margin-left: 10px;
margin-top: 10px;
border-radius: 6px; }
.related-products h2 {
    padding-top: 0px;
    font-size: 1.3em;
}
.related-products h3 {
    font-weight: normal;
    font-style: normal;
    text-align: left;
}
.related-products .price{
    color: #FF0000;
    margin-top:10px;
    font-size: 18px;
}
.buy-now {
    margin-right: 10px;
}
@media (max-width: 640px) {
    .product-single-info .detail-content ul {
        padding-left: 30px;
    }
    .tt-product-single-info .more-info span {
        display: block;
        padding: 5px 0px;
    }
    .tt-product-single-info .more-info span label {
        width: 120px;
    }
    .product-description {
        margin-top: 25px !important;
    }
    .tt-product-single-info .tt-price {
        font-size: 20px;
    }
}

@media (max-width: 767px) {
    .related-products .col-4 {
        flex: 0 0 50% !important;
        max-width: 50% !important;
    }
}
.news-detail-page .tt-post-single {
    text-align: justify;
}

</style>
@endsection
@section('schema')
<?php $productUrl = Constant::DOMAIN.genProductLink($category['slug'], $product['slug']);?>
<script type="application/ld+json">
    { 
        "@context":"http://schema.org",
        "@type":"WebSite",
        "name":"{{Constant::WEB_NAME}}",
        "url":"https://thaomocuytin.com",
        "potentialAction":{ 
            "@type":"SearchAction",
            "target":"https://thaomocuytin.com/tim-kiem?keyword={search_term_string}",
            "query-input":"required name=search_term_string"
        }
    }
</script>
<script type = 'application/ld+json' >
    {
    "@context":"http://schema.org",
    "@type":"BreadcrumbList",
    "itemListElement":[
        {
            "@type":"ListItem",
            "position":1,
            "item":{
                "@id":"<?php echo Constant::DOMAIN;?>",
                "name":"<?php echo Constant::WEB_NAME;?>"
            }
        }
        <?php
            $position = 3;
            if ($categoryParent) {
                $parentBreadScrumb = ',{"@type":"ListItem","position":2,"item":{"@id":"'.Constant::DOMAIN.'/'.$categoryParent['slug'].'","name":"'.$categoryParent['title'].'"}}';
                $child = ', {"@type":"ListItem","position":3,"item":{"@id":"'.Constant::DOMAIN.'/'.$category['slug'].'","name":"'.$category['title'].'"}}';
                echo $parentBreadScrumb.$child;
                $position = 4;
            } else {
                echo ', {"@type":"ListItem","position":2,"item":{"@id":"'.Constant::DOMAIN.'/'.$category['slug'].'","name":"'.$category['title'].'"}}';
            }
        ?>
        ,{
            "@type":"ListItem",
            "position": {{$position}},
            "item":{
                "@id":"{{$productUrl}}",
                "name":"{{$product['title']}}"
            }
        }
    ]
    }
</script>
<script type="application/ld+json">
{
    "@context": "http://schema.org/",
    "@type": "Product",
    "name": "{{ $product['title']}}",
    "description": "{{$product['description']}}",
    "image": "{{isset($pageImage) ? $pageImage : Constant::PAGE_IMAGE}}",
    "url": "{{$productUrl}}",
    "sku": "{{$product->sku}}",
    "mpn": "{{$product->sku}}",
    "brand": {
        "@type": "Thing",
        "name": "{{$product->provider['title']}}"
    },  
    "offers": {
        "@type": "Offer",
        "url": "{{$productUrl}}",
        "priceCurrency": "VND",
        "price": "{{$product->price}}",
        "priceValidUntil": "2025-05-21",
        "itemCondition": "https://schema.org/UsedCondition",
        "availability": "https://schema.org/InStock",
        "seller": {
            "@type": "Organization",
            "name": "{{Constant::WEB_NAME}}"
        }
    }
}
</script>
@endsection
@section('content')
<div class="tt-breadcrumb">
    <div class="container">
        <ul>
            <li><a href="/">Trang chủ</a></li>
            @if ($categoryParent['id'] !=$category['id'])
            <li>
            <a href="{{genCateLink($category['slug'])}}">
                {{$category['title']}}
            </a>
            </li>
            @endif
            <li>
                <span>
                    {{$product['title']}}
                </span>
            </li>
        </ul>
    </div>
</div>

<div id="tt-pageContent">
    <div class="container-indent">
        <?php $productThumbnail = genImage($product['thumbnail']);?>
        <!-- mobile product slider  -->
        <div class="tt-mobile-product-layout visible-xs">
            <div class="tt-mobile-product-slider arrow-location-center slick-animated-show-js">
                <!-- @foreach ($slides as $slide)                            
                <div>
                    <img src="{{ asset('/images/loader.svg') }}" 
                        data-src="{{genImage($slide['name'])}}" alt="{{$slide['title']}}">
                </div>
                @endforeach -->
                @if(!empty($product->image_list))
                    @foreach(explode(',', $product->image_list) as $idImage => $imageProduct)
                        
                        <div>
                        <img src="{{ isset($imageProduct) ? $imageProduct : ''}}"
                                 data-zoom-image="{{ isset($imageProduct) ? $imageProduct : ''}}" alt="{{ isset($product['title']) ? $product['title'] : ''}}">
                        </div>
                        
                    @endforeach
                @endif
            </div>
        </div>
        <!-- /mobile product slider  -->
        <div class="container container-fluid-mobile">
            <div class="row">
                <div class="col-4 hidden-xs">                    
                    <div class="tt-product-single-img no-zoom">
                        <!-- @if (isset($slides[0]))
                        <div>
                            <button class="tt-btn-zomm tt-top-right"><i class="icon-f-86"></i></button>
                            <img class="zoom-product" src="{{ asset('/images/loader.svg') }}"  
                                data-src='{{genImage($slides[0]['name'])}}' data-zoom-image="{{genImage($slides[0]['name'])}}" 
                            alt="{{$slides[0]['alt']}}">
                        </div>
                        @endif -->
                        @if(!empty($product->image_list))
                            @foreach(explode(',', $product->image_list) as $idImage => $imageProduct)
                                @if($idImage == 0)
                                <div>
                                  <button class="tt-btn-zomm tt-top-right"><i class="icon-f-86"></i></button>
                                <img src="{{ isset($imageProduct) ? $imageProduct : ''}}"
                                         data-zoom-image="{{ isset($imageProduct) ? $imageProduct : ''}}" alt="{{ isset($product['title']) ? $product['title'] : ''}}">
                                </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="product-images-carousel">
                        <ul id="smallGallery" class="arrow-location-02  slick-animated-show-js">
                           <!--  @foreach ($slides as $key=>$slide)
                            <li>
                                <a href="#" data-image="{{genImage($slide['name'])}}" data-zoom-image="{{genImage($slide['name'])}}">
                                    <img src="{{ asset('/images/loader.svg') }}" 
                                        data-src="{{genImage($slide['name'])}}" alt="{{$slide['alt']}}" />
                                </a>
                            </li>
                            @endforeach -->
                            @if(!empty($product->image_list))
                            @foreach(explode(',', $product->image_list) as $idImage => $imageProduct)
                                <li>
                                <a href="#" data-image="{{ isset($imageProduct) ? $imageProduct : ''}}" data-zoom-image="{{ isset($imageProduct) ? $imageProduct : ''}}">
                                    <img src="{{ asset('/images/loader.svg') }}" 
                                        data-src="{{ isset($imageProduct) ? $imageProduct : ''}}" alt="{{ isset($product['title']) ? $product['title'] : ''}}" />
                                </a>
                            </li>
                            @endforeach
                        @endif
                        </ul>
                    </div>
                </div>
                <div class="col-8">
                    <div class="tt-product-single-info">
                        <h1 class="tt-title">{{$product['title']}}</h1>
                        <div class="tt-review">
                            <div class="tt-rating">
                                <?php $numberRating = count($product->ratings)?>
                                @if($numberRating)
                                <?php $score = coverageRatingScore($product->ratings);?>
                                <?php echo genRating($score);?>
                                <a href="#">({{$ratingNumber}} Đánh giá)</a>
                                @endif
                            </div>
                        </div>
                        <div class="more-info">
                            <span><label>Mã sản phẩm:</label>{{$product->sku}}</span>
                            <span><label>Xuất xứ:</label>{{$product->provider['from']}}</span>
                        </div>
                        <div class="tt-wrapper product-description">
                            {{$product['description']}}
                        </div>
                        <div class="tt-price">
                            <span class="old-price">{{formatPrice($product['price']+$product['discount'])}}₫</span>
                            <span class="new-price">{{formatPrice($product['price'])}}₫</span>
                            <span class="tt-label-sale">
                                Tiết kiệm {{getLastPrice($product['price'], $product['discount_type'], $product['discount'])}}
                            </span>
                        </div>
                        <div class="tt-add-info col-12">
                            <p><i class="icon-transfer"></i>Miễn phí vận chuyển với đơn hàng trên 200k</p>
                            <p><i class="icon-guarantee"></i>Cam kết chính hãng 100%</p>
                            <p><i class="icon-return"></i>Hoàn tiền 150% nếu phát hiện hàng giả</p>
                        </div>
                        <div class="tt-wrapper">
                            <div class="tt-row-custom-01">
                                <div class="col-item">
                                    <div class="tt-input-counter style-01">
                                        <span class="minus-btn"></span>
                                        <input type="text" value="1" size="5"/>
                                        <span class="plus-btn"></span>
                                    </div>
                                </div>
                                <div class="col-item">
                                    <button href="#" class="btn btn-lg buy-now" data-product_id={{$product['id']}}
                                        data-csrf_token={{ csrf_token() }}>Mua ngay</button>
                                    <button href="#" class="btn btn-lg"><i class="icon-f-39"></i>Cho vào giỏ</button>
                                </div>
                            </div>
                        </div>
                        <div class="tt-collapse-block">
                            <div class="tt-item active">
                                <div class="detail-title">THÔNG TIN CHI TIẾT</div>
                                <div class="detail-content">
                                    <?php echo $product['content']?>
                                </div>
                            </div>
                            <div class="tt-item active related-products">
                                <h2>SẢN PHẨM TƯƠNG TỰ</h2>
                                <div class="container container-fluid-custom-mobile-padding">
                                    <div class="tt-product-listing">
                                    @foreach ($relatedProducts as $item)
                                    <div class="col-4 col-md-4 col-sm-4 tt-col-item">
                                        <?php $productLink=genProductLink($item['category_slug'], $item['slug'])?>
                                        <a href="{{$productLink}}">
                                            <img src="{{ asset('/images/loader.svg') }}"
                                                data-src="{{genImage($item['thumbnail'])}}" alt="{{$item['title']}}">
                                            <h3>{{$item['title']}}</h3>
                                        </a>
                                        <div class="tt-description">
                                            <div class="price">
                                                {{formatPrice($item['price'])}}₫
                                            </div>
                                            <div class="tt-rating">
                                                <?php $numberRating = count($item->ratings)?>
                                                @if($numberRating)
                                                <?php $score = coverageRatingScore($item->ratings);?>
                                                <?php echo genRating($score);?>
                                                <span>{{$numberRating}} đánh giá</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="tt-item active">
                                <div class="">
                                    <div class="tt-review-block">
                                        <div class="tt-row-custom-02">
                                            <div class="col-item">
                                                <div class="tt-collapse-title">HỎI ĐÁP & ĐÁNH GIÁ ({{count($ratings)}})</div>
                                            </div>
                                            <div class="col-item">
                                                <a href="#submit-question">Đặt câu hỏi</a>
                                            </div>
                                        </div>
                                        <div class="tt-review-comments">
                                            @if (!count($ratings))
                                            <div class="first-comment">
                                                Hãy là người đầu tiên đặt câu hỏi hoặc đánh giá cho <span>“{{$product['title']}}”</span>
                                            </div>    
                                            @else
                                            @foreach ($ratings as $rating)
                                            <div class="tt-item">
                                                <div class="tt-avatar">
                                                    <a href="#"><img src="" alt=""></a>
                                                </div>
                                                <div class="tt-content">
                                                    <div class="tt-rating">
                                                        <?php echo genRating($rating['rating']);?>
                                                    </div>
                                                    <div class="tt-comments-info">
                                                        <span class="username"><span>{{$rating['customer_name']}}</span></span>
                                                        <span class="time">{{date('d-m-Y', strtotime($rating['created_at']))}}</span>
                                                    </div>
                                                    <p>
                                                        {{$rating['content']}}
                                                    </p>
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                        <div class="tt-review-form" id="submit-question">
                                            <div class="tt-rating-indicator">
                                                <div class="tt-title">
                                                    Đánh giá của bạn về sản phẩm này:
                                                </div>
                                                <div class="tt-rating">
                                                    <i class="icon-star"></i>
                                                    <i class="icon-star"></i>
                                                    <i class="icon-star"></i>
                                                    <i class="icon-star-half"></i>
                                                    <i class="icon-star-empty"></i>
                                                </div>
                                            </div>
                                            <form class="form-default">
                                                <div class="form-group">
                                                    <label>
                                                        Thông tin cá nhân của bạn (<i>Thông tin của bạn luôn được bảo mật</i>):
                                                    </label>
                                                    <div class="row">
                                                        <div class="form-group col-6">
                                                            <input type="email" class="form-control" id="inputName" placeholder="Tên bạn">
                                                        </div>
                                                        <div class="form-group col-6">
                                                            <input type="password" class="form-control" id="inputEmail" placeholder="Số điện thoại">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="textarea" class="control-label">Câu hỏi hoặc đánh giá của bạn</label>
                                                    <textarea class="form-control"  id="textarea" placeholder="Câu hỏi hoặc đánh giá" rows="5"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn">GỬI</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
