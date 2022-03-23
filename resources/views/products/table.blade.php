<table class="table table-responsive" id="news-table">
    <thead>
        <tr>
        <th>ID</th>
        <th>Tiêu đề</th>
        <th>SKU</th>
        <th>Trạng thái</th>
        <th>Danh mục</th>
        <th>Người phụ trách</th>
        <th>Ngày tạo</th>
            <th colspan="4">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{!! $product->id !!}</td>
            <td>{!! $product->title !!}</td>
            <td>{!! $product->sku !!}</td>
            <td>{!! $product->status == 1 ? 'Publish' : 'Unpublish'!!}</td>
            <td>{!! $product->getCateNameByID($product->category_id) !!}</td>
            <td>{!! $product->getAssignee($product->assignee_id)!!}</td>
            <td>{!! $product->created_at !!}</td>
            <td>
                <?php
                    $productLink = genProductLink($product->category->slug, $product->slug); 
                    $productLink = $product->status == 1 ?  $productLink : '/preview'.$productLink;
                ?>
                {!! Form::open(['route' => ['admin.product.destroy', $product->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a target="_blank" href="{{$productLink}}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href='{{"/admin/product/$product->id/rating"}}' class='btn btn-default btn-xs'><i class="glyphicon glyphicon-comment"></i></a>
                    <a href="{!! route('admin.product.edit', [$product->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
