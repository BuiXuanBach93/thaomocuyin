@extends('layouts.frontend_home')
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "MedicalBusiness",
        "name": "Thảo Mộc Uy Tín",
        "image": "https://thaomocuytin.com/images/logo_thaomocuytin.png",
        "@id": "https://thaomocuytin.com#MedicalBusiness",
        "url": "https://thaomocuytin.com",
        "telephone": "+84355258365",
        "priceRange": "500",
        "address": {
          "@type": "PostalAddress",
          "streetAddress": "Tòa V8 The Vesta, Phú Lãm, Hà Đông, Hà Nội",
          "addressLocality": "TP. Hà Nội",
          "postalCode": "100000",
          "addressCountry": "VN"
        },
        "geo": {
          "@type": "GeoCoordinates",
          "latitude": 20.945393,
          "longitude": 105.755947
        },
        "openingHoursSpecification": {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": [
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
            "Sunday"
          ],
          "opens": "08:00",
          "closes": "22:00"
        },
        "sameAs": [
            "https://www.facebook.com/thaomocuytin.com",
            "https://www.instagram.com/thaomocuytinvn",
            "https://twitter.com/thanhbinhpharma",
            "https://thaomocuytin.tumblr.com",
            "https://thaomocuytinvn.business.site",
            "https://www.pinterest.com/thaomocuytin",
            "https://www.linkedin.com/in/thaomocuytin"
        ],
        "founder": {
            "@type": "Person",
            "alternateName": ["Nguyễn Thị Bình", "Nguyen Thi Binh"],
            "sameAs": ["http://www.linkedin.com/in/dsnguyenthibinh", 
                    "https://www.pinterest.com/dsnguyenthibinh/", 
                    "https://vi.gravatar.com/dsnguyenthibinh", 
                    "https://www.instagram.com/dsnguyenthibinh/", 
                    "https://dsnguyenthibinh.tumblr.com/",
                    "https://twitter.com/dsnguyenthibinh",
                    "https://www.flickr.com/people/dsnguyenthibinh"], 
            "url": "https://thaomocuytin.com/nguyen-thi-binh", 
            "mainEntityOfPage": "https://thaomocuytin.com/nguyen-thi-binh", 
            "@id": "https://thaomocuytin.com/nguyen-thi-binh#person", 
            "familyName": "Nguyễn", 
            "additionalName": "Thị", 
            "givenName": "Bình", 
            "name": "Nguyễn Thị Bình",
            "description": "Dược sĩ Nguyễn Thị Bình với trình độ chuyên môn cao cũng như những kinh nghiệm vững vàng là đầu tàu cho đội ngũ dược sĩ trẻ tại nhà thuốc, các dược sĩ công tác tại Thảo Mộc Uy Tín.", 
            "jobTitle": {
                "@type": "DefinedTerm",
                "name": "CEO",
                "description": "CEO là viết tắt của từ Chief Executive Officer, có nghĩa là giám đốc điều hành, giữ trách nhiệm thực hiện những chính sách của hội đồng quản trị. Ở những tập đoàn có tổ chức chặt chẽ, các bạn sẽ thấy chủ tịch hội đồng quản trị thường đảm nhận luôn chức vụ CEO này"
            }
            ,
            "gender":"https://schema.org/Female",
            "email":"dsnguyenthibinh@gmail.com",
            "image":"https://thaomocuytin.com/images/duoc-si-nguyen-thi-binh.jpg"
        }
    }    
</script>
<?php
use App\Constant;
?>
@section('content')
<style type="text/css">
    .container, .container-fluid {
        width: 100%;
        padding-right: .75rem;
        padding-left: .75rem;
        margin-right: auto;
        margin-left: auto;
    }
    @media (min-width: 1400px){
        .container {
            max-width: 1320px;
        }
    }
    @media (max-width: 1400px){
        .container {
            max-width: -webkit-calc(1320px + 3rem);
            max-width: -moz-calc(1320px + 3rem);
            max-width: calc(1320px + 3rem);
            padding-right: 1.5rem;
            padding-left: 1.5rem;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
    }


    .BannerTop_banner-top__3urK2 {
        display: -moz-box;
        display: flex;
        padding: 2rem 0;
    }
    .BannerTop_banner-top__3urK2 .BannerTop_left__2iJqd {
        -moz-box-flex: 70%;
        flex: 70% 1;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        border-radius: 12px!important;
        position: relative;
    }
    .BannerTop_banner-top__3urK2 .BannerTop_right__Y-ggv {
        display: -moz-box;
        display: flex;
        -moz-box-flex: 30%;
        flex: 30% 1;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        -moz-box-orient: vertical;
        -moz-box-direction: normal;
        flex-direction: column;
        -moz-box-pack: justify;
        justify-content: space-between;
        margin-left: 1rem;
    }
    .CategoryList_category-list__2a4yq {
        position: relative;
    }
    .CategoryList_category-list__2a4yq .CategoryList_header__2Q_3w {
        display: -moz-box;
        display: flex;
        -moz-box-pack: justify;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .CategoryList_category-list__2a4yq .CategoryList_header__2Q_3w .CategoryList_title__2JQdV {
        font-weight: 700;
        font-size: 1.5rem;
    }
    .CategoryList_category-list__2a4yq .CategoryList_body__sMcM- {
        display: -moz-box;
        display: flex;
        padding-bottom: 20px;
    }
    .CategoryList_category-list__2a4yq .CategoryList_body__sMcM- .CategoryList_category-item__1MvGF:first-child {
        margin-left: 0;
    }
    .CategoryList_category-list__2a4yq .CategoryList_body__sMcM- .CategoryList_category-item__1MvGF {
        width: 120px;
        margin: 0 40px;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        padding: 5px 10px;
        text-align: center;
        font-size: .938rem;
        cursor: pointer;
    }

    @media screen and (max-width: 992px){
        .CategoryList_category-list__2a4yq .CategoryList_body__sMcM- {
            -moz-box-orient: vertical;
            -moz-box-direction: normal;
            flex-direction: column;
            height: 350px;
            flex-wrap: wrap;
        }
    }

    @media screen and (max-width: 992px){
        .BannerTop_banner-top__3urK2 {
            width: 100%;
        }
    }

    .BannerTop_banner-top__3urK2 .BannerTop_left__2iJqd .BannerTop_image__2_3hK {
        height: 280px;
        border-radius: 15px!important;
    }
    .BannerTop_banner-top__3urK2 .BannerTop_right__Y-ggv .BannerTop_image__2_3hK {
        border-radius: 12px;
    }
    .slider-slide > img {
        width: 100%;
        display: block;
    }

    @media screen and (max-width: 576px){
        .BannerTop_banner-top__3urK2 .BannerTop_left__2iJqd .BannerTop_image__2_3hK {
            height: 162px;
        }
    }

    @media screen and (max-width: 576px){
        .CategoryList_category-list__2a4yq .CategoryList_body__sMcM- {
            overflow-x: auto;
            scroll-behavior: smooth;
            height: 320px;
        }
        .CategoryList_category-list__2a4yq .CategoryList_body__sMcM- .CategoryList_category-item__1MvGF {
            margin: 0 6px;
        }
    }


</style>
<div id="tt-pageContent" class="home-page">
    @if (!$isMobile)
    <div class="container">
    <div class="BannerTop_banner-top__3urK2">
        <div class="BannerTop_left__2iJqd">
            <div class="slider" tabindex="0" style="box-sizing: border-box; display: block; height: inherit; -moz-box-sizing: border-box; position: relative; width: 100%;">
                <div
                    class="slider-frame"
                    style="
                        box-sizing: border-box;
                        display: block;
                        height: 100%;
                        margin: 0px;
                        -moz-box-sizing: border-box;
                        -ms-transform: translate(0, 0);
                        overflow: hidden;
                        padding: 0;
                        position: relative;
                        touch-action: pinch-zoom pan-y;
                        transform: translate3d(0, 0, 0);
                        -webkit-transform: translate3d(0, 0, 0);
                    "
                >
                    <ul
                        class="slider-list"
                        style="
                            box-sizing: border-box;
                            cursor: pointer;
                            display: block;
                            height: 280px;
                            margin: 0px -10px;
                            padding: 0px;
                            position: relative;
                            touch-action: pan-y pinch-zoom;
                            transform: translate3d(-880px, 0px, 0px);
                            width: auto;
                            transition: all 0s ease 0s;
                        "
                    >
                        <li
                            class="slider-slide slide-visible slide-current"
                            style="
                                box-sizing: border-box;
                                display: inline-block;
                                height: 280px;
                                left: 880px;
                                list-style-type: none;
                                margin: auto 10px;
                                position: absolute;
                                top: 0px;
                                transform: scale(1);
                                transition: transform 0.4s linear 0s;
                                vertical-align: top;
                                width: 830px;
                            "
                            tabindex="-1"
                        >
                        
                        <img class="BannerTop_image__2_3hK" {{ asset('/images/loader.svg') }} data-src="/images/banner/desktop/desktop_banner_2.jpg" alt="banner" />
                        
                        </li>
                    </ul>
                </div>
                <style type="text/css">
                    .slider-slide > img {
                        width: 100%;
                        display: block;
                    }
                    .slider-slide > img:focus {
                        margin: auto;
                    }
                </style>
            </div>
        </div>
        <div class="BannerTop_right__Y-ggv">
            <a href="/ho-tro-sinh-san">
                <img class="BannerTop_image__2_3hK cursor-point" {{ asset('/images/loader.svg') }} data-src="/images/banner/desktop/banner_right_1.jpg" alt="banner-right-top" />
            </a>
            <a href="/ho-tro-sinh-san">
                <img class="BannerTop_image__2_3hK cursor-point" {{ asset('/images/loader.svg') }} data-src="/images/banner/desktop/banner_right_2.jpg" alt="banner-right-top" />
            </a>
        </div>
    </div>
    <div class="CategoryList_category-list__2a4yq">
        <div class="CategoryList_header__2Q_3w"><p class="CategoryList_title__2JQdV">Danh mục sản phẩm</p></div>
        <div class="CategoryList_body__sMcM-">
            <div class="slider" tabindex="0" style="box-sizing: border-box; display: block; height: inherit; -moz-box-sizing: border-box; position: relative; width: 100%;">
                <div aria-live="polite" aria-atomic="true" style="position: absolute; left: -10000px; top: auto; width: 1px; height: 1px; overflow: hidden;" tabindex="-1">Slide 1 of 8</div>
                <div
                    class="slider-frame"
                    style="
                        box-sizing: border-box;
                        display: block;
                        height: 100%;
                        margin: 0px;
                        -moz-box-sizing: border-box;
                        -ms-transform: translate(0, 0);
                        overflow: hidden;
                        padding: 0;
                        position: relative;
                        touch-action: pinch-zoom pan-y;
                        transform: translate3d(0, 0, 0);
                        -webkit-transform: translate3d(0, 0, 0);
                    "
                >
                    <ul
                        class="slider-list"
                        style="
                            box-sizing: border-box;
                            cursor: pointer;
                            display: block;
                            height: 152px;
                            margin: 0px;
                            padding: 0px;
                            position: relative;
                            touch-action: pan-y pinch-zoom;
                            transform: translate3d(0px, 0px, 0px);
                            width: auto;
                            transition: all 0s ease 0s;
                        "
                    >
                        <li
                            class="slider-slide slide-visible slide-current"
                            tabindex="-1"
                            style="
                                box-sizing: border-box;
                                display: inline-block;
                                height: 152px;
                                left: 0px;
                                list-style-type: none;
                                margin: auto 0px;
                                position: absolute;
                                top: 0px;
                                transform: scale(1);
                                transition: transform 0.4s linear 0s;
                                vertical-align: top;
                                width: 165px;
                            "
                        >
                            <div class="CategoryList_category-item__1MvGF">
                                <a href="/ho-tro-sinh-san">
                                    <img {{ asset('/images/loader.svg') }} data-src="/images/icon_home/ho-tro-sinh-san.png" alt="ho tro sinh san" />
                                    <p style="color: #666666">Sinh sản</p>
                                </a>
                            </div>
                        </li>
                        <li
                            class="slider-slide slide-visible"
                            tabindex="-1"
                            style="
                                box-sizing: border-box;
                                display: inline-block;
                                height: 152px;
                                left: 165px;
                                list-style-type: none;
                                margin: auto 0px;
                                position: absolute;
                                top: 0px;
                                transform: scale(1);
                                transition: transform 0.4s linear 0s;
                                vertical-align: top;
                                width: 165px;
                            "
                        >
                            <div class="CategoryList_category-item__1MvGF">
                                <a href="/sinh-ly-nam">
                                    <img {{ asset('/images/loader.svg') }} data-src="/images/icon_home/sinh-ly-nam.png" alt="sinh ly nam" />
                                    <p style="color: #666666">Sinh lý nam</p>
                                </a>
                            </div>
                        </li>
                        <li
                            class="slider-slide slide-visible"
                            tabindex="-1"
                            style="
                                box-sizing: border-box;
                                display: inline-block;
                                height: 152px;
                                left: 330px;
                                list-style-type: none;
                                margin: auto 0px;
                                position: absolute;
                                top: 0px;
                                transform: scale(1);
                                transition: transform 0.4s linear 0s;
                                vertical-align: top;
                                width: 165px;
                            "
                        >
                            <div class="CategoryList_category-item__1MvGF">
                               <a href="/giu-gin-voc-dang">
                                    <img {{ asset('/images/loader.svg') }} data-src="/images/icon_home/giu-gin-voc-dang.png" alt="giu gin voc dang" />
                                    <p style="color: #666666">Dáng chuẩn</p>
                                </a>
                            </div>
                        </li>
                        <li
                            class="slider-slide slide-visible"
                            tabindex="-1"
                            style="
                                box-sizing: border-box;
                                display: inline-block;
                                height: 152px;
                                left: 495px;
                                list-style-type: none;
                                margin: auto 0px;
                                position: absolute;
                                top: 0px;
                                transform: scale(1);
                                transition: transform 0.4s linear 0s;
                                vertical-align: top;
                                width: 165px;
                            "
                        >
                            <div class="CategoryList_category-item__1MvGF">
                                <a href="/cham-soc-suc-khoe">
                                    <img {{ asset('/images/loader.svg') }} data-src="/images/icon_home/cham-soc-suc-khoe.png" alt="cham soc suc khoe" />
                                    <p style="color: #666666">Tăng đề kháng</p>
                                </a>
                            </div>
                        </li>
                        <li
                            class="slider-slide slide-visible"
                            tabindex="-1"
                            style="
                                box-sizing: border-box;
                                display: inline-block;
                                height: 152px;
                                left: 660px;
                                list-style-type: none;
                                margin: auto 0px;
                                position: absolute;
                                top: 0px;
                                transform: scale(1);
                                transition: transform 0.4s linear 0s;
                                vertical-align: top;
                                width: 165px;
                            "
                        >
                            <div class="CategoryList_category-item__1MvGF">
                                <a href="/suc-khoe-lam-dep">
                                    <img {{ asset('/images/loader.svg') }} data-src="/images/icon_home/lam-dep.png" alt="lam dep" />
                                    <p style="color: #666666">Làm đẹp</p>
                                </a>
                            </div>
                        </li>
                        <li
                            class="slider-slide slide-visible"
                            tabindex="-1"
                            style="
                                box-sizing: border-box;
                                display: inline-block;
                                height: 152px;
                                left: 825px;
                                list-style-type: none;
                                margin: auto 0px;
                                position: absolute;
                                top: 0px;
                                transform: scale(1);
                                transition: transform 0.4s linear 0s;
                                vertical-align: top;
                                width: 165px;
                            "
                        >
                            <div class="CategoryList_category-item__1MvGF">
                                <a href="/chuyen-khoa">
                                    <img {{ asset('/images/loader.svg') }} data-src="/images/icon_home/chuyen-khoa.png" alt="chuyen khoa" />
                                    <p style="color: #666666">Chuyên khoa</p>
                                </a>
                            </div>
                        </li>
                        <li
                            class="slider-slide slide-visible"
                            tabindex="-1"
                            style="
                                box-sizing: border-box;
                                display: inline-block;
                                height: 152px;
                                left: 990px;
                                list-style-type: none;
                                margin: auto 0px;
                                position: absolute;
                                top: 0px;
                                transform: scale(1);
                                transition: transform 0.4s linear 0s;
                                vertical-align: top;
                                width: 165px;
                            "
                        >
                            <div class="CategoryList_category-item__1MvGF">
                                <a href="/nhi-khoa">
                                    <img {{ asset('/images/loader.svg') }} data-src="/images/icon_home/suc-khoe-cua-be.png" alt="suc khoe cua be" />
                                    <p style="color: #666666">Nhi khoa</p>
                                </a>
                            </div>
                        </li>
                        <li
                            class="slider-slide slide-visible"
                            tabindex="-1"
                            style="
                                box-sizing: border-box;
                                display: inline-block;
                                height: 152px;
                                left: 1155px;
                                list-style-type: none;
                                margin: auto 0px;
                                position: absolute;
                                top: 0px;
                                transform: scale(1);
                                transition: transform 0.4s linear 0s;
                                vertical-align: top;
                                width: 165px;
                            "
                        >
                            <div class="CategoryList_category-item__1MvGF">
                               <a href="/bao-cao-su">
                                    <img {{ asset('/images/loader.svg') }} data-src="/images/icon_home/bao-cao-su.png" alt="bao cao su" />
                                    <p style="color: #666666">Bao cao su</p>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
                <style type="text/css">
                    .slider-slide > img {
                        width: 100%;
                        display: block;
                    }
                    .slider-slide > img:focus {
                        margin: auto;
                    }
                </style>
            </div>
        </div>
    </div>
    </div>
    @else
    <div class="container">
    <div class="BannerTop_banner-top__3urK2" style="padding: 0px !important;">
        <div class="BannerTop_left__2iJqd">
            <div class="slider" tabindex="0" style="box-sizing: border-box; display: block; height: inherit; -moz-box-sizing: border-box; position: relative; width: 100%;">
                <div
                    class="slider-frame"
                    style="
                        box-sizing: border-box;
                        display: block;
                        height: 100%;
                        margin: 0px;
                        -moz-box-sizing: border-box;
                        -ms-transform: translate(0, 0);
                        overflow: hidden;
                        padding: 0;
                        position: relative;
                        touch-action: pinch-zoom pan-y;
                        transform: translate3d(0, 0, 0);
                        -webkit-transform: translate3d(0, 0, 0);
                    "
                >
                    <ul
                        class="slider-list"
                        style="
                            box-sizing: border-box;
                            cursor: pointer;
                            display: block;
                            height: 162px;
                            margin: 0px -10px;
                            padding: 0px;
                            position: relative;
                            touch-action: pan-y pinch-zoom;
                            transform: translate3d(-347px, 0px, 0px);
                            width: auto;
                            transition: all 0s ease 0s;
                        "
                    >
                        
                        <li
                            class="slider-slide slide-visible slide-current"
                            style="
                                box-sizing: border-box;
                                display: inline-block;
                                height: 162px;
                                left: 347px;
                                list-style-type: none;
                                margin: auto 10px;
                                position: absolute;
                                top: 0px;
                                transform: scale(1);
                                transition: transform 0.4s linear 0s;
                                vertical-align: top;
                                width: 94%;
                            "
                            tabindex="-1"
                        >
                        
                            <img class="BannerTop_image__2_3hK" {{ asset('/images/loader.svg') }} data-src="/images/banner/mobile/mobile_banner_2.jpg" alt="banner" />
                        
                        </li>
                    </ul>
                </div>
                <style type="text/css">
                    .slider-slide > img {
                        width: 100%;
                        display: block;
                    }
                    .slider-slide > img:focus {
                        margin: auto;
                    }
                </style>
            </div>
        </div>
    </div>
    <div class="CategoryList_category-list__2a4yq">
        <div class="CategoryList_header__2Q_3w"><p class="CategoryList_title__2JQdV">Danh mục sản phẩm</p></div>
        <div class="CategoryList_body__sMcM-">
            <div class="CategoryList_category-item__1MvGF">
                <a href="/ho-tro-sinh-san">
                    <img {{ asset('/images/loader.svg') }} data-src="/images/icon_home/ho-tro-sinh-san.png" alt="ho tro sinh san" />
                    <p style="color: #666666">Sinh sản</p>
                </a>
            </div>
            <div class="CategoryList_category-item__1MvGF">
                 <a href="/sinh-ly-nam">
                    <img {{ asset('/images/loader.svg') }} data-src="/images/icon_home/sinh-ly-nam.png" alt="sinh ly nam" />
                    <p style="color: #666666">Sinh lý nam</p>
                </a>
            </div>
            <div class="CategoryList_category-item__1MvGF">
                <a href="/giu-gin-voc-dang">
                    <img {{ asset('/images/loader.svg') }} data-src="/images/icon_home/giu-gin-voc-dang.png" alt="giu gin voc dang" />
                    <p style="color: #666666">Dáng chuẩn</p>
                </a>
            </div>
            <div class="CategoryList_category-item__1MvGF">
                <a href="/cham-soc-suc-khoe">
                    <img {{ asset('/images/loader.svg') }} data-src="/images/icon_home/cham-soc-suc-khoe.png" alt="cham soc suc khoe" />
                    <p style="color: #666666">Tăng đề kháng</p>
                </a>
            </div>
            <div class="CategoryList_category-item__1MvGF">
                <a href="/suc-khoe-lam-dep">
                    <img {{ asset('/images/loader.svg') }} data-src="/images/icon_home/lam-dep.png" alt="lam dep" />
                    <p style="color: #666666">Làm đẹp</p>
                </a>
            </div>
            <div class="CategoryList_category-item__1MvGF">
                <a href="/chuyen-khoa">
                    <img {{ asset('/images/loader.svg') }} data-src="/images/icon_home/chuyen-khoa.png" alt="chuyen khoa" />
                    <p style="color: #666666">Chuyên khoa</p>
                </a>
            </div>
            <div class="CategoryList_category-item__1MvGF">
                <a href="/nhi-khoa">
                    <img {{ asset('/images/loader.svg') }} data-src="/images/icon_home/suc-khoe-cua-be.png" alt="suc khoe cua be" />
                    <p style="color: #666666">Nhi khoa</p>
                </a>
            </div>
            <div class="CategoryList_category-item__1MvGF">
                <a href="/bao-cao-su">
                    <img {{ asset('/images/loader.svg') }} data-src="/images/icon_home/bao-cao-su.png" alt="bao cao su" />
                    <p style="color: #666666">Bao cao su</p>
                </a>
            </div>
        </div>
    </div>
</div>

    @endif


    @foreach ($categoryProducts as $categoryProduct)
    <div class="container-indent1">
        <div class="container container-fluid-custom-mobile-padding">
            <div class="tt-block-title text-left">
                <h2 class="tt-title">{{$categoryProduct['title']}}</h2>
            </div>
            <div class="tt-tab-wrapper">
                <ul class="nav nav-tabs tt-tabs-default">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="{{$categoryProduct['slug']}}">
                            Xem tất cả
                        </a>
                    </li>
                    @foreach ($categoryProduct['children'] as $child)
                    @if ($child['is_important'])
                    <li class="nav-item">
                        <a class="nav-link" href="{{$child['slug']}}">
                            {{$child['title']}}
                        </a>
                    </li>    
                    @endif
                    
                    @endforeach
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="tt-carousel-products row arrow-location-tab tt-alignment-img tt-layout-product-item slick-animated-show-js">
                            @foreach ($categoryProduct['product'] as $key=>$item)
                            <div class="col-2 col-md-4 col-lg-3">
                                <div class="tt-product thumbprod-center">
                                    <?php $productLink=genProductLink($item['category_slug'], $item['slug'])?>
                                    <div class="tt-image-box">
                                        <a href="{{$productLink}}">
                                            <img data-src="{{genImage($item['thumbnail'])}}" alt="{{$item['title']}}">
                                            <span class="tt-label-location">
                                                @if($item['discount_type'] == 1)
                                                    <span class="tt-label-sale">
                                                        Giảm {{getLastPrice($item['price'], $item['discount_type'], $item['discount'])}}
                                                    </span>
                                                @endif
                                            </span>
                                            <h3 class="tt-title">{{$item['short_name']}}</h3>
                                        </a>
                                    </div>
                                    <div class="tt-description">
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
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    
    <div class="container">
            <div class="row tt-services-listing">
                <div class="col-xs-12 col-md-6 col-lg-4">
                    <a href="javascript:void(0)" class="tt-services-block">
                        <div class="tt-col-icon">
                            <i class="icon-f-48"></i>
                        </div>
                        <div class="tt-col-description">
                            <h4 class="tt-title">MIỄN PHÍ SHIP</h4>
                            <p>Miễn phí ship cho những đơn hàng trên 500k</p>
                        </div>
                    </a>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-4">
                    <a href="javascript:void(0)" class="tt-services-block">
                        <div class="tt-col-icon">
                            <i class="icon-f-35"></i>
                        </div>
                        <div class="tt-col-description">
                            <h4 class="tt-title">BÁN HÀNG & HỖ TRỢ 24/7</h4>
                            <p>Làm việc 24h tất cả các ngày trong tuần</p>
                        </div>
                    </a>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-4">
                    <a href="javascript:void(0)" class="tt-services-block">
                        <div class="tt-col-icon">
                            <i class="icon-f-89"></i>
                        </div>
                        <div class="tt-col-description">
                            <h4 class="tt-title">CAM KẾT CHÍNH HÃNG</h4>
                            <p>Hoàn tiền 150% nếu phát hiện hàng giả</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    <div class="container-indent">
        <div class="container">
            <h1 class="tt-title-subpages noborder">THÔNG TIN SỨC KHOẺ</h1>
            <div class="tt-blog-masonry">
                <div class="tt-blog-init tt-grid-col-4 tt-layout-01-post tt-add-item tt-show">
                    @foreach ($newses as $key=> $news)
                    <?php $url = genProductLink($news['news_category']['slug'], $news['slug']);?>
                    <div class="element-item sort-value-01">
                        <div class="tt-post">
                            <div class="tt-post-img">
                                <a href="{{$url}}">
                                    <img {{ asset('/images/loader.svg') }} data-src="{{genImage($news['thumbnail'])}}" alt="{{$news['title']}}">
                                </a>
                            </div>
                            <div class="tt-post-content">
                                <div class="tt-background"></div>
                                <h3 class="tt-title"><a href="{{$url}}">
                                    {{truncate($news['title'], 100)}}</a>
                                </h3>
                                <div class="tt-description">
                                    {{getDescription($news['description'], 130)}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection