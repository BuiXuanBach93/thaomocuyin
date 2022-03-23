@extends('layouts.app')

@section('content')
    @include('flash::message')
    <section class="content-header">
        <h1 class="pull-left">Danh sách bài viết</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ route('admin.news.create') }}"><button class="btn btn-primary">Thêm mới</button></a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="newses" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Slug</th>
                                <th>Danh mục</th>
                                <th>Hình ảnh</th>
                                <th>Người phụ trách</th>
                                <th>Ngày tạo</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
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
   <div class="box-header">
                @if(\App\Models\User::isManager(\Illuminate\Support\Facades\Auth::user()->role))
                 <p>Số bài chưa thanh toán : {{$notPaidPost}}</p>
                @foreach ($editors as $editor)
                <div class="col-xs-12"><p class="col-xs-2">{{$editor->name}} : {{$editor->countNotPaid}}</p> <button onclick="payPostForEditor({{$editor->id}})" style="width: 100px" class="btn btn-primary col-xs-2">Thanh toán</button></div>
                @endforeach
                @else
                <p>Số bài chưa thanh toán :</p>
                @foreach ($editors as $editor)
                @if(\Illuminate\Support\Facades\Auth::user()->id == $editor->id)
                <div class="col-xs-12"><p class="col-xs-2">{{$editor->name}} : {{$editor->countNotPaid}}</p></div>
                @endif
                @endforeach
                @endif
            </div>
<script type="text/javascript">
    function payPostForEditor(editorId){
            if(editorId > 0){
                $.ajax({
                    type: "get",
                    url: '{!! route('admin.payPostForEditor') !!}',
                    data: { 
                        editorId: editorId,
                      },
                    success: function(result){
                        location.reload();
                    }
                });
            }
        }; 
</script> 

@endsection



