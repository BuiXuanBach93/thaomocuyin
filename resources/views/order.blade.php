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

</style>

<div id="tt-pageContent">
    <div class="container-indent">
        <div class="container">
            <h1 class="tt-title-subpages noborder">GIỎ HÀNG CỦA BẠN</h1>
                <form action="{{ route('checkout') }}" class="formCheckOut validate" method="post" id="orderForm">
                    {{ csrf_field() }}
            <div class="row">
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
                                        @if ($item->promotion_threshold > $item->quantity)
                                            <input type="hidden" class="isDiscountItem" value="0">
                                        @else
                                             <input type="hidden" class="isDiscountItem" value="1">
                                        @endif
                                        <input type="hidden" class="promotionValue" value="{{ $item->promotion_discount }}">
                                        <div class="detach-quantity">
                                            <div class="tt-input-counter style-01">
                                                <span class="minus-btn"></span>
                                                <input type="text" name="quantity[]" value="{{$item['quantity']}}" size="100" onchange="return changeQuantity(this);">
                                                <span class="plus-btn"></span>
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
                                    <td>
                                        <a href="/delete-cart?product_id={{ $item->id }}" class="tt-btn-close"></a>
                                    </td>
                                </tr>
                                @else
                                     <tr id="free-gift-line" @php if($showPromotion == 1): @endphp style="display :content;" @php endif; @endphp
                                            @php if($showPromotion == 0): @endphp style="display: none;" @php endif; @endphp    
                                         >
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
                                <input type="hidden" name="firstProductId" id="firstProductId" value="{{$orderItems[0]->id}}">
                                <input type="hidden" name="firstProductName" id="firstProductName" value="{{$orderItems[0]->short_name}}">
                                <tr>
                                <td class="continue" colspan="3" rowspan="" headers="" style="text-align: left;">
                                    TỔNG TIỀN SẢN PHẨM
                                </td>
                                <td  class="totals" colspan="2" rowspan="" headers="">
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
                                        <input type="hidden" value="{{ $discount }}" id="isDiscount"/>
                                        <input type="hidden" value="{{ $totalDiscount }}" name="input_discount" id="updateTotalDiscount"/>
                                    </div>
                                </td>
                                </tr>
                                <tr>
                                <td class="continue" colspan="3" rowspan="" headers="" style="text-align: left;">
                                    PHÍ VẬN CHUYỂN
                                </td>
                                <td  class="totals" colspan="2" rowspan="" headers="">
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
                                <td  class="totals" colspan="2" rowspan="" headers="">
                                    <div class="tt-price">
                                        <span class="new-price totalAmount">
                                            {{formatPrice($totalPrice + $shippingFee - $totalDiscount )}}₫
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
                <div class="col-sm-12 col-xl-6">
                    <div class="tt-shopcart-wrapper">
                        <div class="tt-shopcart-box">
                            <h4 class="tt-title">
                                THÔNG TIN NHẬN HÀNG
                            </h4>
                            <p>Điền chính xác thông tin để nhận hàng nhanh chóng</p>
                            
                                
                                <div class="form-group row">
                                    <div class="col-6">
                                        <input type="text" id="fullname" placeholder="Họ và tên" name="name" class="form-control" required>
                                    </div>
                                    <div class="col-6">
                                        <input id="mobile" type="text" placeholder="Số điện thoại" name="phone_number" onfocusout="trackPhoneNumber()" class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                     <textarea required class="form-control" name="address" rows="2" placeholder="Địa chỉ"></textarea>
                                </div>

                                <div class="form-group">
                                    <textarea class="form-control" name="customer_note" rows="3" placeholder="Yêu cầu khác (không bắt buộc)"></textarea>
                                </div>
                                <div class="tt-shopcart-box tt-boredr-large">
                                    <button type="submit" class="btn btn-lg order-submit"><span class="icon icon-check_circle"></span>ĐẶT HÀNG</button>
                                </div>
                            
                        </div>                      
                    </div>
                </div>
                <input type="hidden" value="{{ $freeShipThreshold }}" id="costLimit"/>
                <input type="hidden" value="{{ $shippingFeeDefault }}" id="costShip"/>
                <input type="hidden" id="freeShip" value="{{ $freeShip }}">
            </div>
                </form>
        </div>
    </div>
</div>
@endsection
