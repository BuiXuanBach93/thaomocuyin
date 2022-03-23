<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Thảo Mộc Uy Tín - Backoffice</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/skins/_all-skins.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css">

    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    @yield('css')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
            transform: scale(0.7);
        }

        /* Hide default HTML checkbox */
        .switch input {
        opacity: 0;
        width: 0;
        height: 0;
        }

        /* The slider */
        .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        }

        .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        }

        input:checked + .slider {
        background-color: #2196F3;
        }

        input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
        border-radius: 34px;
        }

        .slider.round:before {
        border-radius: 50%;
        }
        
        input[type="submit"] {
            margin-right: 15px;
        }
    </style>
</head>

<body class="skin-blue sidebar-mini">
@if (!Auth::guest())
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="dashboard" class="logo">
                <b style="font-weight: 300;">Thanh Bình Pharamcy</b>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account Menu -->

                        @if(\App\Models\User::isManager(\Illuminate\Support\Facades\Auth::user()->role))
                <li class="dropdown" id="reports">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" onclick="return seenNotification(this)">
                        <i class="fa fa-bell" aria-hidden="true"></i>
                    </button>
                    <script>
                        function seenNotification(e) {
                            $('#ajax_countRp').empty();
                            $.ajax({
                                url: '/admin/xem-thong-bao',
                                method: 'get',
                                success: function(data){
                                },
                                error: function(){},
                            });

                            return true;
                        }
                    </script>
                    @if (!empty($countRp))
                    <span id="ajax_countRp" class="badge"> {!! $countRp !!} </span>
                    <audio controls autoplay hidden loop>
                        <source src="https://thuocuytin.com.vn/public/library/images/notify_babyshark.mp3" type="audio/mpeg">
                    </audio>
                    @endif
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li>
                            <b>THÔNG BÁO</b>
                        </li>
                        @foreach($notifications as $ntf)
                            <li class="@if($ntf->status == 0 || $ntf->status == 1) blue @else white @endif ">
                                <a id="{{ $ntf->id }}" href="{{$ntf->slug}}" onclick="return readNotification(this)" >{!! '<b>'. $ntf->title.'</b>'. " : " . $ntf->content . "<br/>" !!}</a>
                            </li>
                        @endforeach
                        {{--Bắt sự kiện click vào thông báo--}}
                        <script>
                            function readNotification(e) {
                                var id = $(e).attr('id');
                                $.ajax({
                                    url: '/admin/doc-thong-bao',
                                    method: 'get',
                                    data: {
                                        id: id
                                    },
                                    success: function(data){
                                    },
                                    error: function(){},
                                });

                                return true;
                            }
                        </script>
                    </ul>
                    
                </li>

                {{--endreport--}}
            @endif 

                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="/images/icon_admin.png"
                                     class="user-image" alt="User Image"/>
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{!! Auth::user()->name !!}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="/images/icon_admin.png"
                                         class="img-circle" alt="User Image"/>
                                    <p>
                                        {!! Auth::user()->name !!}
                                        <small>Member since {!! Auth::user()->created_at->format('M. Y') !!}</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{!! url('/admin/logout') !!}" class="btn btn-default btn-flat"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Sign out
                                        </a>
                                        <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer" style="max-height: 100px;text-align: center">
            <strong>Copyright © 2019 <a href="#">Company</a>.</strong> All rights reserved.
        </footer>

    </div>
@else
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{!! url('/') !!}">
                    thaomocuytin
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{!! url('/home') !!}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="{!! url('/login') !!}">Login</a></li>
                    <li><a href="{!! url('/register') !!}">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    abcs
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- jQuery 3.1.1 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/js/adminlte.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.proto.js"></script>
    <script src="{{ asset('/admin/ckeditor/ckeditor.js') }}"></script>
    <script type="{{ asset('/admin/ckfinder/ckfinder.js') }}"></script>
    <script src="{{ asset('/admin/js/main.js') }}"></script>
    <script src="{{ asset('/js/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('/js/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('/js/jquery.priceformat.js') }}"></script>

    @yield('scripts')

<script>
    $(function() {
        $('#products').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 50,
            ajax: '{!! route('admin.datatable_product') !!}',
            columns: [
                { data: 'id', name: 'products.id' },
                { data: 'title', name: 'products.title' },
                { data: 'slug', name: 'products.slug' },
                { data: 'category_title', name: 'category_title' , orderable: false, searchable: false },
                { data: 'thumbnail', name: 'products.thumbnail', orderable: false,
                    render: function ( data, type, row, meta ) {
                        return '<div class=""><img src="'+data+'" width="50" /></div>';
                    },
                    searchable: false  },
                { data: 'sku', name: 'products.sku' },
                { data: 'provider_title', name: 'provider_title' , orderable: false, searchable: false },
                { data: 'price', name: 'products.price' },
                { data: 'assignee_name', name: 'assignee_name' , orderable: false, searchable: false },
                { data: 'created_at', name: 'products.created_at' },
                { data: 'status', name: 'products.status', orderable: false,
                    render: function ( data, type, row, meta ) {
                        if(data == 1){
                            return "Publish";
                        }else{
                            return "UnPublish";
                        }
                    },
                    searchable: false  },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY h:mm A'
            }
        });

        $('#datePickerId').datepicker({
            timePicker: false,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY'
            }
        });

        $('.formatPrice').priceFormat({
                prefix: '',
                centsLimit: 0,
                thousandsSeparator: '.'
        });
    });

    $(function() {
        $('#newses').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 50,
            ajax: '{!! route('admin.datatable_news') !!}',
            columns: [
                { data: 'id', name: 'news.id' },
                { data: 'title', name: 'news.title' },
                { data: 'slug', name: 'news.slug' },
                { data: 'category_title', name: 'category_title' , orderable: false, searchable: false },
                { data: 'thumbnail', name: 'news.thumbnail', orderable: false,
                    render: function ( data, type, row, meta ) {
                        return '<div class=""><img src="'+data+'" width="50" /></div>';
                    },
                    searchable: false  },
                { data: 'assignee_name', name: 'assignee_name' , orderable: false, searchable: false },
                { data: 'created_at', name: 'products.created_at' },
                { data: 'status', name: 'news.status', orderable: false,
                    render: function ( data, type, row, meta ) {
                        if(data == 1){
                            return "Publish";
                        }else{
                            return "UnPublish";
                        }
                    },
                    searchable: false  },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });

</script>
 <script>
     function submitDelete(e) {
         var url = $(e).attr('href');
         console.log(url);
         $('.submitDelete').attr('action', url);
         return false;
     }

 </script>
<style>
    .modal-content_1 {
        background: #fff;
    }
</style>
</body>
</html>
