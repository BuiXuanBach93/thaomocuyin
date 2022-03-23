<?php
use App\Constant;
?>
@extends('layouts.frontend')
@section('content')
<div class="tt-breadcrumb">
    <div class="container">
        <ul>
            <li><a href="/">Trang chủ</a></li>
            <li>
                <span>
                    {{$page['title']}}
                </span>
            </li>
        </ul>
    </div>
</div>
<div id="tt-pageContent">
	<div class="container-indent">
		<div class="container container-fluid-custom-mobile-padding">
			<h1 class="tt-title-subpages">{{$page['title']}}</h1>
			<div class="content">
				<?php echo $page['content']?>
			</div>
		</div>
	</div>
</div>
@endsection