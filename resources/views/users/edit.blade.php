@extends('layouts.app')

@section('title', 'Chỉnh sửa '.$user->name )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chỉnh sửa Thông tin thành viên {{ $user->name }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt thông tin</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('admin.users.update', ['id' => $user->id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
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
                                    <option value="1" @if($user->role == 1) selected @endif>Quản trị viên</option>
                                    <option value="2" @if($user->role == 2) selected @endif>Biên tập viên</option>
                                    <option value="2" @if($user->role == 3) selected @endif>Nhân viên kho</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" required value="{{ $user->email }}"/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Username</label>
                                <input type="text" class="form-control" name="name" placeholder="Username" value="{{ $user->name }}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Slug</label>
                                <input type="text" class="form-control" name="slug" value="{{ $user->slug }}"/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Họ tên</label>
                                <input type="text" class="form-control" name="nick_name" value="{{ $user->nick_name }}"/>
                            </div>

                              <div class="form-group">
                                <label for="exampleInputEmail1">Giới thiệu</label>
                                <input type="text" class="form-control" name="description" value="{{ $user->description }}"/>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" name="is_change_password" value="1" class="flat-red"> Chọn nếu muốn thay đổi mật khẩu
                                <label for="exampleInputEmail1">Mật khẩu</label>
                                <input type="password" class="form-control" name="password" placeholder="Mật khẩu" value="{{ $user->password }}" />
                            </div>

                            <div class="form-group">
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{ $user->avatar }}" width="80" height="70"/>
                                <input name="avatar" type="hidden" value="{{ $user->avatar }}"/>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="form-group" style="color: red;">
                                    @if ($errors->has('email'))
                                        <label for="exampleInputEmail1">{{ $errors->first('email') }}</label>
                                    @endif
                                </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
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

