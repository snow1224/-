<?php
    session_start();
?>
<html lang="en" style="height: 100%">
<head>
  <title>SF</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./css/bootstrap-3.3.7/dist/css/bootstrap.min.css">
  <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"-->
  <link rel="stylesheet" href="w3.css">
  <link rel="stylesheet" href="w3-theme.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script-->
  <script src="./css/bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
</head>
<?php //這邊是選擇菜單  ?>
<nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
                  <a class="navbar-brand" href="#">UnitCourseWeb</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                      <li><a href="#"><span class="glyphicon glyphicon-star"></span> 我的最愛</a></li>
                      <li><a href="#"><span class="glyphicon glyphicon-shopping-cart"></span> 選課</a></li>
                      <?php
                        if(isset($_SESSION["login"]) && $_SESSION["login"]==1){
                           echo "<li><a href=\"./stu.php\"><span class=\"glyphicon glyphicon-user\"></span> 學生專區</a></li>";
                        }else{
                           echo "<li><a href=\"./login_page.php\"><span class=\"glyphicon glyphicon-user\"></span> Login</a></li>";
                        }
                      ?>
                      <li><a href="./logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
            </ul>
          </div>
</nav>

 <?php //這邊是選擇菜單  ?>
 
<!--/////////////學生清單///////////////-->
    <?php // w3-row-padding 微幅度調整padding，讓邊邊有大約5%的空間(目測) ?>
      <div class="w3-row-padding">
          <?php //w3-third 將文字調正成整個寬度的1/3 ;  w3-section上下增加16px的空間 ; P.S. w3-third也可以不寫，不過寬度會有些微的不同?>
            <div class="w3-third w3-section" style="width:100%;">
                <?php // nav-tabs使之生成tab區塊 P.S.這個是bootstrap3.3.7版本(QQ)?>
                  <ul class="nav nav-tabs" >
                       <li><a href="#1071" class="acative" data-toggle="tab" style="background-color:skyblue">1071</a></li>
                       <li><a href="#1072" data-toggle="tab" style="background-color:skyblue">1072</a></li>
                        
                  </ul>
                  <div class="w3-container w3-light-gray" style="height: 80%; overflow:auto; overflow-x: hidden;">
                   
                   <br>
                   
                   <div class="tab-content">
                       
                       <div id="A" class="tab-pane fade in active">
                                  
                                  
                                  <div class="panel-group" >
                                      <?php //M001為主課程div的id ?>
                                        <div id="M001" class="panel w3-green" >
                                            <div class="panel-heading">   
                                                <button data-target="#all_unit_001" aria-controls="all_unit_001" class="w3-block text-mute" data-toggle="collapse"  aria-expanded="false">
                                                    主課程A
                                                </button>
                                            </div>
                                        </div>
                                        <div id="all_unit_001"  aria-labelledby="all_unit_001" class="collapse"  >
                                        <!-- 主課程A ↓-->
                                            <div id="collapse1"> 
                                                    <div id="M001" class="panel panel-default" >
                                                        <table class="table">
                                                            <thead>
                                                              <tr class="w3-light-green">
                                                                <th>課程名稱</th>
                                                                <th>分數</th>
                                                                <th>備註</th>
                                                              </tr>
                                                            </thead>
                                                         
                                                        <tbody>
                                                            <tr>
                                                                <td>微課程001</td>
                                                                <td>90</td>
                                                                <td>--</td>
                                                            </tr>
                                                            <tr>
                                                                <td>微課程003</td>
                                                                <td>80</td>
                                                                <td>--</td>
                                                            </tr>
                                                        </tbody>    
                                                     </table>   
                                                    </div>
                                                    
                                            </div>
                                        <!-- 主課程A ↑-->
                                        </div>
                                    </div>
                                  
                       </div>
                       
                        <div id="1072" class="tab-pane fade">
                             
                        </div>
                       
                   </div>
                   <br>
                   <center>
                       <form action="index.php" method="post">
                           <button type="submit" name="result" class="btn btn-info"><h5>結算學分</h5></button>
                       </form>
                   </center>
               </div>
            </div>
      </div>
<!--/////////////學生清單///////////////-->
</html>
