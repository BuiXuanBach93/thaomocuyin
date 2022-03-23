@extends('layouts.frontend')

@section('content')
<!-- Post -->
<div class="container">
    <div class="bg0 flex-wr-sb-c p-rl-20 p-tb-8">
        <div class="f2-s-1 p-r-30 m-tb-6">
            <a href="/" class="breadcrumb-item f1-s-3 cl9">
                Trang chủ
            </a>
            <span class="breadcrumb-item f1-s-3 cl9">
                {{$tag['title']}}
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

<div class="container p-t-4 p-b-20">
    <h2 class="f1-l-1 cl2">
        Tag: {{$tag['title']}}
    </h2>
</div>

<section class="bg0 p-t-20 p-b-55">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 p-b-80">
                <div class="row">
                    @foreach ($newestProductses as $newestProducts)
                    <div class="col-sm-6 p-r-25 p-r-15-sr991">
                        <!-- Item latest -->
                        <div class="m-b-45">
                            <a href="{{genProductLink($newestProducts['category_slug'], $newestProducts['slug'])}}" class="wrap-pic-w hov1 trans-03">
                                <img src="{{$newestProducts['thumbnail']}}" alt="{{$newestProducts['title']}}">
                            </a>

                            <div class="p-t-16">
                                <h5 class="p-b-5">
                                    <a href="{{genProductLink($newestProducts['category_slug'], $newestProducts['slug'])}}" class="f1-m-3 cl2 hov-cl10 trans-03">
                                        {{_substr($newestProducts['title'])}}
                                    </a>
                                </h5>
                                <span class="cl8">
                                    <span class="f1-s-3">
                                        {{$newestProducts['created_at']->format('F d')}}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex-wr-s-c m-rl--7 p-t-15">
                    {{ $newestProductses->links() }}
                </div>
            </div>

            <div class="col-md-10 col-lg-4 p-b-80">
                <div class="p-l-10 p-rl-0-sr991">
                    <!-- Subscribe -->
                    <div class="bg10 p-rl-35 p-t-28 p-b-50 m-b-50">
                        <h5 class="f1-m-5 cl0 p-b-10">
                            Theo dõi chúng tôi
                        </h5>

                        <p class="f1-s-1 cl0 p-b-25">
                            Đăng ký để nhận những thông tin mới nhất về khuyến mãi
                        </p>

                        <div class="size-a-9 pos-relative register-email">
                            <meta name="csrf-token-register-email" content="{{ csrf_token() }}">
                            <input class="s-full f1-m-6 cl6 plh9 p-l-20 p-r-55" type="email" name="email" placeholder="Email">
                            <button class="size-a-10 flex-c-c ab-t-r fs-16 cl9 hov-cl10 trans-03" type="button">
                                <i class="fa fa-arrow-right"></i>
                            </button>
                            <p class="f1-s-1 cl0 p-t-15 txt"></p>
                        </div>
                    </div>

                    <!-- Most Popular -->
                    <div class="p-b-23">
                        <div class="how2 how2-cl4 flex-s-c">
                            <h3 class="f1-m-2 cl3 tab01-title">
                                Bài viết nổi bật
                            </h3>
                        </div>

                        <ul class="p-t-35">
                            <?php foreach($categoryProducts as $key=>$categoryProducts):?>
                            <li class="flex-wr-sb-s p-b-22">
                                <div class="size-a-8 flex-c-c borad-3 size-a-8 bg9 f1-m-4 cl0 m-b-6">
                                    {{$key+1}}
                                </div>

                                <a href="{{genProductLink($categoryProducts['category_slug'], $categoryProducts['slug'])}}" class="size-w-3 f1-s-7 cl3 hov-cl10 trans-03">
                                    {{$categoryProducts['title']}}
                                </a>
                            </li>
                            <?php endforeach;?>
                        </ul>
                    </div>

                    <!-- Tag -->
                    <div>
                        <div class="how2 how2-cl4 flex-s-c m-b-30">
                            <h3 class="f1-m-2 cl3 tab01-title">
                                Tags
                            </h3>
                        </div>

                        <div class="flex-wr-s-s m-rl--5">
                            @foreach ($tags as $tag)
                            <a href="{{genTagLink($tag['slug'])}}" class="flex-c-c size-h-2 bo-1-rad-20 bocl12 f1-s-1 cl8 hov-btn2 trans-03 p-rl-20 p-tb-5 m-all-5">
                                {{$tag['title']}}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
