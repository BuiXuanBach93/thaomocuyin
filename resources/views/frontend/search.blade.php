@extends('layouts.frontend')
@section('schema')

@endsection
@section('content')
<div class="tt-breadcrumb">
    <div class="container">
        <ul>
            <li><a href="/">Trang chủ</a></li>
            <li>
                <span>
                    Tìm kiếm: <strong>{{$keyword}}</strong>
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
                                @foreach ($categories as $id=>$category)
                                <li class="">
                                    <a href="{{genCateLink($category['slug'])}}">
                                    {{$category['title']}}</a>
                                </li>
                                @endforeach
							</ul>
						</div>
					</div>
					<div class="tt-collapse open">
						<h3 class="tt-collapse-title">KHOẢNG GIÁ</h3>
						<div class="tt-collapse-content">
							<ul class="tt-list-row">
								<li><a href="#">Dưới 200.000đ</a></li>
								<li><a href="#">Từ 200.000đ — 400.000đ</a></li>
								<li><a href="#">Từ 400.000đ — 600.000đ</a></li>
                                <li><a href="#">Từ 600.000đ — 800.000đ</a></li>
                                <li><a href="#">Từ 800.000đ — 1.000.000đ</a></li>
                                <li><a href="#">Trên 1.000.000đ</a></li>
							</ul>
						</div>
					</div>
					<div class="tt-collapse open">
                        <h3 class="tt-collapse-title">Xuất xứ</h3>
                        <div class="tt-collapse-content">
                            <ul class="tt-options-swatch options-middle">
                                @foreach ($fromProviders as $slug=>$from)
                                <li>
                                    <a href="{{genLinkWithParam('nation', $slug)}}">{{$from}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
				</div>
				<div class="col-md-12 col-lg-9 col-xl-9">
					<div class="content-indent container-fluid-custom-mobile-padding-02">
						<div class="tt-filters-options">
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
</div>

@endsection
