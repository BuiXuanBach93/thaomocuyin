<?php use App\Constant;?>
@extends('layouts.frontend')
@section('schema')
<script type="application/ld+json">
    { 
        "@context":"http://schema.org",
        "@type":"WebSite",
        "name":"<?php echo Constant::WEB_NAME;?>",
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
                "@id":"<?php echo Constant::DOMAIN?>",
                "name":"<?php echo Constant::WEB_NAME;?>"
            }
        }
        <?php
            if ($categoryParent['slug'] != $category['slug']) {
                $parentBreadScrumb = ',{"@type":"ListItem","position":2,"item":{"@id":"'.Constant::DOMAIN.'/'.$categoryParent['slug'].'","name":"'.$categoryParent['title'].'"}}';
                $child = ', {"@type":"ListItem","position":3,"item":{"@id":"'.Constant::DOMAIN.'/'.$category['slug'].'","name":"'.$category['title'].'"}}';
                echo $parentBreadScrumb.$child;
            } else {
                echo ', {"@type":"ListItem","position":2,"item":{"@id":"'.Constant::DOMAIN.'/'.$category['slug'].'","name":"'.$category['title'].'"}}';
            }
        ?>
    ]
    }
</script>
<?php $queryString = \Request::getQueryString();?>
@endsection
@section('content')
<div class="tt-breadcrumb">
    <div class="container">
        <ul>
            <li><a href="/">Trang chủ</a></li>
            @if ($categoryParent['id'] !=$category['id'])
            <li>
            <a href="{{genCateLink($categoryParent['slug'])}}">
                {{$categoryParent['title']}}
            </a>
            </li>
            @endif
            <li>
                <span>
                    {{$category['title']}}
                </span>
            </li>
        </ul>
    </div>
</div>

<div id="tt-pageContent" class="product-list-page">
	<div class="container-indent">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-lg-3 col-xl-3 leftColumn aside">
					<div class="tt-btn-col-close">
						<a href="#">Đóng</a>
					</div>
					<div class="tt-collapse open tt-filter-detach-option">
						<div class="tt-collapse-content">
							<div class="filters-mobile">
                                Sắp xếp theo
								<div class="filters-row-select">
								</div>
							</div>
						</div>
					</div>
					<div class="tt-collapse open">
						<h3 class="tt-collapse-title">DANH MỤC SẢN PHẨM</h3>
						<div class="tt-collapse-content">
							<ul class="tt-list-row">
                                @foreach ($sameCategories as $sameCategory)
                                <li class="{{$sameCategory['slug']== $category['slug']? 'active': ''}}">
                                    <a href="{{genCateLink($sameCategory['slug'])}}">
                                    {{$sameCategory['title']}}</a>
                                </li>
                                @endforeach
							</ul>
						</div>
					</div>
					<div class="tt-collapse open">
						<h3 class="tt-collapse-title">KHOẢNG GIÁ</h3>
						<div class="tt-collapse-content">
							<ul class="tt-list-row">
								<li class="{{strpos($queryString, '0-200000') ? 'active':''}}"><a href="{{genLinkWithParam('price', '0-200000')}}">Dưới 200.000đ</a></li>
								<li class="{{strpos($queryString, '200000-400000') ? 'active':''}}"><a href="{{genLinkWithParam('price', '200000-400000')}}">Từ 200.000đ — 400.000đ</a></li>
								<li class="{{strpos($queryString, '400000-600000') ? 'active':''}}"><a href="{{genLinkWithParam('price', '400000-600000')}}">Từ 400.000đ — 600.000đ</a></li>
                                <li class="{{strpos($queryString, '600000-800000') ? 'active':''}}"><a href="{{genLinkWithParam('price', '600000-800000')}}">Từ 600.000đ — 800.000đ</a></li>
                                <li class="{{strpos($queryString, '800000-999999') ? 'active':''}}"><a href="{{genLinkWithParam('price', '800000-999999')}}">Từ 800.000đ — 1.000.000đ</a></li>
                                <li class="{{strpos($queryString, '1000000') ? 'active':''}}"><a href="{{genLinkWithParam('price', '1000000')}}">Trên 1.000.000đ</a></li>
							</ul>
						</div>
					</div>
					<div class="tt-collapse open">
						<h3 class="tt-collapse-title">Xuất xứ</h3>
						<div class="tt-collapse-content">
							<ul class="tt-options-swatch options-middle">
                                @if ($fromProviders)
                                @foreach ($fromProviders as $slug=>$from)
                                <li class="{{strpos($queryString, $slug) ? 'active':''}}">
                                    <a href="{{genLinkWithParam('nation', $slug)}}">{{$from}}</a>
                                </li>
                                @endforeach
                                @endif
							</ul>
						</div>
					</div>
					{{-- <div class="tt-collapse open">
						<h3 class="tt-collapse-title">NHÀ CUNG CẤP</h3>
						<div class="tt-collapse-content">
							<ul class="tt-list-row">
                                @if ($providers)
                                @foreach ($providers as $provider)
                                <li class="{{strpos($queryString, $provider->slug) ? 'active':''}}">
                                    <a href="{{genLinkWithParam('provider', $provider->slug)}}">{{$provider->title}}</a>
                                </li>
                                @endforeach
                                @endif
							</ul>
						</div>
					</div> --}}
				</div>
				<div class="col-md-12 col-lg-9 col-xl-9">
					<div class="content-indent container-fluid-custom-mobile-padding-02">
						<div class="tt-filters-options">
                            <h1 class="tt-title">
                                {{$category['title']}}
                            </h1>
                            <div class="tt-btn-toggle">
								<a href="#">LỌC</a>
							</div>
                            <span class="tt-title-total">({{$newestProducts->total()}} sản phẩm)</span>
                            <div class="tt-sort">
                                <strong>Sắp xếp theo:</strong>
                                <select>
                                    <option value="">Nhiều người quan tâm </option>
                                    <option value="">Đánh giá tốt nhất</option>
                                    <option value="">Hàng mới về</option>
                                </select>
                            </div>
                            <div class="tt-quantity">
                                <a href="#" class="tt-col-one" data-value="tt-col-one"></a>
                                <a href="#" class="tt-col-two" data-value="tt-col-two"></a>
                                <a href="#" class="tt-col-three" data-value="tt-col-three"></a>
                                <a href="#" class="tt-col-four" data-value="tt-col-four"></a>
                                <a href="#" class="tt-col-six" data-value="tt-col-six"></a>
                            </div>
                        </div>
                        <div class="tt-product-listing row">
                            @if(count($newestProducts))
                            @foreach ($newestProducts as $item)
                            <div class="col-4 col-md-4 tt-col-item">
                                <div class="tt-product">
                                    <?php $productLink=genProductLink($item['category_slug'], $item['slug'])?>
                                    <div class="tt-image-box">
                                        <a href="{{$productLink}}">
                                            <img src="{{genImage($item['thumbnail'])}}" alt="{{$item['title']}}">
                                            <span class="tt-label-location">
                                                @if($item['discount_type'] == 1)
                                                <span class="tt-label-sale">
                                                    Giảm {{getLastPrice($item['price'], $item['discount_type'], $item['discount'])}}
                                                </span>
                                                @endif
                                            </span>
                                            <h2 class="tt-title">{{$item['title']}}</h2>
                                        </a>
                                    </div>
                                    <div class="tt-description">
                                        <div class="tt-price">
                                            @if($item['just_view'] == 0)
                                                <div class="tt-price">
                                                    @if($item['price'] > 0)
                                                        <span class="new-price">{{formatPrice($item['price'])}}₫</span>
                                                        @if($item['discount_type'] == 1)
                                                        <span class="old-price">{{formatPrice($item['price']+$item['discount'])}}₫</span>
                                                        @endif
                                                    @else
                                                        <span class="new-price">Liên hệ</span>
                                                    @endif
                                                </div>
                                            @else
                                            <div class="tt-price">
                                                <span class="new-price">Xem chi tiết</span>
                                            </div>
                                            @endif
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
                            </div>
                            @endforeach       
                            @else
                            <p class="no-item">Chưa có sản phẩm !</p>
                            @endif
                        
                        </div>
                        <div class="text-center tt_product_showmore">
                            {{ $newestProducts->links() }}
                        </div>
					</div>
				</div>
			</div>
		</div>
    </div>
    @if ($category['content'])
    <div class="cate-content">
        <div class="container">
            <?php echo $category['content']?>
        </div>
    </div>
    @endif
</div>

@endsection
