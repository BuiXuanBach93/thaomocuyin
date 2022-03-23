@extends('layouts.frontend_noindex')
@section('content')

<style type="text/css">
	
.tt-price .old-price, .tt-product-single-info .tt-price .old-price .money {
    color: #3553A0;
    text-decoration: line-through;
}

.tt-price .old-price {
    position: relative;
    color: #676464;
}
.tt-price span {
    display: inline-block;
}

.tt-price .new-price {
    color: #FF0000;
}

.tt-price span {
    display: inline-block;
}

.tt-title-subpages {
    font-size: 30px;
    line-height: 40px;
    font-family: Arial, Helvetica, sans-serif;
    font-weight: 500;
    color: #288ad6;
}

.title-total-amount {
    color: #288ad6;
}
.message-thanks {
    padding: 5px 10px;
}

</style>

<div id="tt-pageContent">
	<div class="container-indent">
		<div class="container">
			<h1 class="tt-title-subpages noborder">ĐẶT HÀNG THÀNH CÔNG</h1>
			<div class="row">
				<div class="col-12 message-thanks pdright10">
                                <p class="lastText">Cảm ơn quý khách đã đặt hàng. Trong vòng 5 phút, nhân viên nhà thuốc sẽ gọi điện xác nhận đơn hàng của quý khách.</p>
                            </div>
                <div class="col-sm-12 col-xl-6">
					<div class="tt-shopcart-wrapper">
						<div class="tt-shopcart-box">
							<h4 class="tt-title">
								THÔNG TIN NHẬN HÀNG
							</h4>
							<div class="col-12 col-md-12 pdleft10 customer-info">
                                <div class="row">
                                    <div class="col-4 col-xs-6 col-sm-4 col-md-4 col-lg-4 info-item-lable">
                                        <p>Mã đơn:</p>
                                    </div>
                                    <div class="col-8 col-xs-6 col-sm-8 col-md-8 col-lg-8">
                                         <p class="font-weight-bold text-uppercase">NTTB-DH-{{ $orderId }}-
                                            <?php echo date("Ymd")?>
                                         </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 pdleft10 customer-info">
                                <div class="row">
                                    <div class="col-4 col-xs-6 col-sm-4 col-md-4 col-lg-4 info-item-lable">
                                        <p>Họ tên:</p>
                                    </div>
                                    <div class="col-8 col-xs-6 col-sm-8 col-md-8 col-lg-8">
                                         <p>{{ $customer['ship_name'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 pdleft10 customer-info">
                                <div class="row">
                                    <div class="col-4 col-xs-6 col-sm-4 col-md-4 col-lg-4 info-item-lable">
                                        <p>Điện thoại:</p>
                                    </div>
                                    <div class="col-8 col-xs-6 col-sm-8 col-md-8 col-lg-8">
                                         <p>{{ $customer['ship_phone'] }}</p>
                                    </div>
                                </div>
                            </div>                                               
                            <div class="col-12 col-md-12 pdleft10 customer-info">
                                <div class="row">
                                    <div class="col-4 col-xs-6 col-sm-4 col-md-4 col-lg-4 info-item-lable">
                                        <p>Địa chỉ:</p>
                                    </div>
                                    <div class="col-8 col-xs-6 col-sm-8 col-md-8 col-lg-8">
                                         <p>{{ $customer['ship_address'] }}</p>
                                    </div>
                                </div>
                             </div>
                             <div class="col-12 col-md-12 pdleft10 customer-info">
                                <div class="row">
                                    <div class="col-4 col-xs-6 col-sm-4 col-md-4 col-lg-4 info-item-lable">
                                        <p>Ghi chú:</p>
                                    </div>
                                    <div class="col-8 col-xs-6 col-sm-8 col-md-8 col-lg-8">
                                         <p>{{ $customer['customer_note'] }}</p>
                                    </div>
                                </div>    
                            </div>      
						</div>						
					</div>
				</div>
				<input type="hidden" value="{{ $freeShipThreshold }}" id="costLimit"/>
				<input type="hidden" value="{{ $shippingFeeDefault }}" id="costShip"/>
				<input type="hidden" id="freeShip" value="{{ $freeShip }}">
				<div class="col-sm-12 col-xl-6">
					<div class="tt-shopcart-table">
						<table>
							<tbody>
								<?php $totalPrice = 0;?>
                                @foreach ($orderItems as $item)
                                @if($item['is_free_gift'] == 0)
                                <tr>
									<td>
										<div class="tt-product-img">
											<img src="/images/loader.svg" data-src="{{genImage($item['thumbnail'])}}" alt="{{$item['title']}}">
										</div>
									</td>
									<td>
										<h2 class="tt-title">
											<a href="{{$item['category_slug']}}/{{$item['slug']}}">{{$item['short_name']}}</a>
											<div class="tt-price">
												@if($item['discount_type'] == 1)
                              						<span class="old-price">{{formatPrice($item['price']+$item['discount'])}}₫</span>
                              					@endif	
												<span class="new-price">
													{{formatPrice($item['price'])}}₫
												</span>

											</div>
										</h2>
									</td>
									<td>
										<input type="hidden" class="unitPrice" value="{{ $item->price }}">
										<input type="hidden" name="product_id[]" value="{{ $item->id }}"/>
										<input type="hidden" class="promotionThreshold" value="{{ $item->promotion_threshold }}">
                                            <input type="hidden" class="promotionType" value="{{ $item->promotionType }}">
										<div class="detach-quantity">
											<div class="tt-input-counter style-01">
												<input disabled type="text" name="quantity[]" value="{{$item['quantity']}}" size="100">
											</div>
										</div>
									</td>
									<td>
										<div class="tt-price subtotal">
											<?php
											$price = $item['price']*$item['quantity'];
											$totalPrice +=$price;
											?>
											{{formatPrice($price)}}₫
										</div>
									</td>
								</tr>
                                @else
                                     <tr>
                                    <td>
                                        <div class="tt-product-img">
                                            <img src="/images/loader.svg" data-src="{{genImage($item['thumbnail'])}}" alt="{{$item['title']}}">
                                        </div>
                                    </td>
                                        <td>
                                            <div class="content">
                                                <a>{{$item['short_name']}}</a>
                                                <p class="price">
                                                  <span style="color:red;">Quà tặng</span>
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="detach-quantity">
                                            <div class="tt-input-counter style-01">
                                                <input disabled type="text" name="quantity[]" value="1" size="100">
                                            </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span style="color:red;">Miễn phí</span>
                                        </td>
                                        <td class="imgpr">
                                            
                                        </td>
                                    </tr>
                                    
                                    @endif        
                                @endforeach
								<tr>
                                <td class="continue" colspan="3" rowspan="" headers="" style="text-align: left;">
                                    TỔNG TIỀN SẢN PHẨM
                                </td>
                                <td  class="totals" colspan="1" rowspan="" headers="">
                                    <div class="tt-price">
                                        <span class="new-price productAmount">
										  {{formatPrice($totalPrice)}}₫
                                        </span>
									</div>
                                </td>
								</tr>
                                <tr>
                                <td class="continue" colspan="3" rowspan="" headers="" style="text-align: left;">
                                    CHIẾT KHẤU ĐƠN
                                </td>
                                <td  class="totals" colspan="2" rowspan="" headers="">
                                    <div>
                                        <span class="new-price" id="showTotalDiscount">{{formatPrice($totalDiscount)}}₫</span>
                                    </div>
                                </td>
                                </tr>
								<tr>
                                <td class="continue" colspan="3" rowspan="" headers="" style="text-align: left;">
                                    PHÍ VẬN CHUYỂN
                                </td>
                                <td  class="totals" colspan="1" rowspan="" headers="">
                                    <div>
                                        <span class="new-price" id="showCostShip">{{formatPrice($shippingFee)}}₫</span>
									</div>
                                </td>
                            </tr>
								<tr>
                                <td class="continue" colspan="3" rowspan="" headers="" style="text-align: left;">
                                    <div class="title-total-amount">
                                    	TỔNG TIỀN THANH TOÁN
                                    </div>
                                </td>
                                <td  class="totals" colspan="1" rowspan="" headers="">
	                            	<div class="tt-price">
										<span class="new-price totalAmount">
											{{formatPrice($totalPrice + $shippingFee - $totalDiscount)}}₫
										</span>
									</div>
                                </td>
                            </tr>

							</tbody>
						</table>
						<div class="tt-shopcart-btn">
							<div class="col-left">
								<a class="btn-link" href="/"><i class="icon-e-19"></i>MUA THÊM SẢN PHẨM KHÁC</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
