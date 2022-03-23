@if(\App\Models\User::isManager(\Illuminate\Support\Facades\Auth::user()->role))
<li class="treeview" style="height: auto;">
    <a href="#"><i class="fa fa-product-hunt"></i> <span>Quản lý sản phẩm</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu" style="display: none;">
        <li><a href="/admin/product">Sản phẩm</a></li>
        <li><a href="/admin/providers">Nhà cung cấp</a></li>
        <li><a href="/admin/categories">Danh mục</a></li>
    </ul>
</li>
<li class="treeview" style="height: auto;">
    <a href="#"><i class="fa fa-newspaper-o"></i> <span>Quản lý bài viết</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu" style="display: none;">
        <li><a href="/admin/news">Bài viết</a></li>
        <li><a href="/admin/newsCategories">Danh mục bài viết</a></li>
        <li><a href="/admin/news/update-canonical">Update canonical</a></li>
    </ul>
</li>
<li class="treeview" style="height: auto;">
    <a href="#"><i class="fa fa-shopping-basket"></i> <span>Quản lý đơn hàng</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu" style="display: none;">
        <li><a href="/admin/orders">Đơn hàng</a></li>
        <li><a href="/admin/trackingitems">Tracking</a></li>
    </ul>
</li>
<li class="treeview" style="height: auto;">
    <a href="#"><i class="fa fa-paper-plane"></i> <span>Quản lý liên hệ</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu" style="display: none;">
        <li><a href="/admin/contacts">Danh sách liên hệ</a></li>
        <li><a href="/admin/contact-remarketing">Danh sách hẹn tư vấn</a></li>
    </ul>
</li>
<li class="treeview" style="height: auto;">
    <a href="#"><i class="fa fa-users"></i> <span>Quản lý người dùng</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu" style="display: none;">
        <li><a href="/admin/users">Người dùng</a></li>
    </ul>
</li>
<li class="treeview" style="height: auto;">
    <a href="#"><i class="fa fa-cog"></i> <span>Cấu hình chung</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu" style="display: none;">
        <li><a href="/admin/pages">Page tĩnh</a></li>
    </ul>
</li>
<li><a href="/admin/upload-image"><span class="fa fa-upload"></span>Upload Image</a></li>
@endif

@if(\App\Models\User::isEditor(\Illuminate\Support\Facades\Auth::user()->role))
<li class="treeview" style="height: auto;">
    <a href="#"><i class="fa fa-product-hunt"></i> <span>Quản lý sản phẩm</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu" style="display: none;">
        <li><a href="/admin/product">Sản phẩm</a></li>
        <li><a href="/admin/providers">Nhà cung cấp</a></li>
        <li><a href="/admin/categories">Danh mục</a></li>
    </ul>
</li>
<li class="treeview" style="height: auto;">
    <a href="#"><i class="fa fa-newspaper-o"></i> <span>Quản lý bài viết</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu" style="display: none;">
        <li><a href="/admin/news">Bài viết</a></li>
        <li><a href="/admin/newsCategories">Danh mục bài viết</a></li>
    </ul>
</li>
@endif

@if(\App\Models\User::isStocker(\Illuminate\Support\Facades\Auth::user()->role))
<li class="treeview" style="height: auto;">
    <a href="#"><i class="fa fa-shopping-basket"></i> <span>Trạng thái đơn hàng</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu" style="display: none;">
        <li><a href="/admin/order-stocker">Đơn hàng</a></li>
    </ul>
</li>
@endif

