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

<?php //初始化變數 
    $student_url = 'http://120.110.112.152:3000/api/org.example.empty.student/'.$_SESSION["member"]["stu"]["account"]; 
    $student_encode = callAPI('GET', $student_url, false);  // 尚未解析成JSON
    $student = json_decode($student_encode, true);
    $main_course_url = 'http://120.110.112.152:3000/api/org.example.empty.Main_course'; 
    $main_course_encode = callAPI('GET', $main_course_url, false);  // 尚未解析成JSON
    $main_course = json_decode($main_course_encode, true);
    function callAPI($method, $url, $data){
    $curl = curl_init();
    switch ($method){
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data){
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "DELETE":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST,"DELETE");
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'APIKEY: 111111111111111111111',
        'Content-Type: application/json',
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // EXECUTE:
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
    }
      //初始化變數 ?>

<?php //自動生成學期tab 
    function semester_tab($student){
        $year=$student["academic_year"];
        for($i=1;$i<=$student["degree"];$i++){
            if($i==1){
                echo '<li><a href="#'.$year.'1" class="acative" data-toggle="tab" style="background-color:skyblue">'.$year.'1</a></li>';
                echo '<li><a href="#'.$year.'2" class="acative" data-toggle="tab" style="background-color:skyblue">'.$year.'2</a></li>';   
            }
            else{
                echo '<li><a href="#'.$year.'1" data-toggle="tab" style="background-color:skyblue">'.$year.'1</a></li>';
                echo '<li><a href="#'.$year.'2" data-toggle="tab" style="background-color:skyblue">'.$year.'2</a></li>';   
            }
            $year++;
        }
    }
      //自動生成學期tab ?>
<?php 
    function semester_tab_content($main_course,$student){
        echo '<div class="tab-content">';
        echo '<h3>通過課程</h3>';
        
        echo '<h3>未通過課程</h3>';
        $index=1;
        $year=$student["academic_year"];
        for($i=0;$i<$student["degree"];$i++){
            
            $semester=$year.''.$index;
            if($i==0){
                echo '<div id="'.$semester.'" class="tab-pane fade in active">';
            }else{
                echo '<div id="'.$semester.'" class="tab-pane fade">';
            }
            stu_main_course_list($main_course,$semester);
            
            $index++;
            if($index>2){ 
                $index=1;
                $year++;
            }
            echo '</div>';
        }
        echo '</div>';
    }
    //自動生成tab內容?>
<?php //自動生成課程清單 
    function stu_main_course_list($main_course,$semester){
        $flag=0;
        $unit_index=1;
        echo '<div class="panel-group">';
            for($i=0;$i<count($main_course);$i++){
                $record_url = 'http://120.110.112.152:3000/api/queries/select_record_and_semester?semester=resource%3Aorg.example.empty.semester_list%23'.$semester.'&student=resource%3Aorg.example.empty.student%23'.$_SESSION["member"]["stu"]["account"].'&main_course=resource%3Aorg.example.empty.Main_course%23'.$main_course[$i]["Main_course_id"]; 
                $record_encode = callAPI('GET', $record_url, false);  // 尚未解析成JSON
                $record = json_decode($record_encode, true);
                if(count($record)!=0){
                    
                    if($flag==0){
                        echo '<div id="'.$main_course[$i]["Main_course_id"].'" class="tab-pane fade in active">';
                        $flag=1;
                    }else{
                        echo '<div id="'.$main_course[$i]["Main_course_id"].'" class="tab-pane fade">';
                    }
                    echo '<div id="'.$main_course[$i]["Main_course_id"].'" class="panel w3-green" >';
                    echo '<div class="panel-heading">';
                    echo '<div data-target="#all_unit_'.$unit_index.'" aria-controls="all_unit_'.$unit_index.'"  data-toggle="collapse"  aria-expanded="false">'.$main_course[$i]["name"].'</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div id="all_unit_'.$unit_index.'"  aria-labelledby="all_unit_'.$unit_index.'" class="collapse">';
                    echo '<div id="collapse'.$unit_index.'"> ';
                    echo '<div id="'.$main_course[$i]["Main_course_id"].'" class="panel panel-default">';
                    echo '<table class="table">';
                    echo '<thead>';
                    echo '<tr class="w3-light-green">';
                    echo '<th>課程名稱</th>';
                    echo '<th>分數</th>';
                    echo '<th>備註</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    for($j=0;$j<count($record);$j++){
                        $unit_course_arr = explode('#',$record[$j]["unit_course"]);
                        $unit_course_id = $unit_course_arr[count($unit_course_arr)-1];
                        $unit_course_url = 'http://120.110.112.152:3000/api/org.example.empty.unit_course/'.$unit_course_id;
                        $unit_course_encode = callAPI('GET', $unit_course_url, false);  // 尚未解析成JSON
                        $unit_course = json_decode($unit_course_encode, true);
                        echo '<tr>';
                        echo '<td>'.$unit_course["name"].'</td>';
                        echo '<td>'.$record[$j]["score"].'</td>';
                        echo '<td>--</td>';   //備註，以後要增加的欄位
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    
                    $unit_index++;
                } 
            }
        echo '</div>';
    }
      //自動生成課程清單 ?>


<?php //這邊是選擇菜單  ?>
<nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
                  <a class="navbar-brand" href="#">微學分選課系統</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                      <li><a href="#"><span class="glyphicon glyphicon-star"></span> 我的最愛</a></li>
                      <li><a href="./index.php"><span class="glyphicon glyphicon-shopping-cart"></span> 選課</a></li>
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
      <div class="w3-row-padding">
            <div class="w3-third w3-section" style="width:100%;">
                  <ul class="nav nav-tabs" >
                       <?php semester_tab($student); ?>
                        
                  </ul>
                  <div class="w3-container w3-light-gray" style="height: 80%; overflow:auto; overflow-x: hidden;">
                   
                   <br>
                   
                   <?php semester_tab_content($main_course,$student); ?>
                       
                   
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
