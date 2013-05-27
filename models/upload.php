<?php
require_once(DIRNAME(__FILE__) . "/../conf.php");

$arr_sender_token = decode_token($_REQUEST["fileme_sender_token"]);
$access_token_info = json_decode($arr_sender_token["str_access_token_info"], true);
$sender_path = $arr_sender_token["sender_path"];
$access_token = $access_token_info["access_token"];


if (!isset($_FILES) || !is_array($_FILES) || !isset($_FILES["uploadFile"]) || !is_array($_FILES["uploadFile"])) {
    echo "You did not upload file or upload file not named by 'uploadFile'";
    header("status:400");
    exit(0);
}
$file_name = $_FILES["uploadFile"]["name"];
$file_loc = $_FILES["uploadFile"]["tmp_name"];
$file_type = $_FILES["uploadFile"]["type"];


$baidu_pcs = new BaiduPCS($access_token);
$file_content = file_get_contents($file_loc);
$response = $baidu_pcs->upload($file_content, $sender_path . "/", $file_name);
$response = json_decode($response, true);

if (isset($response["error_code"])) {
    echo "上传失败<br>";
    echo "请检查，是否文件重复上传";
} else {
    echo "上传成功";
}

