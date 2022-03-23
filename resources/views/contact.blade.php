<?php 
use App\Constant;
?>
@extends('layouts.frontend')
@section('content')
<style>
	h1{
		text-align: center;
		padding-top: 40px;
	}
</style>
<div id="tt-pageContent">
	<div class="container-indent">
		<div class="container container-fluid-custom-mobile-padding">
			<div class="tt-contact02-col-list">
				<h1>Liên hệ với chúng tôi nếu bạn có bất kỳ thắc mắc nào</h1>
				<div class="row">
					<div class="col-sm-12 col-md-4 ml-sm-auto mr-sm-auto">
						<div class="tt-contact-info">
							<i class="tt-icon icon-f-93"></i>
							<h6 class="tt-title">GỌI ĐIỆN CHO CHÚNG TÔI</h6>
							<address>
								<a href="tel:{{Constant::PHONE_NUMBER}}">{{Constant::PHONE_NUMBER_DISPLAY}}</a>
							</address>
						</div>
					</div>
					<div class="col-sm-6 col-md-4">
						<div class="tt-contact-info">
							<i class="tt-icon icon-f-24"></i>
							<h6 class="tt-title">ĐỊA CHỈ</h6>
							<address>
								{{Constant::ADDRESS}}
							</address>
						</div>
					</div>
					<div class="col-sm-6 col-md-4">
						<div class="tt-contact-info">
							<i class="tt-icon icon-f-92"></i>
							<h6 class="tt-title">THỜI GIAN LÀM VIỆC</h6>
							<address>
								24/24h (T2 - CN)
							</address>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-indent">
		<div class="container container-fluid-custom-mobile-padding">
			<form id="contactform" class="contact-form form-default" method="post" action="/lien-he">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<input type="text" name="name" class="form-control" placeholder="Tên của bạn (*)" required>
						</div>
						<div class="form-group">
							<input type="text" name="phone_number" class="form-control" placeholder="Số điện thoại (*)" required>
						</div>
						<div class="form-group">
							<input type="text" name="email" class="form-control" placeholder="Email">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<textarea name="message" class="form-control" rows="7" placeholder="Nội dung" required></textarea>
						</div>
					</div>
				</div>
				<div class="text-center">
					<button type="submit" class="btn send-request">GỬI YÊU CẦU</button>
				</div>
				
				<div class="row justify-content-center">
					<div class="col-6">
						@foreach (['danger', 'warning', 'success', 'info'] as $msg)
						@if(Session::has($msg))
							<p class="alert alert-{{ $msg }}">{{ Session::get($msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
							@endif
						@endforeach
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection
