@extends('layouts.app')

@section('title', 'Thêm mới người dùng' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới thành viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Thành viên</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('admin.users.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-6">
    
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>
                        <!-- /.box-header -->

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Phân quyền</label>
                                    <select class="form-control" name="role">
                                        <option value="1">Quản trị viên</option>
                                        <option value="2">Biên tập viên</option>
                                        <option value="3">Nhân viên kho</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email" required />
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">User Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="username" />
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug</label>
                                    <input type="text" class="form-control" name="slug"/>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Họ tên</label>
                                    <input type="text" class="form-control" name="nick_name" placeholder="Họ tên" />
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giới thiệu</label>
                                    <input type="text" class="form-control" name="description" placeholder="Giới thiệu" />
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mật khẩu</label>
                                    <input type="text" class="form-control" name="password" placeholder="Mật khẩu" />
                                </div>

                                <div class="form-group col-sm-12">
                                    <label>Ảnh đại diện</label>
                                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                           size="20"/>
                                    <img src="" width="100"/>
                                    <input name="avatar" type="hidden" value=""/>
                                </div>
                                
                                <div class="form-group" style="color: red;">
                                    @if ($errors->has('email'))
                                        <label for="exampleInputEmail1">{{ $errors->first('email') }}</label>
                                    @endif
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                            </div>
                    </div>
                    <!-- /.box -->

                </div>
            </form>
        </div>
    </section>

<script type="text/javascript">
    function uploadImage(e) {
        window.KCFinder = {
           callBack: function(url) {window.KCFinder = null;
                var img = new Image();
                img.src = url;
                $(e).next().attr("src",url);
                $(e).next().next().val(url);
            }
        };
        window.open('/kcfinder/browse.php?type=images&dir=images/public',
            'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
            'directories=0, resizable=1, scrollbars=0, width=800, height=600'
        );
    };
    function openKCFinder(e) {
        window.KCFinder = {
            callBackMultiple: function(files) {
                window.KCFinder = null;
                var urlFiles = "";
                $(e).next().empty();
                for (var i = 0; i < files.length; i++){
                    $(e).next().append('<img src="'+ files[i] +'" width="80" height="70" style="margin-left: 5px; margin-bottom: 5px;"/>');
                    urlFiles += files[i] ;
                    if (i < (files.length - 1)) {
                        urlFiles += ',';
                    }
                }

                $(e).next().next().val(urlFiles);
            }
        };
        window.open('/kcfinder/browse.php?type=images&dir=images/public',
            'kcfinder_multiple', 'status=0, toolbar=0, location=0, menubar=0, ' +
            'directories=0, resizable=1, scrollbars=0, width=800, height=600'
        );
    }
</script>

@endsection

