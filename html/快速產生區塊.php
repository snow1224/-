<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<!--CSS寫在head中   JS寫在body中-->
<body>
<hr>
<h2>POST</h2>

<form name="post_input" method="post" action="./v1_get_post_put_delete.php">
    請輸入你的ID：
    <input type="text" name="post_id" size="10">(輸入範例 410528651)<br><br>
    請輸入你的名字：
    <input type="text" name="post_name" size="10">(輸入範例 王大雪)<br><br>
    請輸入你的信箱：
    <input type = "text" name = "post_email" size="10">(輸入範例 s1052865@pu.edu.tw)<br><br>
    請輸入你的部門編號：
    <input type = "text" name = "post_department" size="10">(輸入範例 001)<br><br>

    <input type="submit" name="post_sub" size="5" value="確定">
</form>
<?php

    post_sub();
?>
<hr>

<h2>GET</h2>

<form name="get_input" method="post" action="./v1_get_post_put_delete.php">
    請輸入你想查詢的ID資料：
    <input type="text" name="get_id" size="10">(輸入範例 410528651)<br><br>

    <input type="submit" name="get_sub" size="5" value="確定">
</form>
<?php
    get_sub();
?>
<hr>

<h2>PUT</h2>
<form name="put_input" method="post" action="./v1_get_post_put_delete.php">
    請輸入你想修改哪個ID的資料：
    <input type="text" name="put_id" size="10">(輸入範例 410528651)<br><br>

    <input type="submit" name="put_sub" size="5" value="確定">
</form>
<?php
put_sub();
?>
<hr>

<h2>DELETE</h2>
<form name="delete_input" method="post" action="./v1_get_post_put_delete.php">
    請輸入你想刪除哪個ID的資料：
    <input type="text" name="delete_id" size="10">(輸入範例 410528651)<br><br>

    <input type="submit" name="delete_sub" size="5" value="確定">
</form>
<?php
delete_sub();

?>
<hr>
<?php


function put_sub(){
    if(isset($_POST["put_sub"]) ){
        $put_id = $_POST["put_id"];
        $get_data = put_get_sub($put_id);
        $response = json_decode($get_data, true);

        $data_array =  array(
            "id"               => $response["id"],
            "name"             => $response["name"],
            "email"            => $response["email"],
            "department"       => $response["department"],
        );

        echo '<form name="put_before_input" method="post" action="./v1_for_put.php">';
        echo '你的ID：'.$data_array["id"].'<br><br>';
        echo '請輸入要修改成啥名字：';
        echo '<input type="text" name="put_before_name" size="10" value="'.$data_array["name"].'">(輸入範例 王大雪)<br><br>';
        echo '請輸入要修改成啥信箱：';
        echo '<input type = "text" name = "put_before_email" size="10" value="'.$data_array["email"].'">(輸入範例 s1052865@pu.edu.tw)<br><br>';
        echo '請輸入要修改成啥部門編號：';
        echo '<input type = "text" name = "put_before_department" size="10" value="'.substr($data_array["department"],strpos($data_array["department"],"#")+1,strlen($data_array["department"])).'">(輸入範例 001)<br><br>';

        echo '<input type="submit" name="put_before_sub" size="5" value="確定">';
        echo '</form> ';

    }
}


function post_sub(){
    if(isset($_POST["post_sub"]) ){

        $post_id = $_POST["post_id"];
        $post_name = $_POST["post_name"];
        $post_email = $_POST["post_email"];
        $post_department = "resource:org.example.empty.department#".$_POST["post_department"];

        $data_array =  array(
            "id"               => $post_id,
            "name"             => $post_name,
            "email"            => $post_email,
            "department"       => $post_department,
        );

        $make_call = callAPI('POST', 'http://120.110.113.123:3000/api/org.example.empty.student', json_encode($data_array));
        $response = json_decode($make_call, true);
        echo "<script> alert('恭喜新增成功');</script>";
    }
}
function get_sub(){
    if(isset($_POST["get_sub"])  ){

        $get_id = $_POST["get_id"];

        $url = 'http://120.110.113.123:3000/api/org.example.empty.student/'.$get_id;
        $get_data = callAPI('GET', $url, false);
        echo '<br>此ID的結果：'.$get_data;
    }
}
function put_get_sub($put_id){

    $url = 'http://120.110.113.123:3000/api/org.example.empty.student/'.$put_id;
    $get_data = callAPI('GET', $url, false);
    return $get_data;

}
function delete_sub(){
    if(isset($_POST["delete_sub"])  ){

        $delete_id = $_POST["delete_id"];
        echo "<br>刪除 ".$delete_id." 資料成功";
        $url = 'http://120.110.113.123:3000/api/org.example.empty.student/'.$delete_id;
        $delete_id = callAPI('DELETE', $url, false);


    }
}
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

function settlement_credit(){
    $stu_id = "abc";
    $url = 'http://120.110.113.123:3000/api/org.example.empty.select_record?filter={"where":"student":"resource:org.example.empty.student#"'.student.id.'"}';
    echo $url;
}
?>

</body>
