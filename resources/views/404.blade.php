<?php
use App\Constant;
?>
@extends('layouts.frontend')
@section('content')
<div id="tt-pageContent">
	<div class="tt-offset-0 container-indent">
		<div class="tt-page404">
            <h1 class="tt-title">RẤT TIẾC, TRANG BẠN TÌM KIẾM KHÔNG TỒN TẠI</h1>
            <p>Nếu bạn cần hỗ trợ, vui lòng liên hệ <a href="tel:{{Constant::PHONE_NUMBER}}">
                {{Constant::PHONE_NUMBER_DISPLAY}}</a>
            </p>
			<a href="/" class="btn">VỀ TRANG CHỦ</a>
		</div>
	</div>
</div>
@endsection
