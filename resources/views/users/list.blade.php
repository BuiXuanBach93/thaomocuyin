@extends('layouts.app')

@section('title', 'Danh sách thành viên' )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thành viên
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách thành viên</a></li>
        </ol>
    </section>
    @include('flash::message')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a  href="{{ route('admin.users.create') }}"><button class="btn btn-primary">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="user" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">STT</th>
                                <th width="5%">ID</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Họ và Tên</th>
                                <th>Slug</th>
                                <th>Ảnh</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $id => $user )
                                <tr>
                                    <td>{{ ($id+1) }}</td>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->nick_name }}</td>
                                    <td>{{ $user->slug }}</td>
                                    <td><img src="{{ $user->avatar }}" width="150"/></td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.edit', ['id' => $user->id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a  href="{{ route('admin.users.destroy', ['id' => $user->id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="5%">STT</th>
                                <th width="5%">ID</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Họ và Tên</th>
                                <th>Slug</th>
                                <th>Ảnh</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>

    <div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content_1">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Bạn có chắc chắn muốn xóa?</h4>
            </div>
            <form action="" class="submitDelete" method="post" >
                {!! csrf_field() !!}
                {{ method_field('DELETE') }}
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Xóa</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

