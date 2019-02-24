<?php
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>


    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="login_tr_and_stu.css">

</head>
<!--CSS寫在head中   JS寫在body中-->
<body>
<style>
    #loginBlockContainer {
        margin-top: 10px;
        text-align: center;
    }

    #loginBlockContainer > .container {
        width: 266px;
        padding-left: 0px;
        padding-right: 0px;
    }
    @media (min-width: 1320px) {
        #loginBlockContainer {
            margin-top: 30px;
            text-align: center;
        }
    }

    .input-text {
        width:266px;
        border:1px #edf1f2 solid;
        border-radius:3px;
        background-color:#edf1f2;
        margin-top: 5px;
        margin-bottom: 5px;
    }

    .input-text::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
        font-size: 14px;
        color: #9da0a4;
        opacity: 1; /* Firefox */
    }

    .input-text:-ms-input-placeholder { /* Internet Explorer 10-11 */
        font-size: 14px;
        color: #9da0a4;
    }

    .input-text::-ms-input-placeholder { /* Microsoft Edge */
        font-size: 14px;
        color: #9da0a4;
    }

</style>
<script>
    function showLoginByAccount() {
        clearInterval(QrcodeLoginTimer);
        $('#buttonLoginByAccount').css('background-color', '#15bc97');
        $('#buttonLoginByAccount').css('color', '#FFFFFF');
        $('#buttonLoginByAccount').css('font-weight', 'bold');
        $('#buttonLoginByQrcode').css('background-color', '#FFFFFF');
        $('#buttonLoginByQrcode').css('color', '#000000');
        $('#buttonLoginByQrcode').css('font-weight', 'initial');
        $('#divLoginByQrcode').hide();
        $('#divLoginByAccount').show();
    }

    function showLoginByQrcode() {
        $('#buttonLoginByAccount').css('background-color', '#FFFFFF');
        $('#buttonLoginByAccount').css('color', '#000000');
        $('#buttonLoginByAccount').css('font-weight', 'initial');
        $('#buttonLoginByQrcode').css('background-color', '#15bc97');
        $('#buttonLoginByQrcode').css('color', '#FFFFFF');
        $('#buttonLoginByQrcode').css('font-weight', 'bold');
        getLoginQrcode4meUrl();
        $('#divLoginByQrcode').show();
        $('#divLoginByAccount').hide();
    }
    #buttonLoginByAccount {
        width:100%;
        height:45px;
        border:1px #15bc97 solid;
        border-radius:3px 0px 0px 3px;
        background-color:#15bc97;
        white-space: normal;
    }


</script>
<!-- Latest compiled and minified CSS -->
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">-->
<!--//                elearning           -->

<script type="text/javascript" src="./bootstrap.min.js"></script>
<!--                  elearning                  -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<!-- Latest compiled JavaScript -->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>-->
<div class = all_input >
    <div id="main">
        <div id="loginBlockHeader">
            <div class="container" style="max-width: 360px;">
                <div class="row" style="margin: 0 auto;">
                    <div class="col-md-12 col-xs-12" style="text-align: center;border-bottom: 1px solid #dfdfdf;">
                        <span class="t28"><h2> 登入 </h2></span></div>
                </div>
            </div>
        </div>

    <form method="post" action="#" id="loginForm" name="loginForm" onsubmit="return formSubmit();">
        <input type="hidden" name="reurl" value="">
        <input type="hidden" name="login_key" value="7f8aa3ec01245afc29779aac786f9cd2">
        <input type="hidden" name="encrypt_pwd" value="">
        <input type="hidden" name="ldapPWD" value="">
        <div id="loginBlockContainer">
            職位：
            <input type="radio" name="job" value="stu" checked="True">學生
            <input type="radio" name="job" value="tr">老師<br><br>
<!--            <div class="container">-->
<!--                <div id="course-tabs " class="row" style="margin:0 auto;">-->
<!--                    <div class="row nav nav-tabs" style="padding: 0px; margin: 0px;">-->
<!--                        <div class="col-md-6 col-xs-6" style="padding:0px;max-width:133px;"><input id="buttonLoginByAccount" type="button" class="t16_w_b  active" style="" value="使用帳號登入" onclick="showLoginByAccount();"></div>-->
<!--                        <div class="col-md-6 col-xs-6" style="padding:0px;max-width:133px;"><input id="buttonLoginByQrcode" type="button" class="t16_b  active" style="" value="QR code登入" onclick="showLoginByQrcode();"></div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

            <div id="divLoginByAccount" class="container">
                <div class="row" style="margin:0 auto;">
                    <input type="text" id="username" name="username" class="t14_b input-text" placeholder="帳號" value="">
                </div>
                <div class="row" style="margin:0 auto;">
                    <input type="password" id="password" name="password" class="t14_b input-text" placeholder="密碼">


                </div>
<!--                <div class="row" style="margin:0px;margin-top:15px;text-align: left;">-->
<!--                    <span style="text-align:left"><input type="checkbox" name="persist_login" value="1" style="margin:0 2px;" /></span>-->
<!--                    <span>記住我，保持登入</span>-->
<!--                </div>-->
<!--                <div class="row" style="margin:0px;margin-top:10px;text-align: left;">-->
<!--                    <span class="t13_o">為了避免個資被盜用，請勿在公用電腦或裝置選勾此項。</span>-->
<!--                </div>-->
                <div class="row" style="margin:0 auto;margin-top:15px;">
                    <button type="submit" class="t18_w" style="width:100%;height:45px;border:1px #feffac solid;border-radius:3px;background-color:#ffafde;" id="btnSignIn">登入</button>
                </div>
                <div class="row" style="margin:0 auto;margin-top:15px;">
                    <div class="col-md-7 col-xs-7 t13_b" style="text-align:right;">
                    </div>
                </div>
            </div>
            <div id="divLoginByQrcode" class="container" style="margin-top: 30px;margin-bottom: 30px;display: none;">
                <div class="row" style="width:228px;margin:0 auto;">
                    <div class="col-md-12 col-xs-12" style="width:228px;height:228px;border:8px solid #DFDFDF;padding:0px;">
                        <iframe id="iframe-qrcode" src="about:blank" scrolling="no" style="padding:0px;width:214px;height:214px;border:0px;margin:0px;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>


<script type="text/javascript" src="follow_mouse.js"></script>

<div id="cursor" style="position:absolute; z-index:999; visibility: visible;user-select: none">
    <!--    <img src="圖片2.png">-->
</div>
<script type="text/javascript" src="particle.js"></script>
<script type="text/javascript" src="love.js"></script>

</body>
</html>
