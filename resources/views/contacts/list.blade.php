@extends('layouts.app')

@section('title', 'Danh sách liên hệ')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Liên hệ
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách liên hệ</a></li>
        </ol>
    </section>
    <div class="box-header with-border">
                        <h3 class="box-title">Tìm kiếm</h3>
                    </div>
                    <div class="box-body">
                        <form method="get">
                            <div class="form-group col-xs-6 col-md-6">
                                <label class="control-label">Tên sản phẩm</label>
                                <input class="form-control"
                                       value="{{ !empty($_GET['product_name']) ? $_GET['product_name'] : '' }}" name="product_name"
                                       placeholder="Tên sản phẩm"/>
                            </div>
                            <div class="form-group col-xs-6 col-md-6">
                                <label class="control-label">Số ĐT</label>
                                <input class="form-control"
                                       value="{{ !empty($_GET['phone']) ? $_GET['phone'] : '' }}" name="phone"
                                       placeholder="Số ĐT"/>
                            </div>
                            <div class="form-group col-xs-12 col-md-12">
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            </div>
                        </form>
                    </div>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a  href="{{ route('admin.contacts.create') }}"><button class="btn btn-primary">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">STT</th>
                                <th>Họ và tên</th>
                                <th>Số điện thoai</th>
                                <th>Trạng thái</th>
                                <th>Sản phẩm</th>
                                <th>Nội dung</th>
                                <th>Thành đơn</th>
                                <th>Thời gian</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contacts as $id => $contact )
                                <tr>
                                    <td>{{ ($id+1) }}</td>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->phone_number }}</td>
                                    <td>{{ $contact->reply == 1 ? 'Đã tư vấn' : 'chưa tư vấn' }}</td>
                                    <td>{{ $contact->message }}</td>
                                    <td>{{ $contact->content }}</td>
                                    <td>
                                            @php 
                                                if($contact->is_ordered == 0) {
                                                    echo "Nope";
                                                }
                                                if($contact->is_ordered == 1){
                                                    echo "Yep";
                                                }
                                            @endphp
                                        </td>
                                    <td>{{ $contact->created_at }}</td>    
                                    <td>
                                        <a href="{{ route('admin.contacts.edit', ['id' => $contact->id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a  href="{{ route('admin.contacts.destroy', ['contact_id' => $contact->id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="5%">STT</th>
                                <th>Họ và tên</th>
                                <th>Số điện thoai</th>
                                <th>Trạng thái</th>
                                <th>Sản phẩm</th>
                                <th>Nội dung</th>
                                <th>Thành đơn</th>
                                <th>Thời gian</th>
                                <th>Thao tác</th>
                            </tr>
                            </tfoot>
                        </table>
                        <div>
                            {{ $contacts->appends(Request::all())->links() }}
                        </div>
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

