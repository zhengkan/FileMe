<?php
require_once(DIRNAME(__FILE__) . "/../conf.php");

$task_name = $_POST["task_name"];
$arr_manager_token = decode_token($_POST["str_manager_token"]);
$access_token_info = json_decode($arr_manager_token["str_access_token_info"], true);
$access_token = $access_token_info["access_token"];
$baidu_pcs = new BaiduPCS($access_token);

$response = $baidu_pcs->makeDirectory(FILEME_BASE_PATH . $task_name);
$arr_response = json_decode($response, true);

if (isset($arr_response["error_code"])) {
    echo json_encode(
        array(
            "status" => 1,
            "content" => "添加任务失败" . $response,
        )
    );
}else{
    echo json_encode(
        array(
            "status" => 0,
            "content" => "添加任务成功",
        )
    );
}

