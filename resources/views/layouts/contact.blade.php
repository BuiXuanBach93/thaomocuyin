<style>
    .fbmsg-mobile {
        display: none;
    }

    .call_me {
        display: none;
        position: fixed;
        bottom: 10px;
        right: 15px;
        z-index: 999;
        color: #fff;
        font-size: 15px;
        font-weight: 700;
        background: red;
        padding-right: 15px;
        border-radius: 20px;
    }

    .call_shop {
        display: none;
        position: fixed;
        bottom: 10px;
        left: 15px;
        z-index: 999;
        color: #fff;
        font-size: 15px;
        font-weight: 700;
        background: #1b74e7;
        padding-right: 15px;
        border-radius: 20px;
    }

    .call_me img {
        width: 40px;
    }

    .call_shop img {
        width: 40px;
    }

    #icon_phone{
        animation: 5s ease-in-out 0s normal none infinite running suntory-alo-circle-img-anim;
    }

    @media screen and (max-width: 768px){
        #fb-root {
            display: none;
        }
        .ctrlq.fb-button, .ctrlq.fb-close {
            position: fixed;
            right: 24px;
            cursor: pointer;
        }
        .ctrlq.fb-button {
            z-index: 999;
            background: url(/images/icon_fb.png) center no-repeat #ffffffd6;
            width: 60px;
            height: 60px;
            text-align: center;
            bottom: 60px;
            border: 0;
            outline: 0;
            border-radius: 60px;
            -webkit-border-radius: 60px;
            -moz-border-radius: 60px;
            -ms-border-radius: 60px;
            -o-border-radius: 60px;
            box-shadow: 0 1px 6px rgb(0 0 0 / 6%), 0 2px 32px rgb(0 0 0 / 16%);
            -webkit-transition: box-shadow .2s ease;
            background-size: 80%;
            transition: all .2s ease-in-out;
        }
        .fbmsg-mobile {
            display: block;
        }
        .bubble {
            width: 20px;
            height: 20px;
            background: #c00;
            color: #fff;
            position: absolute;
            z-index: 999999999;
            text-align: center;
            vertical-align: middle;
            top: -2px;
            left: -5px;
            border-radius: 50%;
        }
        .bubble-msg {
            width: 90px;
            left: -100px;
            top: 5px;
            position: relative;
            background: rgba(59,89,152,.65);
            color: #fff;
            padding: 5px 8px;
            border-radius: 8px;
            text-align: center;
            font-size: 13px;
        }

        .ctrlq.zalo-button {
            z-index: 999;
            background: url(/images/zalo.png) center no-repeat #ffffffd6;
            width: 60px;
            height: 60px;
            text-align: center;
            bottom: 60px;
            border: 0;
            outline: 0;
            border-radius: 60px;
            -webkit-border-radius: 60px;
            -moz-border-radius: 60px;
            -ms-border-radius: 60px;
            -o-border-radius: 60px;
            box-shadow: 0 1px 6px rgb(0 0 0 / 6%), 0 2px 32px rgb(0 0 0 / 16%);
            -webkit-transition: box-shadow .2s ease;
            background-size: 80%;
            transition: all .2s ease-in-out;
        }

        .ctrlq.zalo-button, .ctrlq.zalo-close {
            position: fixed;
            left: 24px;
            cursor: pointer;
        }

        .bubble-zalo {
            width: 20px;
            height: 20px;
            background: #c00;
            color: #fff;
            position: absolute;
            z-index: 999999999;
            text-align: center;
            vertical-align: middle;
            top: -2px;
            right: -5px;
            border-radius: 50%;
        }

        .call_me {
            display: block;
        }
        .call_shop {
            display: block;
        }
    }

</style>
<div class="footer-contact">
    <a href="tel:0355258365" class="call_me">
      <img id="icon_phone" style="animation: 5s ease-in-out 0s normal none infinite running suntory-alo-circle-img-anim;" alt="phone" src="/images/call_shop.png">0355.258.365</a>
</div>

<div class="call_shop" onclick="showPopupContact();">
      <img src="/images/icon_call_shop.png" alt="shop call icon" style="animation: 5s ease-in-out 0s normal none infinite running suntory-alo-circle-img-anim;">
     Tư vấn cho tôi
 </div>

<a href="https://m.me/thaomocuytin.com" target="_blank" title="Gửi tin nhắn cho chúng tôi qua Facebook" class="ctrlq fb-button fbmsg-mobile">
    <div class="bubble">1</div></a></a>

    <a href="https://zalo.me/0355258365" target="_blank" title="Gửi tin nhắn cho chúng tôi qua Zalo" class="ctrlq zalo-button fbmsg-mobile"><div class="bubble-zalo">1</div></a> </a>