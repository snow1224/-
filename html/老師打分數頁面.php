<?php
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--    <link rel="stylesheet" href="./bootstrap-4.2.1-dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <!--    <script src="./bootstrap-4.2.1-dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <meta charset="UTF-8">
    <title>tr_page</title>
    <!--    <link rel="stylesheet" href="login_tr_and_stu.css">-->

</head>

<!--CSS寫在head中   JS寫在body中-->
<body>
<?php
$year = "1072";
echo '<hr>'.$year.'授課課程</h2>';
show_all_main_course();
function show_all_main_course (){
    echo '<div id="accordion" >';
    //先去看有幾個main course
    $N_main_url ='http://120.110.112.152:3000/api/org.example.empty.Main_course';
    //                        回傳一堆json檔案
    $N_main_get_data = callAPI('GET', $N_main_url, false);
    //                        把json解碼放response
    $N_main_response = json_decode($N_main_get_data, true);
//    echo $N_main_response[0]["Main_course_id"];
    for($N_main = 0 ; $N_main < count($N_main_response); $N_main++){
//        要置製造主課程的選單
        echo '<div class="card" >';
        echo '<div id="'.$N_main_response[$N_main]["Main_course_id"].'" class="card-header" >';
        // 做 以主課程為名的按鈕
        echo '<button data-target="#'.$N_main_response[$N_main]["Main_course_id"].'lists" aria-controls="'.$N_main_response[$N_main]["Main_course_id"].'lists" class="btn btn-link" data-toggle="collapse"  aria-expanded="false">';
            echo $N_main_response[$N_main]["name"];
        echo '</button>';
        echo '</div>';
        // 傳主課程id過去，要做主課程中的微課程了
        show_main_unit_course($N_main_response[$N_main]["Main_course_id"]);
        echo '</div>';
    }
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

    for($N_unit = 0 ; $N_unit < count($main_N_unit_response); $N_unit++){
        echo '<div id="'.$main_N_unit_response[$N_unit]["unit_course_id"].'">';
    //        每個unit table叫做  u002table  前面為unit id 加上table
            echo '<button data-target="#'.$main_N_unit_response[$N_unit]["unit_course_id"].'table" aria-controls="'.$main_N_unit_response[$N_unit]["unit_course_id"].'table" class="btn btn-link" data-toggle="collapse"  >';
                echo $main_N_unit_response[$N_unit]["name"];
            echo '</button>';

        echo '</div>';


        echo '<div id="'.$main_N_unit_response[$N_unit]["unit_course_id"].'table"  aria-labelledby="'.$main_N_unit_response[$N_unit]["unit_course_id"].'" class="collapse"  >';
    //            把unit id 傳過去
            show_unit_table($main_N_unit_response[$N_unit]["unit_course_id"]);

        echo '</div>';

    }

    echo '</div>';
}
//
function show_unit_table ($get_unit_course_id){
    echo '<table  border="1">';
    echo '<tr> <th>學號</th> <th>姓名</th> <th>出缺席</th>  <th>分數</th> </tr>';

    $get_unit_course_id_url = 'http://120.110.112.152:3000/api/queries/select_record_unit_course?unit_course=resource%3Aorg.example.empty.unit_course%23'.$get_unit_course_id;
//                        回傳一堆json檔案
    $get_unit_course_id_get_data = callAPI('GET', $get_unit_course_id_url, false);
//                        把json解碼放response


    $get_unit_course_id_response = json_decode($get_unit_course_id_get_data, true);
//                        echo count($response);
    for($n = 0 ; $n < count($get_unit_course_id_response) ; $n++) {
        $stu = explode("#", $get_unit_course_id_response[$n]["student"]);
        //                            echo $stu[1];
        echo '<tr>';
        echo '<td>' . $stu[1] . '</td>';
        $stu_url = 'http://120.110.112.152:3000/api/org.example.empty.student/' . $stu[1];
        //                                 echo $stu_url;
        //                                 echo "======".$n."<br>";
        $stu_get_data = callAPI('GET', $stu_url, false);
        //                                 echo $stu_get_data."<hr>";
        $stu_response = json_decode($stu_get_data, true);
        //                                 echo $stu_get_data;
        //                                 echo $stu_response["name"]."<hr>";

        echo '<td>' . $stu_response["name"] . '</td>';

        echo '<td>';
        $radio_name = $get_unit_course_id.$stu[1];

        echo '<input type="radio" name="attend' .$radio_name. '" value="attend" checked="True">出席';
        echo '<input type="radio" name="attend' .$radio_name. '" value="unattend">未出席';
        echo '</td>';

        echo '<td> <input type="text" name="score" size="8" ><br><br> </td>';
        echo '</tr>';
    }
//
//
    echo '</table>';
    echo '<br><input type="submit" name="button" value="送出"><hr>';
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
?>
</body>
</html>
