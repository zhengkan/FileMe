<?php
/*
 * 本程序使用 OAuth2.0 Authorization Code 模式
 *
 * code                 : 凭借authorize code 换取 access_token
 * access_token         : 真是访问用户pcs空间凭证
 */
require_once(DIRNAME(__FILE__) . "/../conf.php");

if (isset($_GET["code"])) {
    //get access_token by Authorization Code
    $access_token_info = get_access_token_info_by_authorization_code($_GET["code"]);
    
    //make fileme manager token by access_token
    $arr_manager_token = array(
        "str_access_token_info" => $access_token_info
    );
    $str_manager_token = encode_token($arr_manager_token);

    //302 back to manager page
    header("Location:http://" . HTTP_HOST . "/index.php?fileme_manager_token=$str_manager_token");
}else{
    echo "There is no authorization code.";
    exit();
}

function get_access_token_info_by_authorization_code($authorize_code) {
    $arr_query_string = array(
        "grant_type" => "authorization_code",
        "code" => $authorize_code,
        "client_id" => FILEME_APP_CLIENT_ID,
        "client_secret" => FILEME_APP_CLIENT_SECRET_KEY,
        "redirect_uri" => "http://" . HTTP_HOST . "/models/oauth_callback.php"
    );

    $response = send_http_request(BAIDU_OAUTH20_TOKEN_URI, $arr_query_string, "POST");

    $arr_response = json_decode($response, true);
    if(isset($arr_response["error"])){
        echo $response;
        exit();
    }
    return $response;
}
