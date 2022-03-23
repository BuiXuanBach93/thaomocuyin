@extends('layouts.frontend_noindex')
@section('style')
<style>
.tt-post-single {
text-align: center;
padding-top: 3px; }
.tt-post-single .tt-tag {
display: -ms-flexbox;
display: -webkit-flex;
display: flex;
-webkit-flex-direction: row;
-ms-flex-direction: row;
flex-direction: row;
-webkit-flex-wrap: wrap;
-ms-flex-wrap: wrap;
flex-wrap: wrap;
-webkit-justify-content: center;
-ms-flex-pack: center;
justify-content: center;
-webkit-align-content: stretch;
-ms-flex-line-pack: stretch;
align-content: stretch;
-webkit-align-items: flex-start;
-ms-flex-align: start;
align-items: flex-start;
font-family: Arial, Helvetica, sans-serif;
font-size: 14px;
font-weight: 500;
line-height: 17px;
margin-top: -2px;
margin-left: -5px;
letter-spacing: 0.03em; }
.tt-post-single .tt-tag a {
display: inline-block;
padding: 2px 5px;
color: #288ad6;
transition: all 0.2s linear;
-ms-transition: all 0.2s linear;
-webkit-transition: all 0.2s linear;
-o-transition: all 0.2s linear; }
.tt-post-single .tt-tag a:hover {
color: #191919; }
.tt-post-single h1.tt-title:not(:first-child) {
margin-top: 24px; }
.tt-post-single h1.tt-title {
font-size: 34px;
line-height: 44px;
font-weight: 700;
letter-spacing: 0.03em; }
@media (max-width: 1024px) {
.tt-post-single h1.tt-title {
	font-size: 26px;
	line-height: 36px; } }
@media (max-width: 575px) {
.tt-post-single h1.tt-title {
	font-size: 23px;
	line-height: 33px; } }
.tt-post-single .tt-autor {
margin-top: 23px;
font-size: 12px;
color: #999999; }
.tt-post-single .tt-autor span {
color: #191919; }
.tt-post-single .tt-post-content {
text-align: left;
margin-top: 33px; }
.tt-post-single .tt-post-content img {
max-width: 100%;
height: auto;
margin-top: 20px; }
.tt-post-single .tt-post-content h2.tt-title:not(:first-child) {
margin-top: 32px; }
.tt-post-single .tt-post-content h2.tt-title {
font-size: 20px;
line-height: 30px;
font-weight: 500;
letter-spacing: 0.03em; }
.tt-post-single .tt-post-content p img {
	margin-top: 8px;
	margin-bottom: 8px; }
.tt-post-single .tt-post-content blockquote {
margin-top: 34px; }
.tt-post-single .tt-post-content .tt-blockquote {
padding-top: 49px;
padding-bottom: 44px; }
.tt-post-single .tt-post-content blockquote + p {
margin-top: 33px; }
.tt-post-single .tt-post-content .tt-box-link:not(:first-child) {
margin-top: 34px; }
.tt-post-single .tt-post-content .tt-box-link + p {
margin-top: 33px; }
.tt-post-single .tt-post-content .tt-box-link {
text-align: center;
padding: 29px 16px 33px 12px; }
.tt-post-single .tt-post-content > *:nth-child(1) {
margin-top: 0; }
.tt-post-single .tt-post-content > *:nth-child(1) div[class^="col-"] > *:nth-child(1) {
	margin-top: 0; }
.tt-post-single .tt-post-content .slick-slider img {
margin-top: 0; }
.tt-post-single .tt-post-content .tt-slick-row {
margin-top: 20px; }
@media (max-width: 575px) {
	.tt-post-single .tt-post-content .tt-slick-row {
	margin-top: 10px; } }
.tt-post-single .post-meta:not(:first-child) {
margin-top: 27px; }
.tt-post-single .post-meta {
font-size: 12px;
color: #999999;
text-align: left; }
.tt-post-single .post-meta a {
color: #288ad6;
letter-spacing: 0.02em;
transition: all 0.2s linear;
-ms-transition: all 0.2s linear;
-webkit-transition: all 0.2s linear;
-o-transition: all 0.2s linear; }
.tt-post-single .post-meta a:hover {
color: #191919; }
.tt-post-single > *:nth-child(1) {
margin-top: 0; }
@media (max-width: 1229px) {
.tt-post-single h1.tt-title:not(:first-child) {
margin-top: 18px; }
.tt-post-single .tt-autor {
margin-top: 17px; }
.tt-post-single .tt-post-content {
margin-top: 21px; }
.tt-post-single .tt-post-content h2.tt-title:not(:first-child) {
	margin-top: 26px; }
.tt-post-single .tt-post-content p {
	margin-top: 19px; }
	.tt-post-single .tt-post-content p img {
	margin-top: 2px;
	margin-bottom: 2px; }
.tt-post-single .tt-post-content blockquote {
	margin-top: 21px; }
.tt-post-single .tt-post-content .tt-blockquote {
	padding-top: 43px;
	padding-bottom: 38px; }
.tt-post-single .tt-post-content blockquote + p {
	margin-top: 21px; }
.tt-post-single .tt-post-content .post-meta:not(:first-child) {
	margin-top: 21px; }
.tt-post-single .tt-post-content .tt-box-link {
	text-align: center;
	padding: 23px 12px 27px; } }
@media (max-width: 575px) {
.tt-post-single h1.tt-title:not(:first-child) {
margin-top: 12px; }
.tt-post-single .tt-autor {
margin-top: 10px; }
.tt-post-single .tt-post-content {
margin-top: 18px; }
.tt-post-single .tt-post-content h2.tt-title:not(:first-child) {
	margin-top: 20px; }
.tt-post-single .tt-post-content img {
	margin-top: 10px; }
.tt-post-single .tt-post-content p {
	margin-top: 13px; }
	.tt-post-single .tt-post-content p img {
	margin-top: 2px;
	margin-bottom: 2px; }
.tt-post-single .tt-post-content blockquote {
	margin-top: 21px; }
.tt-post-single .tt-post-content .tt-blockquote {
	padding-top: 37px;
	padding-bottom: 32px; }
.tt-post-single .tt-post-content blockquote + p {
	margin-top: 21px; }
.tt-post-single .tt-post-content .post-meta:not(:first-child) {
	margin-top: 15px; }
.tt-post-single .tt-post-content .tt-box-link {
	text-align: center;
	padding: 17px 12px 21px; } }
	.tt-post-single {
	text-align: left;
	}
	
	.tt-post-single .tt-autor {
	text-align: left;
	margin-top:5px;
	}
	.tt-post-single .tt-post-content h2.tt-title {
	font-size:18px;
	}
	
	.tt-post-single .tt-post-content {
	color:#000;
	font-size: 15px;
	font-weight: 400;
	}
	.tt-post-single h1.tt-title {
	font-size: 28px;
	line-height: 34px;   
	}
	.tt-post-single .tt-post-content h2, .tt-post-single .tt-post-content h3 {
  margin-top:25px;
}
.tt-post-single .tt-post-content a{
  text-decoration: none;
}
.tt-post-single .tt-post-content img{
display: block;
margin: 15px auto;
}
.tt-post-single .tt-post-content img + caption{
display: block;
color: #6c757d;
font-size: 14px;
padding-top: 0px;
text-align: center;
font-weight: normal;
}
.tt-post-single .tt-post-content img{
max-width: 100% !important;
}
.news-detail-page {
  margin-top: 35px !important;
  text-align: justify;
}
</style>
@endsection
@section('content')
<div class="tt-breadcrumb">
    <div class="container">
        <ul>
            <li><a href="/">Trang chủ</a></li>
            <li>
				<a href="{{genCateLink($newsCategory['slug'])}}">
					{{$newsCategory['title']}}
				</a>
            </li>
            <li>
                <span>
                    {{$news['title']}}
                </span>
            </li>
        </ul>
    </div>
</div>
<div id="tt-pageContent">
	<div class="container-indent news-detail-page">
		<div class="container container-fluid-custom-mobile-padding">
			<div class="row">
				<div class="col-xs-12 col-md-8 col-lg-8">
					<div class="tt-post-single">
						<div style="margin-bottom:50px;"><?php echo convertViToEn($news['title'])?></div>
						<h1 class="tt-title">
							{{$news['title']}}
						</h1>
						<div class="tt-post-content">
							<?php echo $news['content'];?>
							<?php $url = "https://thaomocuytin.com".genProductLink($newsCategory['slug'], $news['slug']);?>
							<p>
								<strong>Nguồn: </strong> <a href="{{$url}}">{{$url}}</a>
							</p>
						</div>
					</div>
					<div class="comments-single-post">
						<h6 class="tt-title-border">BÀI VIẾT LIÊN QUAN</h6>
						<div class="tt-blog-thumb-list">
							<div class="row" style="padding-top:20px">
								<ul>
									@foreach ($newsRelated as $item)
										<?php $url=genProductLink($item['news_category']['slug'], $item['slug']);?>
										<li><a href="{{$url}}">{{$item['title']}}</a></li>
									@endforeach
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection