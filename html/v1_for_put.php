<?php
put_before_sub();
    function put_before_sub(){

        if(isset($_POST["put_before_sub"])){
            $name = $_POST["put_before_name"];
            $email = $_POST["put_before_email"];
            $department = 'resource:org.example.empty.department#'.$_POST["put_before_department"];
            $data_array =  array(

                "name"             => $name,
                "email"            => $email,
                "department"       => $department,

            );
            $put_url = 'http://120.110.113.123:3000/api/org.example.empty.student/abc';
            $update_plan = callAPI('PUT', $put_url, json_encode($data_array));
            header("Location:v1_get_post_put_delete.php");
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
//    if(!$result){die("Connection Failure!!!!!");}
    curl_close($curl);
    return $result;
}
?>