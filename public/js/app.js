function trackPhoneNumber(){var t=$("#mobile").val().trim(),e=$("#fullname").val().trim(),n=$("#firstProductId").val().trim(),a=$("#firstProductName").val().trim();10==t.length&&$.ajax({type:"GET",url:"/tracking-cart",data:{productId:n,productName:a,phone:t,name:e},headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},success:function(t){}})}function changeImage(t){var e=$(t).attr("src");$("#imageProductMobile").removeAttr("src"),$("#imageProductMobile").attr("src",e)}function changeImageDesktop(t){var e=$(t).attr("src");$("#imageProductDesktop").removeAttr("src"),$("#imageProductDesktop").attr("src",e)}function closePopupContact(){$("#popupContactProductDetail").slideUp().hide()}function showPopupContact(){$("#popupContactProductDetail").show().slideDown()}function contactProductDetail(t){var e=$(t).serialize();return $.ajax({type:"POST",url:"/product/contact",data:e,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},success:function(t){var e=jQuery.parseJSON(t);200!=e.status?e.status:alert(e.message),$("#popupContactProductDetail").hide()},error:function(t){}}),!1}function commentProductDetail(t){var e=$(t).serialize();return $.ajax({type:"POST",url:"/product/comment",data:e,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},success:function(t){location.reload()},error:function(t){}}),!1}function addToOrder(t){var e=$(t).serialize();return $.ajax({type:"POST",url:"/dat-hang",data:e,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},success:function(t){window.location.replace("/gio-hang")},error:function(t){}}),!1}function changeQuantity(t){var e=$(t).parent().parent().parent().parent().find(".unitPrice").val(),n=$(t).parent().parent().parent().parent().find(".promotionThreshold").val(),a=$(t).parent().parent().parent().parent().find(".promotionType").val(),o=($(t).parent().parent().parent().parent().find(".isPromotion").val(),$(t).parent().parent().parent().parent().find(".isDiscountItem").val()),r=$(t).parent().parent().parent().parent().find(".promotionValue").val(),c=$(t).val(),i=parseInt(numeral($("#updateTotalDiscount").val()).value()),s=$("#isDiscount").val();2==a&&(document.getElementById("free-gift-line").style.display=n<=c?"contents":"none"),s>0&&(n<=c?0==o&&(i+=parseInt(r),$(t).parent().parent().parent().parent().find(".isDiscountItem").val(1)):1==o&&(i-=parseInt(r),$(t).parent().parent().parent().parent().find(".isDiscountItem").val(0)));var u=e*c,p=0,l=$("#costLimit").val(),d=$("#costShip").val();$(t).parent().parent().parent().parent().find(".subtotal").empty(),$(t).parent().parent().parent().parent().find(".subtotal").html(numeral(u).format("0,0")+"₫"),$(".subtotal").each(function(){var t=$(this).html();p+=parseInt(numeral(t).value())}),parseInt(p)>=parseInt(l)&&(d=0),1==$("#freeShip").val().trim()&&(d=0),$("#showCostShip").html(numeral(d).format("0,0")+"₫"),$(".productAmount").empty(),$(".productAmount").html(numeral(p).format("0,0")+"₫"),p=parseInt(p)+parseInt(d)-parseInt(i),$("#showTotalDiscount").html(numeral(i).format("0,0")),$("#updateTotalDiscount").val(i),$(".totalAmount").empty(),$(".totalAmount").html(numeral(p).format("0,0")+"₫")}function changeImage(t){var e=$(t).attr("src");$("#imageProductMobile").removeAttr("src"),$("#imageProductMobile").attr("src",e)}function changeImageDesktop(t){var e=$(t).attr("src");$("#imageProductDesktop").removeAttr("src"),$("#imageProductDesktop").attr("src",e)}function closePopupContact(){$("#popupContactProductDetail").slideUp().hide()}function showPopupContact(){$("#popupContactProductDetail").show().slideDown()}function contactProductDetail(t){var e=$(t).serialize();return $.ajax({type:"POST",url:"/product/contact",data:e,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},success:function(t){var e=jQuery.parseJSON(t);200!=e.status?e.status:alert(e.message),$("#popupContactProductDetail").hide()},error:function(t){}}),!1}function commentProductDetail(t){var e=$(t).serialize();return $.ajax({type:"POST",url:"/product/comment",data:e,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},success:function(t){location.reload()},error:function(t){}}),!1}function addToOrder(t){var e=$(t).serialize();return $.ajax({type:"POST",url:"/dat-hang",data:e,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},success:function(t){window.location.replace("/gio-hang")},error:function(t){}}),!1}function changeQuantity(t){var e=$(t).parent().parent().parent().parent().find(".unitPrice").val(),n=$(t).parent().parent().parent().parent().find(".promotionThreshold").val(),a=$(t).parent().parent().parent().parent().find(".promotionType").val(),o=($(t).parent().parent().parent().parent().find(".isPromotion").val(),$(t).parent().parent().parent().parent().find(".isDiscountItem").val()),r=$(t).parent().parent().parent().parent().find(".promotionValue").val(),c=$(t).val(),i=parseInt(numeral($("#updateTotalDiscount").val()).value()),s=$("#isDiscount").val();2==a&&(document.getElementById("free-gift-line").style.display=n<=c?"contents":"none"),s>0&&(n<=c?0==o&&(i+=parseInt(r),$(t).parent().parent().parent().parent().find(".isDiscountItem").val(1)):1==o&&(i-=parseInt(r),$(t).parent().parent().parent().parent().find(".isDiscountItem").val(0)));var u=e*c,p=0,l=$("#costLimit").val(),d=$("#costShip").val();$(t).parent().parent().parent().parent().find(".subtotal").empty(),$(t).parent().parent().parent().parent().find(".subtotal").html(numeral(u).format("0,0")+"₫"),$(".subtotal").each(function(){var t=$(this).html();p+=parseInt(numeral(t).value())}),parseInt(p)>=parseInt(l)&&(d=0),1==$("#freeShip").val().trim()&&(d=0),$("#showCostShip").html(numeral(d).format("0,0")+"₫"),$(".productAmount").empty(),$(".productAmount").html(numeral(p).format("0,0")+"₫"),p=parseInt(p)+parseInt(d)-parseInt(i),$("#showTotalDiscount").html(numeral(i).format("0,0")),$("#updateTotalDiscount").val(i),$(".totalAmount").empty(),$(".totalAmount").html(numeral(p).format("0,0")+"₫")}$(".SearchBox_content__2K_mw").on("click",function(t){$(".SearchBox_content__2K_mw").closest("form").submit()}),$(document).ready(function(){var t;$("#popupContactProductDetail").hide(),clearTimeout(t),t=setTimeout(function(){$("#popupContactProductDetail").show().slideDown()},1e4)}),$(document).ready(function(){var t=$(".tt-mobile-product-slider");t.length&&t.slick({dots:!1,arrows:!0,infinite:!0,speed:300,slidesToShow:1,adaptiveHeight:!0,lazyLoad:"progressive"}),jQuery.event.special.touchstart={setup:function(t,e,n){this.addEventListener("touchstart",n,{passive:!0})}},$(".add-item, .buy-now").on("click",function(){$(this).closest(".tt-row-custom-01").find(".tt-input-counter input").val(),$(this).data("product_id")}),$(".tt-product-single-info .detail-content img").each(function(){var t=$(this).attr("alt");$(this).after("<caption>"+t+"</caption>")}),$(".tt-post-single .tt-post-content img").each(function(){var t=$(this).attr("alt");$(this).after("<caption>"+t+"</caption>")}),$(".catalogue li").on("click",function(){var t=$(this).index();console.log(t),$([document.documentElement,document.body]).animate({scrollTop:$(".tt-post-content h2:eq("+t+")").offset().top-80},300)}),$('.product-comment button[type="button"]').on("click",function(){var t=$(this).closest("form");return $.ajax({type:"POST",url:t.attr("action"),data:{product_id:t.find("#product_id").val(),customer_name:t.find("#customer_name").val(),phone_number:t.find("#phone_number").val(),content:t.find("#content").val(),rating:5},headers:{"X-CSRF-TOKEN":t.find("#token").val()},success:function(t){t.success?$("#rating-result").html("<span class='text-success'>"+t.msg+"</span>"):$("#rating-result").html("<span class='text-danger'>"+t.msg+"</span>")}}),!1}),$(this).delay(2500).queue(function(){var t='<script>window.fbAsyncInit=function(){FB.init({xfbml:!0,version:"v7.0"})},function(e,t,n){var c,o=e.getElementsByTagName(t)[0];e.getElementById(n)||((c=e.createElement(t)).id=n,c.src="https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js",o.parentNode.insertBefore(c,o))}(document,"script","facebook-jssdk");<\/script>';t=t.concat('<div class="fb-customerchat" attribution=setup_tool  page_id="332655160834725" logged_in_greeting="Thảo Mộc Uy Tín xin chào. Bạn cần tư vấn, hãy chat với chúng tôi!" logged_out_greeting="Thảo Mộc Uy Tín xin chào. Bạn cần tư vấn, hãy chat với chúng tôi!"></div>'),$("#fb-third-party").html(t),$(this).dequeue()})}),$(document).ready(function(){var t;$("#popupContactProductDetail").hide(),clearTimeout(t),t=setTimeout(function(){$("#popupContactProductDetail").show().slideDown()},1e4)}),$(document).ready(function(){var t=$(".tt-mobile-product-slider");t.length&&t.slick({dots:!1,arrows:!0,infinite:!0,speed:300,slidesToShow:1,adaptiveHeight:!0,lazyLoad:"progressive"}),jQuery.event.special.touchstart={setup:function(t,e,n){this.addEventListener("touchstart",n,{passive:!0})}},$(".add-item, .buy-now").on("click",function(){$(this).closest(".tt-row-custom-01").find(".tt-input-counter input").val(),$(this).data("product_id")}),$(".tt-product-single-info .detail-content img").each(function(){var t=$(this).attr("alt");$(this).after("<caption>"+t+"</caption>")}),$(".tt-post-single .tt-post-content img").each(function(){var t=$(this).attr("alt");$(this).after("<caption>"+t+"</caption>")}),$(".catalogue li").on("click",function(){var t=$(this).index();console.log(t),$([document.documentElement,document.body]).animate({scrollTop:$(".tt-post-content h2:eq("+t+")").offset().top-80},300)}),$('.product-comment button[type="button"]').on("click",function(){var t=$(this).closest("form");return $.ajax({type:"POST",url:t.attr("action"),data:{product_id:t.find("#product_id").val(),customer_name:t.find("#customer_name").val(),phone_number:t.find("#phone_number").val(),content:t.find("#content").val(),rating:5},headers:{"X-CSRF-TOKEN":t.find("#token").val()},success:function(t){t.success?$("#rating-result").html("<span class='text-success'>"+t.msg+"</span>"):$("#rating-result").html("<span class='text-danger'>"+t.msg+"</span>")}}),!1}),$(this).delay(2500).queue(function(){var t='<script>window.fbAsyncInit=function(){FB.init({xfbml:!0,version:"v7.0"})},function(e,t,n){var c,o=e.getElementsByTagName(t)[0];e.getElementById(n)||((c=e.createElement(t)).id=n,c.src="https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js",o.parentNode.insertBefore(c,o))}(document,"script","facebook-jssdk");<\/script>';t=t.concat('<div class="fb-customerchat" attribution=setup_tool  page_id="690380381071920" logged_in_greeting="Thảo Mộc Uy Tín xin chào. Bạn cần tư vấn, hãy chat với chúng tôi!" logged_out_greeting="Thảo Mộc Uy Tín xin chào. Bạn cần tư vấn, hãy chat với chúng tôi!"></div>'),$("#fb-third-party").html(t),$(this).dequeue()})});