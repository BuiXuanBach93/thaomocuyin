<style>
    .author .description{
        padding: 20px 0px;
    }
    .author {
        border-bottom: 1px solid#e9e7e7;
        margin-bottom: 20px;
    }
</style>
@extends('layouts.frontend')
@section('content')
<div id="tt-pageContent">
	<div class="container-indent">
		<div class="container container-fluid-custom-mobile-padding">
			<div class="row">
				<div class="col-sm-12 col-md-8 col-lg-9 tt-desctop-parent-menu-categories">
                    <div class="author">
                        <h1 class="title">Tác giả: {{$author->nick_name}}</h1>
                        <div class="description">
                            {{$author->description}}
                        </div>
                    </div>
					<div class="tt-listing-post tt-menu-categories">
						@foreach ($newses as $item)
						<?php $newsSlug = genProductLink($item['news_category']['slug'], $item['slug']);?>
                        <div class="tt-post">
							<div class="tt-post-img">
                                <a href="{{$newsSlug}}">
                                    <img src="{{genImage($item['thumbnail'])}}" alt="{{$item['title']}}" class="loaded" data-was-processed="true">
                                </a>
							</div>
							<div class="tt-post-content">
								<div class="tt-tag">
									<a href="{{genCateLink($item['news_category']['slug'])}}" class="text-uppercase">
										{{$item['news_category']['title']}}
									</a>
								</div>
								<h2 class="tt-title"><a href="{{$newsSlug}}">{{$item['title']}}</a></h2>
								<div class="tt-description">
									{{$item['short_description']}}
								</div>
								<div class="tt-meta">
									<div class="tt-autor">{{date('H:i d-m-Y', strtotime($item['created_at']))}}</div>
								</div>
							</div>
						</div>
                        @endforeach
					</div>
				</div>
				<div class="col-sm-12 col-md-4 col-lg-3 rightColumn">
					<div class="tt-block-aside">
						<h3 class="tt-aside-title">DANH MỤC</h3>
						<div class="tt-aside-content">
							<ul class="tt-list-row">
								@foreach ($newsCategories as $item)
								<li><a href="{{genCateLink($item['slug'])}}">{{$item['title']}}</a></li>	
								@endforeach
							</ul>
						</div>
					</div>
					<div class="tt-block-aside">
						<h3 class="tt-aside-title">TÌM KIẾM</h3>
						<div class="tt-aside-content">
							<form class="form-default">
								<div class="tt-form-search">
									<input type="text" class="form-control">
									<button type="submit" class="tt-btn-icon icon-f-85"></button>
								</div>
							</form>
						</div>
					</div>
					<div class="tt-block-aside">
						<h3 class="tt-aside-title">THEO DÕI CHÚNG TÔI</h3>
						<div class="tt-aside-content">
							<ul class="tt-social-icon">
								<li><a class="icon-g-64" rel="nofollow"	href="https://www.facebook.com/thaomocuytin/"></a></li>
								<li><a class="icon-h-58" rel="nofollow"	href="https://twitter.com/NhaSumo"></a></li>
								<li><a class="icon-g-67" rel="nofollow"	href="https://www.instagram.com/thaomocuytinvn/"></a></li>
								<li><a class="icon-g-70" rel="nofollow"	href="https://www.pinterest.com/thaomocuytin/"></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection