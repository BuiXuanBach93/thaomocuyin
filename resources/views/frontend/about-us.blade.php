<?php
use App\Constant;
?>
@extends('layouts.frontend')
@section('content')
<style>
	/* .tt-about-box */
@media (min-width: 791px) {
  .tt-about-box {
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    -webkit-flex-direction: row;
    -ms-flex-direction: row;
    flex-direction: row;
    -webkit-flex-wrap: nowrap;
    -ms-flex-wrap: nowrap;
    flex-wrap: nowrap;
    -webkit-justify-content: flex-start;
    -ms-flex-pack: start;
    justify-content: flex-start;
    -webkit-align-content: stretch;
    -ms-flex-line-pack: stretch;
    align-content: stretch;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    color: #000;
    padding: 50px 0 50px 0;
    background-position: center center;
    background-repeat: no-repeat;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover; }
    .tt-about-box .img-mobile {
      display: none; }
    .tt-about-box .tt-title {
      color: #000;
      font-size: 34px;
      line-height: 44px;
      letter-spacing: 0.02em;
      font-weight: 500;
      padding-bottom: 0; }
    .tt-about-box p {
      margin-top: 23px;
      max-width: 75%; }
    .tt-about-box .tt-blockquote-02 {
      color: #000000; }
      .tt-about-box .tt-blockquote-02 .tt-icon {
        color: #000000; }
      .tt-about-box .tt-blockquote-02 .tt-title {
        font-size: 20px;
    	line-height: 32px;
        font-weight: 500;
        letter-spacing: 0.02em;
        color: #000000; } }
  @media (min-width: 791px) and (max-width: 1229px) {
    .tt-about-box {
      padding: 110px 0 118px 0; }
      .tt-about-box .tt-title {
        font-size: 30px;
        line-height: 40px;
        letter-spacing: 0.02em; }
      .tt-about-box p {
        max-width: 100%; }
      .tt-about-box .tt-blockquote-02 .tt-title {
        font-size: 22px;
        line-height: 27px; } }

@media (max-width: 790px) {
  .tt-about-box {
    background: none !important; }
    .tt-about-box > .container {
      padding-left: 20px;
      padding-right: 20px; }
    .tt-about-box .img-mobile {
      display: block;
      width: 100%;
      height: auto;
      margin-bottom: 32px; }
    .tt-about-box .tt-title {
      font-size: 24px;
      line-height: 34px;
      margin-top: 32px;
      letter-spacing: 0.02em;
      padding-bottom: 4px; }
    .tt-about-box .tt-blockquote-02 {
      margin-top: 25px;
      color: #191919; }
      .tt-about-box .tt-blockquote-02 .tt-icon {
        color: #288ad6; }
      .tt-about-box .tt-blockquote-02 .tt-title {
        margin-top: 0px;
        padding-bottom: 0;
        font-size: 23px; } }

.tt-about-box div[class^="col-"] > *:nth-child(1) {
  margin-top: 0; }

@media (min-width: 576px) {
  html.tt-boxed .tt-about-box .container {
    padding-right: 40px;
    padding-left: 40px; } }

/* 
	.tt-about-box {
		background-color: #f7f8fa;
		color: #000;
	} */

</style>
<div class="tt-breadcrumb">
    <div class="container">
        <ul>
            <li><a href="/">Trang chủ</a></li>
            <li>
                <span>
                    Về chúng tôi
                </span>
            </li>
        </ul>
    </div>
</div>
<div id="tt-pageContent">
	<div class="nomargin container-indent">
		<div class="tt-about-box" style="background-image: url({{ asset('/images/about-us.jpg') }});">
			<div class="container">
				<div class="row">
					<div class="col-md-7">
						<h1 class="tt-title">ĐÔI NÉT VỀ Thảo Mộc Uy Tín</h1>

						<p><span><span><span>Nh&agrave; thuốc Thanh B&igrave;nh l&agrave; nh&agrave; thuốc trực tuyến uy t&iacute;n h&agrave;ng đầu, nh&agrave; thuốc được th&agrave;nh lập nhằm phục vụ c&aacute;c nhu cầu về y tế với phương ch&acirc;m chăm s&oacute;c sức khỏe cho cộng đồng tốt nhất k&egrave;m mức gi&aacute; th&agrave;nh hợp l&iacute; nhất. Hiện tại chuỗi nh&agrave; thuốc Thanh B&igrave;nh đ&atilde; v&agrave; đang l&agrave; hệ thống nh&agrave; thuốc online uy t&iacute;n chuy&ecirc;n cung cấp sỉ v&agrave; lẻ c&aacute;c mặt h&agrave;ng dược phẩm ch&iacute;nh h&atilde;ng tại H&agrave; Nội, Th&agrave;nh phố Hồ Ch&iacute; Minh, cũng như c&aacute;c v&ugrave;ng miền kh&aacute;c tr&ecirc;n to&agrave;n quốc với mức gi&aacute; th&agrave;nh cạnh tranh cao.</span></span></span></p>

<p></p>
<h2>TẦM NHÌN & SỨ MỆNH</h2>

<p><strong>Nh&agrave; thuốc Thanh B&igrave;nh</strong> đang v&agrave; sẽ hướng đến mục ti&ecirc;u x&acirc;y dựng chuỗi hệ thống nh&agrave; thuốc trực tuyến hiện đại bậc nhất với quy m&ocirc; lớn v&agrave; phục vụ tất cả c&aacute;c nhu cầu của mọi kh&aacute;ch h&agrave;ng tr&ecirc;n mọi miền tổ quốc.</p>

<p>Nh&agrave; thuốc cung cấp h&agrave;ng ng&agrave;n sản phẩm ch&iacute;nh h&atilde;ng với mức gi&aacute; th&agrave;nh ưu đ&atilde;i, đảm bảo những lợi &iacute;ch tuyệt đối tới kh&aacute;ch h&agrave;ng khi mua sắm trực tuyến tại nh&agrave; thuốc, c&aacute;c mặt h&agrave;ng dược phẩm đa dạng v&agrave; thiết yếu tại nh&agrave; thuốc gồm:</p>

<ul>
  <li style="list-style-type:disc"><em>C&aacute;c loại thuốc k&ecirc; đơn v&agrave; kh&ocirc;ng k&ecirc; đơn</em></li>
  <li style="list-style-type:disc"><em>C&aacute;c loại thực phẩm chức năng đa dạng</em></li>
  <li style="list-style-type:disc"><em>C&aacute;c loại dụng cụ, thiết bị y tế</em></li>
  <li style="list-style-type:disc"><em>Mỹ&nbsp;phẩm, h&oacute;a mỹ phẩm</em></li>
</ul>

<p>Hệ thống nh&agrave; thuốc Thanh B&igrave;nh hợp t&aacute;c ph&acirc;n phối trực tuyến với đối t&aacute;c c&aacute;c l&agrave; c&ocirc;ng ty dược phẩm h&agrave;ng đầu trong nước như Học Viện Qu&acirc;n Y, Dược phẩm Trung Ương 3, Dược phẩm H&agrave; T&acirc;y, dược phẩm Hậu Giang, dược phẩm Traphaco. B&ecirc;n cạnh đ&oacute; ch&uacute;ng t&ocirc;i kh&ocirc;ng ngừng t&igrave;m kiếm cơ hội hợp t&aacute;c với c&aacute;c tập đo&agrave;n, c&aacute;c c&ocirc;ng ty dược phẩm lớn ở c&aacute;c nước kh&aacute;c như : Mỹ, &Yacute;, Ba Lan, Ph&aacute;p&hellip; Sản phẩm được nhập khẩu nguy&ecirc;n hộp với đầy đủ giấy tờ theo ti&ecirc;u chuẩn của bộ y tế.</p>

<p>Với phương ch&acirc;m <em><strong>&ldquo;lấy chữ t&iacute;n để tạo n&ecirc;n chữ tin trong l&ograve;ng kh&aacute;ch h&agrave;ng&rdquo;</strong></em>, sản phẩm tại nh&agrave; thuốc đều l&agrave; sản phẩm ch&iacute;nh h&atilde;ng, được Bộ Y Tế cấp ph&eacute;p lưu h&agrave;nh v&agrave; hiệu quả thưc tế mang lại được đ&aacute;nh gi&aacute; cao từ người từ người ti&ecirc;u d&ugrave;ng. Đến với nh&agrave; thuốc Thanh B&igrave;nh kh&aacute;ch h&agrave;ng ho&agrave;n to&agrave;n c&oacute; thể an t&acirc;m về chất lượng của tất cả c&aacute;c loại mặt h&agrave;ng.</p>

						<p>&nbsp;</p>
						

						<blockquote class="tt-blockquote-02">
							<i class="tt-icon icon-g-56"></i>
							<div class="tt-title">Lấy chữ tín để tạo nên chữ tin trong lòng khách hàng</div>
							<div class="tt-title-description">thaomocuytin.com</div>
						</blockquote>
					</div>
				</div>
			</div>
		</div>  
	</div>
<div class="container-indent">
<div class="container">    
<div class="tt-about-col-list"><div class="row col-md-12">
  <img alt="Thảo Mộc Uy Tín" style="width: 100%" src="{{ asset('/images/nha-thuoc-thanh-binh.jpg') }}">
</div></div>
</div>
</div>

	<div class="container-indent">
		<div class="container">
			<div class="tt-about-col-list">
				<div class="row">
					<div class="col-md-6">
						<h5 class="tt-title" style="color: #1b74e7">ĐỘI NGŨ NHÀ THUỐC</h5>
						<div class="width-90">
                            Tại Thảo Mộc Uy Tín đội ngũ nhân viên đóng vai trò quyết định trong thành công và sự phát triển của nhà thuốc, họ là những bác sĩ, dược sĩ có chuyên môn cao, được đào tạo bài bản cũng như đã có nhiều năm hoạt động trong ngành y tế với những kinh nghiệm vô cùng quý báu, bên cạnh đó là đội ngũ nhân viên, tư vấn có tinh thần, trách nhiệm cao. 
                            </br>
                            </br>Tại đây chúng tôi cung cấp không chỉ là những sản phẩm chính hãng, giá thành tốt nhất mà còn là những dịch vụ tiện ích nhất, tư vấn sức khỏe miễn phí tận tâm nhất, đảm bảo mang đến sự hài lòng tuyệt đối cho mỗi khách hàng khi đến với nhà thuốc.

                            <p><span><span><span>Hệ thống Nh&agrave; thuốc Thanh B&igrave;nh chuyển sang h&igrave;nh thức trực tuyến từ th&aacute;ng 3/2021 với phụ tr&aacute;ch chuy&ecirc;n m&ocirc;n l&agrave; <a href="https://thaomocuytin.com/nguyen-thi-binh"> <strong> dược sĩ Nguyễn Thị B&igrave;nh</strong> </a></span></span></span></p>
                            <p></p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="tt-box-info">
							<img alt="Dược sĩ Nguyễn Thị Bình" style="width: 100%" src="{{ asset('/images/duoc-si-nguyen-thi-binh.jpg') }}">
						</div>
          </div>
          <div class="col-md-6">
            <h5 class="tt-title" style="color: #1b74e7">DỊCH VỤ & HỖ TRỢ</h5>

                    <p>
                      Đối với Thảo Mộc Uy Tín dịch vụ chăm sóc khách hàng luôn là yếu tố quan trọng để mang đến sự hài lòng cho mỗi người dân khi đến với chúng tôi.
Nhà thuốc xây dựng website <strong>thaomocuytin.com</strong> đảm bảo đầy đủ các nhu cầu thiết yếu về dược phẩm cũng như vô số các sản phẩm nội ngoại nhập để khách hàng có thể dễ dàng tham khảo.
</br>
</br>
Đội ngũ dược sĩ tư vấn chuyên môn cao tại nhà thuốc luôn có mặt 24/7 để tư vấn, hỗ trợ và giải đáp mọi thắc mắc của khách hàng.
Khi đến với Thảo Mộc Uy Tín, lợi ích của khách hàng luôn được đặt lên hàng đầu với những chính sách hậu mãi sâu cũng như cam kết mức giá thành thấp nhất trên thị trường đến tay khách hàng.
Chính sách mua hàng nhanh chóng, tiện lợi, giao hàng miễn phí tận nơi nhanh nhất và chính sách đổi trả hàng linh hoạt trong vòng 30 ngày.

                    </p>
          </div>
    <div class="col-md-6">
              <img alt="Thảo Mộc Uy Tín" style="width: 100%" src="{{ asset('/images/nha-thuoc-thanh-binh-2.jpg') }}">
            </div>
          <div class="col-md-12">
						<h5 class="tt-title" style="color: #1b74e7">SỨ MỆNH CỦA CHÚNG TÔI</h5>
						<p>
              Sứ mệnh của chúng tôi là chăm sóc sức khỏe khách hàng mọi lúc, mọi nơi thông qua việc cung cấp dịch vụ tư vấn sức khỏe miễn phí và phân phối các sản phẩm dược phẩm chính hãng, hiệu quả, phù hợp bên cạnh đó là giá thành tốt nhất.
Nhà thuốc luôn luôn lắng nghe và thấu hiểu những băn khoăn, nhu cầu của khách hàng khi đến với chúng tôi để nhà thuốc không chỉ là địa chỉ mua hàng uy tín, chất lượng mà còn là người bạn đồng hành tin cậy cho sức khỏe của bạn.

            </p>

					</div>
          <div class="col-md-6">
            <h5 class="tt-title" style="color: #1b74e7">LIÊN HỆ</h5>
            <div class="tt-box-info">
              <p>
                <span class="tt-base-dark-color">Văn Phòng: </span> {{Constant::OFFICE_ADDRESS}}<br>
              </p>
              <p>
                <span class="tt-base-dark-color">Phone: </span> <a href="tel:{{Constant::PHONE_NUMBER}}">{{Constant::PHONE_NUMBER_DISPLAY}}</a>
              </p>
              <p>
                <span class="tt-base-dark-color">Giờ làm việc: </span> 24/24h (T2 - CN)
              </p>
              <p>
                <span class="tt-base-dark-color">E-mail: </span> <a class="link" href="mailto:{{Constant::EMAIL}}">{{Constant::EMAIL}}</a>
              </p>
            </div>
          </div>
					<div class="col-md-6">
						<h5 class="tt-title" style="color: #1b74e7">LIÊN KẾT MẠNG XÃ HỘI</h5>
						<div class="tt-box-info">
							<p>
								<span class="tt-base-dark-color"><strong>Facebook: </strong> </span> <a href="{{Constant::LINK_FACEBOOK}}" rel="nofollow noopener">{{Constant::LINK_FACEBOOK}}</a><br>
							</p>
							<p>
								<span class="tt-base-dark-color"><strong>Twitter: </strong></span> <a href="{{Constant::LINK_TWITTER}}" rel="nofollow noopener">{{Constant::LINK_TWITTER}}</a><br>
							</p>
							<p>
								<span class="tt-base-dark-color"><strong>Instagram: </strong></span> <a href="{{Constant::LINK_INSTAGRAM}}" rel="nofollow noopener">{{Constant::LINK_INSTAGRAM}}</a><br>
							</p>
							<p>
								<span class="tt-base-dark-color"><strong>Linkedin: </strong></span> <a href="{{Constant::LINK_LINKEDIN}}" rel="nofollow noopener">{{Constant::LINK_LINKEDIN}}</a><br>
              </p>
              <p>
								<span class="tt-base-dark-color"><strong>Tumbr: </strong></span> <a href="{{Constant::LINK_TUMB}}" rel="nofollow noopener">{{Constant::LINK_TUMB}}</a><br>
              </p>
              <p>
								<span class="tt-base-dark-color"><strong>Pinterest:</strong> </span> <a href="{{Constant::LINK_PINTEREST}}" rel="nofollow noopener">{{Constant::LINK_PINTEREST}}</a><br>
							</p>
              <p>
                <span class="tt-base-dark-color"><strong>Google Business:</strong> </span> <a href="{{Constant::LINK_GB}}" rel="nofollow noopener">{{Constant::LINK_GB}}</a><br>
              </p>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection