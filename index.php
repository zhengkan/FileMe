<?php
/*
 * 本程序使用 OAuth2.0 Authorization Code 模式
 *
 * fileme_manager_token : 若存在 fileme_manager_token，加载管理界面
 * fileme_sender_token  : 若存在 fileme_sender_token , 加载上传界面
 * code                 : 凭借authorize code 换取 access_token
 * access_token         : 真是访问用户pcs空间凭证
 */
require_once("./conf.php");

if (!isset($_GET["fileme_manager_token"]) && !isset($_GET["fileme_sender_token"]) && !isset($_GET["access_token"])) {
    redirect_baidu_authorize();
}

if (isset($_GET["fileme_manager_token"])) {
    require_once("./view/manager.php");
    exit();
}

if (isset($_GET["fileme_sender_token"])) {
    require_once("./view/sender.php");
    exit();
}


function redirect_baidu_authorize() {
    $base_uri = BAIDU_OAUTH20_AUTHORIZE_URI;
    $arr_query_string = array(
        "client_id" => FILEME_APP_CLIENT_ID,
        "response_type" => "code",
        "scope" => "netdisk",
        "redirect_uri" => "http://" . HTTP_HOST . "/models/oauth_callback.php",
    );
    $query_string = arr_to_query_string($arr_query_string);

    $redirct_uri = $base_uri . "?" . $query_string;
    echo $redirct_uri;

    header("Location:$redirct_uri");
    exit();
}

