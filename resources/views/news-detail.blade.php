<?php use App\Constant;?>
@extends('layouts.frontend')

@section('schema')
<?php 
$productUrl = Constant::DOMAIN.genProductLink($category['slug'], $product['slug']);
$authorUrl = Constant::DOMAIN.genAuthorLink($author['slug']);
?>
<script type="application/ld+json">
{
    "@context":"https://schema.org",
    "@graph":[
        {
            "@type":"ImageObject",
            "@id":"{{$productUrl}}#primaryimage",
            "inLanguage":"vi-VN",
            "url":"{{$product['seo_image']}}",
            "caption":"{{$product['seo_title']}}"
        },
        {
            "@type":"WebPage",
            "@id":"{{$productUrl}}#webpage",
            "url":"{{$productUrl}}",
            "name":"{{$product['seo_title']}}",
            "isPartOf":{
                "@id":"https://thaomocuytin.com/#website"
            },
            "primaryImageOfPage":{
                "@id":"{{$productUrl}}#primaryimage"
            },
            "datePublished":"{{$product['created_at']}}",
            "dateModified":"{{$product['updated_at']}}",
            "description":"{{$product['seo_description']}}",
            "breadcrumb":{
                "@id":"{{$productUrl}}#breadcrumb"
            },
            "inLanguage":"vi-VN",
            "potentialAction":[
                {
                "@type":"ReadAction",
                "target":[
                    "{{$productUrl}}"
                ]
                }
            ]
        },
        {
            "@type":"BreadcrumbList",
            "@id":"{{$productUrl}}#breadcrumb",
            "itemListElement":[
                {
                "@type":"ListItem",
                "position":1,
                "item":{
                    "@type":"WebPage",
                    "@id":"https://thaomocuytin.com/",
                    "url":"https://thaomocuytin.com/",
                    "name":"<?php echo Constant::WEB_NAME;?>"
                }
                }
                <?php
                $position = 3;
                if ($categoryParent) {
                    $parentBreadScrumb = ',{"@type":"ListItem","position":2,"item":{"@id":"'.Constant::DOMAIN.'/'.$categoryParent['slug'].'","name":"'.$categoryParent['title'].'"}}';
                    $child = ', {"@type":"ListItem","position":3,"item":{"@type":"WebPage", "@id":"'.Constant::DOMAIN.'/'.$category['slug'].'","url":"'.Constant::DOMAIN.'/'.$category['slug'].'","name":"'.$category['title'].'"}}';
                    echo $parentBreadScrumb.$child;
                    $position = 4;
                } else {
                    echo ', {"@type":"ListItem","position":2,"item":{"@type":"WebPage","@id":"'.Constant::DOMAIN.'/'.$category['slug'].'","url":"'.Constant::DOMAIN.'/'.$category['slug'].'","name":"'.$category['title'].'"}}';
                }
                ?>
                ,{
                "@type":"ListItem",
                "position": {{$position}},
                "item":{
                    "@type":"WebPage",
                    "@id":"{{$productUrl}}",
                    "url":"{{$productUrl}}",
                    "name":"{{$product['seo_title']}}"
                }
                }
            ]
        },
        {
            "@type":"Article",
            "@id":"{{$productUrl}}#article",
            "isPartOf":{
                "@id":"{{$productUrl}}#webpage"
            },
            "author":{
                "@id":"{{$authorUrl}}"
            },
            "headline":"{{$product['seo_title']}}",
            "datePublished":"{{$product['created_at']}}",
            "dateModified":"{{$product['updated_at']}}",
            "commentCount":{{$numberRating}},
            "mainEntityOfPage":{
                "@id":"{{$productUrl}}#webpage"
            },
            "publisher":{
                "@id":"https://thaomocuytin.com/#organization"
            },
            "image":{
                "@id":"{{$productUrl}}#primaryimage"
            },
            "articleSection":"{{$category['title']}}",
            "inLanguage":"vi-VN",
            "potentialAction":[
                {
                "@type":"CommentAction",
                "name":"Comment",
                "target":[
                    "{{$productUrl}}#submit-question"
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
<div class="container">
    <div class="headline bg0 flex-wr-sb-c p-rl-20 p-tb-8">
        <div class="f2-s-1 p-r-30 m-tb-6">
            <a href="/" class="breadcrumb-item f1-s-2 cl9">
                Trang chủ
            </a>

            @if ($categoryParent)
            <a href="{{genCateLink($categoryParent['slug'])}}" class="breadcrumb-item f1-s-2 cl9">
                {{$categoryParent['title']}}
            </a>
            @endif
            <a href="{{genCateLink($category['slug'])}}" class="breadcrumb-item f1-s-2 cl9">
                {{$category['title']}}
            </a>

            <span class="breadcrumb-item f1-s-2 cl9">
                {{$product['title']}}
            </span>
        </div>

        <div class="pos-relative size-a-2 bo-1-rad-22 of-hidden bocl11 m-tb-6">
            <input class="f1-s-1 cl6 plh9 s-full p-l-25 p-r-45" type="text" name="search" placeholder="Tìm kiếm">
            <button class="flex-c-c size-a-1 ab-t-r fs-20 cl2 hov-cl10 trans-03">
                <i class="zmdi zmdi-search"></i>
            </button>
        </div>
    </div>
</div>

<section class="bg0 p-b-140 p-t-10">
    <div class="container">
        <div class="row justify-content-center news-detail">
            <div class="col-md-10 col-lg-8 p-b-30">
                <div class="p-r-10 p-r-0-sr991">
                    <!-- Blog Detail -->
                    <div class="p-b-70">
                        <h1 class="f1-l-3 cl2 p-b-16 respon2">
                            {{$product['title']}}
                        </h1>

                        <div class="flex-wr-s-s p-b-40">
                            <span class="f1-s-3 cl8 m-r-5">
                                Ngày đăng -
                            </span>
                            <span class="f1-s-3 cl8 m-r-15">
                                <span>
                                    {{$product['created_at']->format('d/m/Y')}}
                                </span>
                            </span>
                        </div>
                        <div class="catalogue">
                            <p class="f1-s-5 cl3">Mục lục:<span class="toc_toggle"></span></p>
                            <ul class="toc_list">
                                <?php echo genCatalogue($product['content']);?>
                            </ul>
                        </div>
                        <div class="content">
                            <?php echo $product['content'];?>
                        </div>

                        <!-- Tag -->
                        <div class="flex-s-s p-t-12 p-b-15">
                            <span class="f1-s-12 cl5 m-r-8">
                                Tags:
                            </span>

                            <div class="flex-wr-s-s size-w-0">
                                @foreach ($product->tags as $tag)
                                <a href="{{genTagLink($tag['slug'])}}" class="f1-s-12 cl8 hov-link1 m-r-15">
                                    {{$tag['title']}}
                                </a>
                                @endforeach
                            </div>

                            <div class="rating">
                                <div class="point"></div>
                                <p class="txt">{{$ratingTxt}}</p>
                                <input type="hidden" value="{{$currentRating}}" id="current_rate">
                                <input type="hidden" value="{{$product['id']}}" id="product_id">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                            </div>
                        </div>

                        <!-- Share -->
                        <div class="flex-s-s">
                            <span class="f1-s-12 cl5 p-t-1 m-r-15">
                                Share:
                            </span>

                            <div class="flex-wr-s-s size-w-0">
                                <a href="#" id='fb-share-button' class="dis-block f1-s-13 cl0 bg-facebook borad-3 p-tb-4 p-rl-18 hov-btn1 m-r-3 m-b-3 trans-03">
                                    <i class="fab fa-facebook-f m-r-7"></i>
                                    Facebook
                                </a>

                                <a href="#" class="dis-block f1-s-13 cl0 bg-twitter borad-3 p-tb-4 p-rl-18 hov-btn1 m-r-3 m-b-3 trans-03">
                                    <i class="fab fa-twitter m-r-7"></i>
                                    Twitter
                                </a>

                                <a href="#" class="dis-block f1-s-13 cl0 bg-google borad-3 p-tb-4 p-rl-18 hov-btn1 m-r-3 m-b-3 trans-03">
                                    <i class="fab fa-google-plus-g m-r-7"></i>
                                    Google+
                                </a>

                                <a href="#" class="dis-block f1-s-13 cl0 bg-pinterest borad-3 p-tb-4 p-rl-18 hov-btn1 m-r-3 m-b-3 trans-03">
                                    <i class="fab fa-pinterest-p m-r-7"></i>
                                    Pinterest
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Leave a comment -->
                    <div>
                        <div class="fb-comments" data-href="https://phukienone.com{{genProductLink($product['category_slug'], $product['slug'])}}"
                            data-width="100%" data-numposts="5"></div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-10 col-lg-4 p-b-30">
                <div class="p-l-10 p-rl-0-sr991 p-t-70 sidebar">
                    <!-- Popular Posts -->
                    <div class="p-b-30">
                        <div class="how2 how2-cl4 flex-s-c">
                            <h3 class="f1-m-2 cl3 tab01-title">
                                Bài viết nổi bật
                            </h3>
                        </div>

                        <ul class="p-t-35">
                            @foreach ($categoryProducts as $categoryProducts)
                            <li class="flex-wr-sb-s p-b-30">
                                <a href="{{genProductLink($categoryProducts['category_slug'], $categoryProducts['slug'])}}" class="size-w-10 wrap-pic-w hov1 trans-03">
                                    <img src="{{genImage($categoryProducts['thumbnail'], 200)}}" alt="{{$categoryProducts['title']}}">
                                </a>

                                <div class="size-w-11">
                                    <h6 class="p-b-4">
                                        <a href="{{genProductLink($categoryProducts['category_slug'], $categoryProducts['slug'])}}" class="f1-s-5 cl3 hov-cl10 trans-03">
                                            {{$categoryProducts['title']}}
                                        </a>
                                    </h6>

                                    <span class="cl8 txt-center p-b-24">
                                        <a href="{{genCateLink($categoryProducts['category_slug'])}}" class="f1-s-6 cl8 hov-cl10 trans-03">
                                            {{$categoryProducts['category_title']}}
                                        </a>

                                        <span class="f1-s-3 m-rl-3">
                                            -
                                        </span>

                                        <span class="f1-s-3">
                                                {{$categoryProducts['created_at']->format('F d')}}
                                        </span>
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
