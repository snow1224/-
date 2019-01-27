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


<div class = all_input >

    <form name="test" method="post" action="v1.login_system.php">

<!-- pattern="[A-Za-z].{3,}" title="Please input number or English"  -->
                帳號：
                <input type="text" name="useraccount" size="10" ><br><br>
                密碼：
                <input type="password" name="userpassword" size="10" ><br><br>



        職稱：
        <input type="radio" name="job" value="stu" checked="True">學生
        <input type="radio" name="job" value="tr">老師
        <br><br>
                <br>
                <input type="submit" name="sub" size="5" value="確定">
    </form>
</div>


<script type="text/javascript" src="follow_mouse.js"></script>

<div id="cursor" style="position:absolute; z-index:999; visibility: visible;user-select: none">
    <img src="圖片2.png">
</div>
<script type="text/javascript" src="particle.js"></script>
<script type="text/javascript" src="love.js"></script>

</body>
</html>
