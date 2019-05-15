<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .popover-title {
            color: #000;
            font-weight: bold;
            background-color: greenyellow;

        }
        .popover-content {
            /*overflow-y:auto;*/
            color: #000;
            word-break: break-all;
            height: 40px;
            background-color:lightyellow;

        }
    </style>


    <link rel="stylesheet" href="./css/bootstrap-3.3.7/dist/css/bootstrap.min.css">
    <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"-->
    <link rel="stylesheet" href="w3.css">
    <link rel="stylesheet" href="w3-theme.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script-->
    <script src="./css/bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>


    <meta charset="UTF-8">
    <title>tr_page</title>
    <!--    <link rel="stylesheet" href="login_tr_and_stu.css">-->

</head>

<!--CSS寫在head中   JS寫在body中-->
<body style="background-image:url(./img/background.jpg)">
<?php //這邊是選擇菜單  ?>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">微學分選課系統</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="v1.5_tr_input_score.php"><span class="glyphicon glyphicon-star"></span> 評分</a></li>
            <li><a href="v1.6_tr_open_course.php"><span class="glyphicon glyphicon-shopping-cart"></span> 開課</a></li>
            <?php
            if(isset($_SESSION["login"]) && $_SESSION["login"]==1){
                echo "<li><a href=\"./stu.php\"><span class=\"glyphicon glyphicon-user\"></span> 學生專區</a></li>";
            }else if(isset($_SESSION["login"]) && $_SESSION["login"]!=2){
                echo "<li><a href=\"./login_page.php\"><span class=\"glyphicon glyphicon-user\"></span> Login</a></li>";
            }
            ?>
            <li><a href="./logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
    </div>
</nav>
<!--<a href="./close_session.php"> 關閉seesion </a><br><br>-->

<?php //這邊是選擇菜單  ?>
<?php
$file_name = "v1.6_tr_open_course.php";
$year = "1072";
echo '<h2>'.$year.'授課課程</h2>';
echo '<div class="w3-container" style="height: 80%; overflow:auto; overflow-x: hidden;">';
echo '<div class="w3-row-padding">';
show_all_main_course($file_name);
echo '<a href=https://zh.pngtree.com>來自pngtree.com的圖形</a>';
echo '</div>';
echo '</div>';
function show_all_main_course ($file_name){
//    echo '<script> var main_intro="新增主課程";</script>';
    echo '<br>';
    echo '<div   title="新增主課程" data-content="新增主課程" data-toggle="popover" data-placement="bottom"><button type="button" name="tr_add_main_course"    class="btn btn-success btn-info btn-lg btn btn-primary popover-hide"  data-container="body"  data-toggle="modal" data-target="#main"   value=""  style="width:97%;background-color:#A0D382;padding:10px; margin:0 20px;" ><span class="glyphicon glyphicon-plus"></span></button></div>';
    echo '<br><br>';
    echo '<div id="accordion" class="w3-row-padding">';
    //先去看有幾個main course
    $N_main_url ='http://120.110.112.152:3000/api/org.example.empty.Main_course';
    //                        回傳一堆json檔案
    $N_main_get_data = callAPI('GET', $N_main_url, false);
    //                        把json解碼放response
    $N_main_response = json_decode($N_main_get_data, true);
//    echo $N_main_response[0]["Main_course_id"];
    
    for($N_main = 0 ; $N_main < count($N_main_response); $N_main++){
//        要置製造主課程的選單   background-color:#0353A4;
        echo '<div class="w3-third w3-section">';
        echo '<div class="card" style="border-radius:10px;">';
        $N_main_response[$N_main]["Main_course_id"] = trim($N_main_response[$N_main]["Main_course_id"]);
        echo '<div id="'.$N_main_response[$N_main]["Main_course_id"].'" style="background-image:url(./img/open_main_course3.png);background-size:cover;border-radius:10px;border-bottom-style:solid;border-right-style:solid;border-color:black;" class="card-header" >';
        // 做 以主課程為名的按鈕
        echo '<center><button data-target="#'.$N_main_response[$N_main]["Main_course_id"].'lists" style="color: white;" aria-controls="'.$N_main_response[$N_main]["Main_course_id"].'lists" class="btn btn-link" data-toggle="collapse"  aria-expanded="false">';



        echo "<h5>".$N_main_response[$N_main]["name"]."</h5>";
        //       主課程的+
//        echo '<div class="container">';
//        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#unit">Open Modal</button>

        echo '<button type="button" name="tr_add_unit_course" class="btn btn-success  " value="" data-toggle="modal"  data-target="#unit'.$N_main_response[$N_main]["Main_course_id"].'" style="float:right;margin-top:1em;margin-right:4em;"><span class="glyphicon glyphicon-plus" ></span></button>';
        //!!!!!!!!!!!!!!!!

        ?>

        <!-- Trigger the modal with a button -->

        <!-- Modal -->

        <div class="modal fade" id="main" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <form name="open_main_course" method="post" action="<?php echo $file_name; ?>"><br>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">建立主課程</h4>
                        </div>
                        <div class="modal-body ">
                            <table>

                                <tr>
                                    <td>課程名稱：</td>
                                    <td><br><input type="text" name="input_course_name" size="20" required="required" placeholder="範例輸入:資訊基礎程式入門"><br><br></td>
                                </tr>
                                <tr>
                                    <td>部門：</td>
                                    <td><br><input type="text" name="input_department" size="20" required="required" placeholder="範例輸入:資訊學院"><br><br></td>
                                </tr>
                                <tr>
                                    <td>學分：</td>
                                    <td><br><input type="number" name="input_credit" size="20" min="1" max="5" x required="required" placeholder="範例輸入:1" style="width:10vw;" ><br><br></td>
                                </tr>
                                <tr>
                                    <td>須通過時數：</td>
                                    <td><br><input type="number" name="input_pass_hours" size="20" required="required" min="1" max="50" placeholder="範例輸入:1" style="width:10vw;" >(未滿1小時，以1小時計算)<br><br></td>
                                </tr>
                                <tr>
                                    <td>是否開放給外系：</td>
                                    <td><br><input type="radio" name="input_external_status" size="20" checked="true">是
                                        <input type="radio" name="input_external_status" size="20">否 <br><br>
                                    </td>
                                </tr>





                            </table>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="post_tr_main_course_sub" size="5" value="確定">
                        </div>
                    </form>

                </div>

            </div>
        </div>

        <div class="modal fade" id="unit<?php echo $N_main_response[$N_main]["Main_course_id"]; ?>" role="dialog">
            <div class="modal-dialog"  >

                <!-- Modal content-->
                <div class="modal-content" style="overflow:auto;overflow-y:scroll;overflow-x:scroll;overflow: scroll;height: 600px">
                    <form name="open_unit_course" method="post" action="<?php echo $file_name; ?>"><br>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">建立微課程</h4>
                        </div>
                        <div class="modal-body " >
                            <table >
<!--                                1-->
                                <tr>
                                    <td>
                                        主課程：
                                    </td>
                                    <td>
                                        <?php echo $N_main_response[$N_main]["Main_course_id"]; ?><br>
                                        <input type="hidden" name="input_hidden_Main_course"  value="<?php echo $N_main_response[$N_main]["Main_course_id"]; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        微課程名字：
                                    </td>
                                    <td>
                                        <br><input type="text" name="input_name" size="20" placeholder="範例輸入:資訊程式基礎入門" required="required"><br><br>
                                    </td>
                                </tr>
<!--                                2-->
                                <tr>
                                    <td>
                                        課程介紹：
                                    </td>
                                    <td>
                                        <?Php $intro = "提供給資訊入門的新鮮人";?>
                                        <br><textarea type="text" name="input_introduction" style="width:19vw;height:20vw;" placeholder="範例輸入:<?php echo $intro?>" required="required" size="15" ></textarea><br><br>

                                    </td>
                                </tr>

<!--                                3-->
                                <tr>
                                    <td>
                                        上課開始日期：
                                    </td>
                                    <td>
                                        <br><input type="date" name="input_start_date" required="required"   style="width:10vw;">範例輸入:2019/03/12<br><br>
                                    </td>
                                </tr>
<!--                                4-->
                                <tr>
                                    <td>
                                        上課結束日期：
                                    </td>
                                    <td>
                                        <br><input type="date" name="input_end_date" required="required"  style="width:10vw;">範例輸入:2019/03/12<br><br>
                                    </td>
                                </tr>
<!--                                5-->
                                <tr>
                                    <td>
                                        上課開始時間：
                                    </td>
                                    <td>
                                        <br><input type="time" name="input_start_time" required="required"  pattern="^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$"  style="width:10vw;">範例輸入:下午 02:00<br><br>
                                    </td>
                                </tr>
<!--                                6-->
                                <tr>
                                    <td>
                                        上課結束時間：
                                    </td>
                                    <td>
                                        <br><input type="time" name="input_end_time"  required="required"  style="width:10vw;">範例輸入:下午 04:00<br><br>
                                    </td>
                                </tr>


<!--                                7-->
<!--                                <tr>-->
<!--                                    <td>-->
<!--                                        星期：-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <br><input type="text" name="input_weeks" placeholder="範例輸入:一" required="required" size="20"><br><br>-->
<!--                                    </td>-->
<!--                                </tr>-->
                                <tr>
                                    <td>
                                        上課地點：
                                    </td>
                                    <td>
                                        <br><input type="text" name="input_classroom" size="20" placeholder="範例輸入:place001" required="required"><br><br>
                                    </td>
                                </tr>
<!--                                8-->
                                <tr>
                                    <td>
                                        授課老師id：
                                    </td>
                                    <td>
                                        <br><input type="text" name="input_teacher" size="20" placeholder="範例輸入:tr001" required="required"><br><br>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        部門：
                                    </td>
                                    <td>
                                        <br><input type="text" name="input_department" size="20" placeholder="範例輸入:資訊學院" required="required"><br><br>
                                    </td>
                                </tr>
<!--                                9-->

<!--                                10-->


<!--                                11-->

<!--                                12-->
                                <tr>
                                    <td>
                                        學期：
                                    </td>
                                    <td>
                                        <br><input type="number"  min="0"  name="input_semester" placeholder="範例輸入:1072" required="required"  style="width:10vw;"><br><br>
                                    </td>
                                </tr>

                                <!--                                13-->
                                <tr>
                                    <td>
                                        上課時數：
                                    </td>
                                    <td>
                                        <br><input type="number" min="1" max="3000" name="input_hours" placeholder="範例輸入:1" required="required"  style="width:10vw;">(未滿一個小時，以一個小時計算)<br><br>
                                    </td>
                                </tr>
<!--                                14-->
                                <tr>
                                    <td>
                                        最大學生數：
                                    </td>
                                    <td>
                                        <br><input type="number" min="1" max="30000" name="input_max_stu" placeholder="範例輸入:30" required="required"  style="width:10vw;"><br><br>
                                    </td>
                                </tr>
<!--                                15-->
                                <tr>
                                    <td>
                                        通過分數：
                                    </td>
                                    <td>
                                        <br><input type="number" min="0" max="100" name="input_pass_score" placeholder="範例輸入:70" required="required"  style="width:10vw;"><br><br>
                                    </td>
                                </tr>
                            </table>


                            <!--                                <input type="radio" name="input_external_status" size="20"> <br><br>-->

                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="post_tr_unit_course_sub" size="5" value="確定">
                        </div>
                    </form>

                </div>

            </div>
        </div>

        <?php
        echo '</div>';
        echo '</button></center>';
        echo '</div>';
// 傳主課程id過去，要做主課程中的微課程了
        show_main_unit_course($N_main_response[$N_main]["Main_course_id"]);
        echo '</div>';
    }
    echo '</div><br>';
    echo '<div>';
//    onclick="location.href='http://localhost:81/mini/v1.1_tr_open_ex_main_course.php'"
//    echo '<button type="button" name="tr_add_main_course" class="btn btn-success btn-info btn-lg" data-toggle="modal" data-target="#main"  value=""  style="width:97%;background-color:#FFD382;padding:10px; margin:0 20px;" ><span class="glyphicon glyphicon-plus"></span></button>';
    echo '</div>';
}
function show_main_unit_course($N_main_id){
//    //他的id叫做  M002lists  前面是主課程id，加上"lists"
    echo '<div id="'.$N_main_id.'lists"  aria-labelledby="'.$N_main_id.'" class="collapse" >';
    // 根據main id 找他有幾個微課程
    $main_N_unit_url ='http://120.110.112.152:3000/api/queries/select_unit_course?Main_course=resource%3Aorg.example.empty.Main_course%23'.$N_main_id;
    //      回傳一堆json檔案
    $main_N_unit_get_data = callAPI('GET', $main_N_unit_url, false);
    //                        把json解碼放response
    $main_N_unit_response = json_decode($main_N_unit_get_data, true);
//background-color: #B9D6F2;
    for($N_unit = 0 ; $N_unit < count($main_N_unit_response); $N_unit++){
        echo '<div id="'.$main_N_unit_response[$N_unit]["unit_course_id"].'" style="background-image:url(./img/open_main_course2.png);background-size:cover;" >';
        //        每個unit table叫做  u002table  前面為unit id 加上table
//        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#unit">Open Modal</button>
        echo '<div data-target="#'.$main_N_unit_response[$N_unit]["unit_course_id"].'table"  style="color: black;" aria-controls="'.$main_N_unit_response[$N_unit]["unit_course_id"].'table" class="btn" data-toggle="collapse"  >';
//        echo "<front color='red'>".$main_N_unit_response[$N_unit]["attend_status"]."</front>";
//        echo $main_N_unit_response[$N_unit]["attend_status"];
//        echo "<h3>".$main_N_unit_response[$N_unit]["name"]."</h3>";
        echo '<h6 style="color:white;">'.$main_N_unit_response[$N_unit]["name"].'</h6>';
//     微課程的+
//        echo '<button type="submit" name="tr_add_main_course" class="btn btn-success" value=""><span class="glyphicon glyphicon-plus"></span></button>';

        echo '</div>';

        echo '</div>';



        echo '<div id="'.$main_N_unit_response[$N_unit]["unit_course_id"].'table"  aria-labelledby="'.$main_N_unit_response[$N_unit]["unit_course_id"].'" class="collapse"  >';
        //            把unit id 還有空的$all_stu_id陣列傳過去
//        show_unit_table($main_N_unit_response[$N_unit]["unit_course_id"]);

        echo '</div>';

    }

    echo '</div>';
}
//

function callAPI($method, $url, $data){
    $curl = curl_init();
    switch ($method){
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data){
                echo $data;
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

if(isset($_POST["post_tr_main_course_sub"])){
    $post_id = uniqid(rand());
    $post_main_course_name = $_POST["input_course_name"];
    $post_credit = $_POST["input_credit"];
    $post_department = "resource:org.example.empty.department#".$_POST["input_department"];
    $post_external_status = $_POST["input_external_status"];
    $post_pass_hours = $_POST["input_pass_hours"];

    $data_array =  array(
        "Main_course_id"   => $post_id,
        "name"             => $post_main_course_name,
        "credit"           => $post_credit,
        "department"       => $post_department,
        "external_status"  => $post_external_status,
        "pass_hours"       => $post_pass_hours,
        "use_status"       => true,
    );

    $make_call = callAPI('POST', 'http://120.110.112.152:3000/api/org.example.empty.Main_course', json_encode($data_array));
    $response = json_decode($make_call, true);
    echo "<script> alert('恭喜新增主課程成功');</script>";
}
if(isset($_POST["post_tr_unit_course_sub"])){
    $post_id = uniqid(rand());
    $post_input_name= $_POST["input_name"];
    $post_input_introduction = $_POST["input_introduction"];

//            日期  時間合併
    $post_input_start_date = $_POST["input_start_date"];
    $post_input_end_date = $_POST["input_end_date"];
    $post_input_start_time = $_POST["input_start_time"];
    $post_input_end_time = $_POST["input_end_time"];

//            $hours = $post_input_end_time - $post_input_start_time;
//            echo $hours;
    $start_course = $post_input_start_date." ".$post_input_start_time;
    $end_course = $post_input_end_date." ".$post_input_end_time;
//           echo $post_input_start_date." ".$post_input_start_time;
    $hours_dif = (strtotime($end_course) - strtotime($start_course))/ (60*60);
//            if($hours_dif % 1 != 0)
//                $hours_dif++;
//            echo $hours_dif;
//    $post_input_weeks = $_POST["input_weeks"];
    $post_input_department = "resource:org.example.empty.department#".$_POST["input_department"];
    $post_input_teacher = "resource:org.example.empty.teacher#".$_POST["input_teacher"];

    $post_input_classroom = "resource:org.example.empty.classroom#".$_POST["input_classroom"];
    $post_input_Main_course = "resource:org.example.empty.Main_course#".trim($_POST["input_hidden_Main_course"]);

    $post_input_semester = "resource:org.example.empty.semester_list#".$_POST["input_semester"];
    $post_input_hours = $_POST["input_hours"];
    $post_input_max_stu = $_POST["input_max_stu"];
    $post_input_pass_score = $_POST["input_pass_score"];
//    $week = array("日","一","二","三","四","五","六");
    $week_day = get_chinese_weekday($post_input_start_date);

//    $start = strtotime($post_input_start_time);
//    $end = strtotime($post_input_end_time);
//    $timeDiff = $end - $start;
//    echo timetostr($timeDiff) % 60;
//    if($timeDiff % 60 == 0){
//        echo "?";
//        $time_hour = $timeDiff/60;
//    }
//    else{
//        $time_hour = ($timeDiff/60)+1;
//        echo "!!";
//    }
//
//    echo $time_hour."<hr>";

    $data_array =  array(
        "unit_course_id"   =>    $post_id,
        "name"             =>    $post_input_name,
        "start_time"       =>    $start_course,
        "end_time"         =>    $end_course,
        "hours"            =>    $post_input_hours,
        "weeks"            =>    $week_day,
        "department"       =>    $post_input_department,
        "teacher"          =>    $post_input_teacher,
        "max_stu"          =>    $post_input_max_stu,
        "classroom"        =>    $post_input_classroom,
        "pass_score"       =>    $post_input_pass_score,
        "selection_course_people"   =>    0,
        "introduction"     =>    $post_input_introduction,
        "use_status"       =>    true,
        "Main_course"      =>    $post_input_Main_course,
        "semester"         =>    $post_input_semester,
    );

    $make_call = callAPI('POST', 'http://120.110.112.152:3000/api/org.example.empty.unit_course', json_encode($data_array));
    $response = json_decode($make_call, true);
    echo "<script> alert('恭喜新增微成功');</script>";
}
    function get_chinese_weekday($datetime)
    {
        $weekday  = date('w', strtotime($datetime));
        $weeklist = array('日', '一', '二', '三', '四', '五', '六');
        return $weeklist[$weekday];
    }

?>
<script>
    $(document).ready(function(){
        //trigger:'hover' 滑過就會出現
        $('[data-toggle="popover"]').popover({trigger:'hover'});
    });
</script>
</body>
</html>
