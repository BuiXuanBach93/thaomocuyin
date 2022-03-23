<?php use App\Constant;
// $numberRating = 2;
// $score = 5;
// $maxRating = 5;

$numberRating = count($ratings);
$score = $numberRating ? coverageRatingScore($ratings): 5;
$maxRating = maxRatingScore($ratings) ? maxRatingScore($ratings): 5;
$numberRating = $numberRating ? $numberRating: 1;


?>
@extends('layouts.frontend')
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
.author-info img{
	width: 45px;
	height: 45px;
	border-radius: 45px;
}
.author-info a {
	padding-right: 10px;
	padding-left: 5px;
	color: #666666;
	font-weight: bold;
}
.tt-news-info .tt-rating{
	position: relative;
	top:12px;
}
.tt-news-info{
	background-color: #f2f2f2;
    padding: 10px;
}
h2{
	font-size: 16px;
}
.tt-block-aside img {
	max-width: 100%;
}
.author {
    text-align:center;
}
.author a.phone {
    display:block;
    margin-top:20px;
}
</style>
@endsection
@section('schema')
<?php 
$newsUrl = Constant::DOMAIN.genProductLink($newsCategory['slug'], $news['slug']);
$categoryUrl = Constant::DOMAIN.genCateLink($newsCategory['slug']);
$authorUrl = Constant::DOMAIN.genAuthorLink($author['slug']);
?>
<script type="application/ld+json">
	{
		"@context": "https://schema.org/",
		"@type": "CreativeWorkSeries",
		"name": "{{$news['seo_title']}}",
		"aggregateRating": {
			"@type": "AggregateRating",
			"ratingValue": "{{$score}}",
			"bestRating": "{{$maxRating}}",
			"ratingCount": "{{$numberRating}}"
		}
	}
	</script>
<script type="application/ld+json">
{
    "@context":"https://schema.org",
    "@graph":[
        {
            "@type":"ImageObject",
            "@id":"{{$newsUrl}}#primaryimage",
            "inLanguage":"vi-VN",
            "url":"{{$news['seo_image']}}",
            "caption":"{{$news['seo_title']}}"
        },
        {
            "@type":"WebPage",
            "@id":"{{$newsUrl}}#webpage",
            "url":"{{$newsUrl}}",
            "name":"{{$news['seo_title']}}",
            "isPartOf":{
                "@id":"https://thaomocuytin.com/#website"
            },
            "primaryImageOfPage":{
                "@id":"{{$newsUrl}}#primaryimage"
            },
            "datePublished":"{{convertTimeToVND($news['public_at'])}}",
            "dateModified":"{{convertTimeToVND($news['updated_at'])}}",
            "description":"{{$news['seo_description']}}",
            "breadcrumb":{
                "@id":"{{$newsUrl}}#breadcrumb"
            },
            "inLanguage":"vi-VN",
            "potentialAction":[
                {
                "@type":"ReadAction",
                "target":[
                    "{{$newsUrl}}"
                ]
                }
            ]
        },
        {
            "@type":"BreadcrumbList",
            "@id":"{{$newsUrl}}#breadcrumb",
            "itemListElement":[
                {
					"@type":"ListItem",
					"position":1,
					"item":{
							"@type":"WebPage",
							"@id":"https://thaomocuytin.com",
							"url":"https://thaomocuytin.com",
							"name":"<?php echo Constant::WEB_NAME;?>"
						}
				},
				{
					"@type":"ListItem",
					"position":2,
					"item":{
						"@type":"WebPage",
						"@id":"https://thaomocuytin.com/tin-tuc",
						"url":"https://thaomocuytin.com/tin-tuc",
						"name":"Tin tức"
					}
				},
				{
					"@type":"ListItem",
					"position":3,
					"item":{
						"@type":"WebPage",
						"@id":"{{$categoryUrl}}",
						"url":"{{$categoryUrl}}",
						"name":"{{$newsCategory['title']}}"
					}
				},
				{
					"@type":"ListItem",
					"position": 4,
					"item":{
						"@type":"WebPage",
						"@id":"{{$newsUrl}}",
						"url":"{{$newsUrl}}",
						"name":"{{$news['seo_title']}}"
					}
                }
            ]
        },
        {
            "@type":"Article",
            "@id":"{{$newsUrl}}#article",
            "isPartOf":{
                "@id":"{{$newsUrl}}#webpage"
            },
            "author":{
                "@id":"{{$authorUrl}}"
            },
            "headline":"{{$news['seo_title']}}",
            "datePublished":"{{convertTimeToVND($news['public_at'])}}",
            "dateModified":"{{convertTimeToVND($news['updated_at'])}}",
            "mainEntityOfPage":{
                "@id":"{{$newsUrl}}#webpage"
            },
            "publisher":{
                "@id":"https://thaomocuytin.com/#organization"
            },
            "image":{
                "@id":"{{$newsUrl}}#primaryimage"
            },
            "articleSection":"{{$newsCategory['title']}}",
            "inLanguage":"vi-VN",
            "potentialAction":[
                {
                "@type":"CommentAction",
                "name":"Comment",
                "target":[
                    "{{$newsUrl}}#submit-question"
                ]
                }
            ]
        },
        {
            "@type":[
                "Person"
            ],
            "@id":"{{$authorUrl}}",
            "name":"{{$author['nick_name']}}",
            "image":{
                "@type":"ImageObject",
                "@id":"{{$authorUrl}}#personlogo",
                "inLanguage":"vi-VN",
                "url":"{{$author['avatar']}}",
                "caption":"{{$author['description']}}"
            },
            "description":""
        }
    ]
}
</script>
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
						<h1 class="tt-title">
							{{$news['title']}}
						</h1>
						<div class="tt-news-info clearfix">
							<div class="author-info float-left">
								<img src="{{$author['avatar']}}" alt="{{$author['nick_name']}}">
								<a href="{{genAuthorLink($author['slug'])}}">{{$author['nick_name']}}</a>
								<span class="time">{{date('H:i d-m-Y', strtotime($news['public_at']))}}</span>
							</div>
                            <div class="tt-rating float-right">
                                @if($numberRating)
                                <?php echo genRating($score);?>
                                <span>({{$numberRating}} Đánh giá)</span>
                                @endif
                            </div>
                        </div>
						<div class="catalogue">
							<p class="title">Nội dung chính: <span class="toc_toggle"></span></p>
							<ul class="toc_list">
								<?php echo genCatalogue($news['content']);?>
							</ul>
						</div>
						<div class="tt-post-content">
							<h2>
								<?php echo $news['description'];?>
							</h2>
							<?php echo $news['content'];?>
							<div style="display: none" class="author">
								<a href="tel:{{Constant::PHONE_NUMBER}}" class="phone">
									<img src="{{ asset('/images/loader.svg') }}" width="800" height="400" alt="" data-src="{{ asset('/images/tu-van.jpg')}}">
								</a>
								<p> Bác Sỹ <a href="https://thaomocuytin.com/nguyen-thi-binh">Nguyễn Thị Bình</a> - người kiểm duyệt nội dung bài viết</p>
							</div>
						</div>
					</div>
					<div class="comments-single-post">
						<h6 class="tt-title-border">BÀI VIẾT LIÊN QUAN</h6>
						<div class="tt-blog-thumb-list">
							<div class="row">
								@foreach ($newsRelated as $item)
								<?php $url=genProductLink($item['news_category']['slug'], $item['slug']);?>
								<div class="col-sm-4">
									<div class="tt-blog-thumb">
										<div class="tt-img">
											<a href="{{$url}}">
												<img src="{{asset('images/loader.svg')}}" data-src="{{genImage($item['thumbnail'])}}" alt="{{$item['title']}}">
											</a>
										</div>
										<div class="tt-title-description">
											<div class="tt-background"></div>
											<h3 class="tt-title">
												<a href="{{$url}}">{{$item['title']}}</a>
											</h3>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
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
						<h3 class="tt-aside-title">BÀI VIẾT MỚI NHẤT</h3>
						<div class="tt-aside-content">
							<ul class="tt-list-row">
								@foreach ($newsestNews as $item)
								<?php $url=genProductLink($item['news_category']['slug'], $item['slug']);?>
								<li class="row clearfix">
									<a href="{{$url}}">
										<div class="col-md-3 col-lg-3 float-left">
											<img src="{{genImage($item['thumbnail'])}}" alt="{{$item['title']}}">
										</div>
										<div class="col-md-9 col-lg-9 float-right">
											{{$item['title']}}
										</div>
									</a>
								</li>	
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
				</div>
			</div>
		</div>
	</div>
</div>
@endsection