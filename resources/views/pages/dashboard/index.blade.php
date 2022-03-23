@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
  
    <section class="content">
        <!-- Small boxes (Stat box) -->
        @if(\App\Models\User::isManager(\Illuminate\Support\Facades\Auth::user()->role))
        <div class="row">
            <div class="col-lg-2 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $countPost }}</h3>

                        <p>Bài viết</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                    </div>
                    <a href="news" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-2 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $countProduct }}</h3>

                        <p>Sản phẩm</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-product-hunt" aria-hidden="true"></i>
                    </div>
                    <a href="product" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
           
           <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $countContactNotDone }}/{{ $countContact }}</h3>
                    <p>Yêu cầu tư vấn</p>
                </div>
                <div class="icon">
                    <i class="ion ion-paper-airplane"></i>
                </div>
                <a href="contacts" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $countRemarketingNotDone }}/{{ $countRemarketing }}</h3>
                    <p>Hẹn tư vấn</p>
                </div>
                <div class="icon">
                    <i class="icon ion-ios-calendar"></i>
                </div>
                <a href="contact-remarketing" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <!-- ./col -->
        <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3>{{ $countCartItem }}/{{ $countOrderToday }}</h3>

                    <p>Sp thêm vào giỏ</p>
                    
                </div>
                <div class="icon">
                    <i class="ion ion-android-cart"></i>
                </div>
                <a href="trackingitems" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <!-- ./col -->
        <div class="col-lg-2 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $countOrderNotDone }}/{{ $countOrder }}</h3>

                    <p>Đơn hàng</p>
                    
                </div>
                <div class="icon">
                    <i class="ion ion-social-usd"></i>
                </div>
                <a href="orders" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        
        
          

        </div>
        @endif
        <!-- /.row -->

        @if(\App\Models\User::isStocker(\Illuminate\Support\Facades\Auth::user()->role))
        
        <div class="col-lg-2 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ $countOrderNotDelivery }}</h3>

                        <p>Đơn hàng chưa gửi</p>
                        
                    </div>
                    <div class="icon">
                        <i class="ion ion-social-usd"></i>
                    </div>
                    <a href="order-stocker" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endif

        @if(\App\Models\User::isEditor(\Illuminate\Support\Facades\Auth::user()->role))
        <div class="row">
            <div class="col-lg-2 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $countPost }}</h3>

                        <p>Bài viết</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                    </div>
                    <a href="news" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-2 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $countProduct }}</h3>

                        <p>Sản phẩm</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-product-hunt" aria-hidden="true"></i>
                    </div>
                    <a href="product" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        @endif
        
        <!-- /.row (main row) -->
    </section>
@endsection
