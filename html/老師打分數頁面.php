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

function show_all_main_course (){
    echo '<div id="accordion" >';
        echo '<div class="card" >';
            echo '<div id="M001" class="card-header" >';
                echo '<button data-target="#all_unit_001" aria-controls="all_unit_001" class="btn btn-link" data-toggle="collapse"  aria-expanded="false">';
                    echo "Main_course_A";
                echo '</button>';
            echo '</div>';
    show_main_unit_course();

    echo '</div>';
}
function show_main_unit_course(){

}
?>




<div id="accordion" >
    <!--    AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA-->
    <div class="card" >
<!--       id="M001" 為 main id -->
        <div id="M001" class="card-header" >
<!--            <h5 class="mb-0">-->
<!--            data-target="#all_unit_001" 為 main id + lists-->
                <button data-target="#all_unit_001" aria-controls="all_unit_001" class="btn btn-link" data-toggle="collapse"  aria-expanded="false">
                    A
                </button>
<!--            </h5>-->
        </div>
        <!--      <div id="all_unit_001"  aria-labelledby="M001" class="collapse"  > class有無show，就會看能不能自動展開  data-parent="#heading_02"屬性，  把data-parent拿掉，打開B就不會自動把A關起來-->
<!--        id="all_unit_001" 為 main id + lists      &&  aria-labelledby="M001" 為main id -->
        <div id="all_unit_001"  aria-labelledby="M001" class="collapse"  > <!-- data-parent="#accordion" -->
<!--            a001  a001 a001 a001 a001-->
<!--           id="collapse1" 為unit id -->
            <div id="collapse1">
<!--               data-target="#unit_course_a01" 為 unit id + table   &&  aria-controls="unit_course_a01"  為 unit id + table-->
                <button data-target="#unit_course_a01" aria-controls="unit_course_a01" class="btn btn-link" data-toggle="collapse"  >
                    A001
                </button>
            </div>
<!--           id="unit_course_a01" 為unit id + table  &&   aria-labelledby="collapse1" 為unit id-->
            <div id="unit_course_a01"  aria-labelledby="collapse1" class="collapse"  > <!-- data-parent="#M001" -->
                <table  border="1">
                    <tr><th>學號</th> <th>姓名</th> <th>出缺席</th>  <th>分數</th></tr>
                    <!--                    第一個學生   -->

                    <?php
                        show_unit_table("u001");

                        function show_unit_table($get_unit_course_id){
                            $url = 'http://120.110.112.152:3000/api/queries/select_record_unit_course?unit_course=resource%3Aorg.example.empty.unit_course%23'.$get_unit_course_id;
                        //                        回傳一堆json檔案
                            $get_data = callAPI('GET', $url, false);
                        //                        把json解碼放response


                            $response = json_decode($get_data, true);
                        //                        echo count($response);
                            for($n = 0 ; $n < count($response) ; $n++) {
                                $stu = explode("#", $response[$n]["student"]);
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

                                echo '<input type="radio" name="attend' . $stu[1] . '" value="attend" checked="True">出席';
                                echo '<input type="radio" name="attend' . $stu[1] . '" value="unattend">未出席';
                                echo '</td>';

                                echo '<td> <input type="text" name="score" size="8" ><br><br> </td>';
                                echo '</tr>';
                            }

                        }
                     ?>


                </table>
            </div>
<!--         a002   a002  a002   a002  a002-->
            <div id="collapse2">
                <button data-target="#unit_course_02" aria-controls="unit_course_02" class="btn btn-link" data-toggle="collapse"  >
                    A002
                </button>
            </div>
            <div id="unit_course_02"  aria-labelledby="collapse2" class="collapse"  > <!-- data-parent="#M001" -->
                hi i am A002
            </div>

<!--            a003  a003  a003  a003  a003-->
            <div id="collapse3">
                <button data-target="#unit_course_03" aria-controls="unit_course_03" class="btn btn-link" data-toggle="collapse" >
                    A003
                </button>
            </div>
            <div id="unit_course_03"  aria-labelledby="collapse3" class="collapse"  > <!-- data-parent="#M001" -->
                hi i am A003
            </div>


        </div>
    </div>

    <!--BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB-->


    <div class="card" >
        <div id="heading_02" class="card-header" >
            <h5 class="mb-0">
                <button data-target="#all_unit_002" aria-controls="all_unit_002" class="btn btn-link" data-toggle="collapse"  aria-expanded="false">
                    B
                </button>
            </h5>
        </div>
        <div id="all_unit_002"  aria-labelledby="heading_02" class="collapse"  > <!-- data-parent="#accordion" -->
            <div id="collapse1">
                <button data-target="#unit_course_a02" aria-controls="unit_course_a02" class="btn btn-link" data-toggle="collapse"  >
                    B001
                </button>
            </div>
            <div id="unit_course_a02"  aria-labelledby="collapse1" class="collapse"  > <!-- data-parent="#heading_02" -->
                hi i am B001
            </div>

            <div id="collapse2">
                <button data-target="#unit_course_b02" aria-controls="unit_course_b02" class="btn btn-link" data-toggle="collapse"  >
                    B002
                </button>
            </div>
            <div id="unit_course_b02"  aria-labelledby="collapse2" class="collapse"  > <!-- data-parent="#heading_02" -->
                hi i am B002
            </div>

            <div id="collapse3">
                <button data-target="#unit_course_b03" aria-controls="unit_course_b03" class="btn btn-link" data-toggle="collapse" >
                    B003
                </button>
            </div>
            <!--                        <div id="unit_course_b03"  aria-labelledby="collapse3" class="collapse show"有無show，就會看能不能自動展開  data-parent="#heading_02">  把data-parent拿掉，打開B就不會自動把A關起來-->
            <div id="unit_course_b03"  aria-labelledby="collapse3" class="collapse"  d>
                hi i am B003
            </div>
        </div>
    </div>
</div>

<!--<script type="text/javascript" src="follow_mouse.js"></script>-->
<!---->
<!--<div id="cursor" style="position:absolute; z-index:999; visibility: visible;user-select: none">-->
<!--    <img src="圖片2.png">-->
<!--</div>-->
<!--<script type="text/javascript" src="particle.js"></script>-->
<!--<script type="text/javascript" src="love.js"></script>-->
<?php
/*
function get_sub(){
    if(isset($_POST["get_sub"])  ){

        $get_id = $_POST["get_id"];

        $url = 'http://120.110.113.123:3000/api/org.example.empty.student/'.$get_id;
        $get_data = callAPI('GET', $url, false);
        echo '<br>此ID的結果：'.$get_data;
    }
}
*/
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
