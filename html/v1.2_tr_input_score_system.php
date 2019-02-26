<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <title>tr_page_system</title>
</head>

<body>
<?php

// 按下確定修改，開始執行儲存修改的動作
//if(isset($_POST["sub_button"])){
//    有傳送$all_stu_id陣列 過來
//    有傳送unit id 過來
//    $all_stu_id = $_POST["all_stu_id"];
    $unit_id = $_POST["unit_id"];
//    echo "<hr>";
    $n_stu = $_POST["n_stu"];
    $main_id = $_POST["main_id"];
    $semester_list = $_POST["semester_list"];
//    echo $unit_id;
//    echo $n_stu;
    for($n = 0 ; $n < $n_stu ; $n++){
//        attendA001pig001   attendA001pig002  attendA001pig003
//        $_SESSION["course"][$unit_id][$n]為這個為課程  第n個學生的id
//        echo $_SESSION["course"][$unit_id][0]."<br>";

        $one_stu_status = strtolower($_POST["attend".$unit_id."".$_SESSION["course"][$unit_id][$n]]);
        $one_stu_score = strtolower($_POST["score".$unit_id."".$_SESSION["course"][$unit_id][$n]]);
//        $SESSION["course"][A001][pig001] = select id
//        echo $one_stu_status;
//        echo $_SESSION["course"][$unit_id][$_SESSION["course"][$unit_id][$n]];
        switch ($one_stu_status){
            case "attend":
                $put_sel_id = $_SESSION["course"][$unit_id][$_SESSION["course"][$unit_id][$n]];
//        $get_data = put_get_sub($put_sel_id);
//        $response = json_decode($get_data, true);

                $data_array =  array(
                    "select_record_id"  =>  $_SESSION["course"][$unit_id][$_SESSION["course"][$unit_id][$n]],
                    "semester_list"     =>  "resource:org.example.empty.semester_list#".$semester_list,
                    "attend_status"     =>  "ATTEND",
                    "pass_status"       =>  false,
                    "score"             =>  $one_stu_score,
                    "student"           =>  "resource:org.example.empty.student#".$_SESSION["course"][$unit_id][$n],
                    "unit_course"       =>  "resource:org.example.empty.unit_course#".$unit_id,
                    "main_course"       =>  "resource:org.example.empty.Main_course#".$main_id,
                );
                $put_url = 'http://120.110.112.152:3000/api/org.example.empty.select_record/'.$_SESSION["course"][$unit_id][$_SESSION["course"][$unit_id][$n]];
                $update_plan = callAPI('PUT', $put_url, json_encode($data_array));
//                header("Location:v1.5_tr_input_score.php");
                break;
            case "unattend":
//                echo "ywal";
                $put_sel_id = $_SESSION["course"][$unit_id][$_SESSION["course"][$unit_id][$n]];
//        $get_data = put_get_sub($put_sel_id);
//        $response = json_decode($get_data, true);

                $data_array =  array(
                    "select_record_id"  =>  $_SESSION["course"][$unit_id][$_SESSION["course"][$unit_id][$n]],
                    "semester_list"     =>  "resource:org.example.empty.semester_list#".$semester_list,
                    "attend_status"     =>  "ABSENCE",
                    "pass_status"       =>  false,
                    "score"             =>  $one_stu_score,
                    "student"           =>  "resource:org.example.empty.student#".$_SESSION["course"][$unit_id][$n],
                    "unit_course"       =>  "resource:org.example.empty.unit_course#".$unit_id,
                    "main_course"       =>  "resource:org.example.empty.Main_course#".$main_id,
                );
                $put_url = 'http://120.110.112.152:3000/api/org.example.empty.select_record/'.$_SESSION["course"][$unit_id][$_SESSION["course"][$unit_id][$n]];
                $update_plan = callAPI('PUT', $put_url, json_encode($data_array));
//                header("Location:v1.5_tr_input_score.php");
                break;
        }
    }
    header("Location:./v1.5_tr_input_score.php");
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
?>
<br><br>
<a href="./v1.5_tr_input_score.php"> 回到老師輸入成績頁面 </a><br><br>
<a href="./close_session.php"> 關閉seesion </a><br><br>
</body>

</html>
