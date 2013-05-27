<?php
require_once(DIRNAME(__FILE__) . "/libs/pcs/BaiduPCS.class.php");

define(BAIDU_OAUTH20_TOKEN_URI, "https://openapi.baidu.com/oauth/2.0/token"); //百度OAuth2.0授权服务，用于提取access_token
define(BAIDU_OAUTH20_AUTHORIZE_URI, "https://openapi.baidu.com/oauth/2.0/authorize"); //百度用户对应用授权，授权服务地址
define(HTTP_HOST, $_SERVER["HTTP_HOST"]);

function decode_token($str_token) {
    return json_decode(trim(decrypt($str_token, FILEME_APP_TOKEN_DES_KEY)), true);
}

function encode_token($arr_token) {
    return rawurlencode(encrypt(json_encode($arr_token), FILEME_APP_TOKEN_DES_KEY));
}

function encrypt($encrypt, $key = "") {
    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
    $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt, MCRYPT_MODE_ECB, $iv);
    $encode = base64_encode($passcrypt);
    return $encode;
}

function decrypt($decrypt, $key = "") {
    $decoded = base64_decode($decrypt);
    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
    $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_ECB, $iv);
    return $decrypted;
}

function arr_to_query_string($arr) {
    $query_string = "";
    foreach ($arr as $key => $value) {
        $query_string = empty($query_string) ? "" : $query_string . "&";
        $query_string .= $key . "=" . rawurlencode($value);
    }
    return $query_string;
}

function send_http_request($base_uri, $arr_query_string = array(), $http_method = 'GET', $headers = array(), $body = NULL) {
    $method = strtoupper($http_method);
    $query_string = arr_to_query_string($arr_query_string);

    $url = $base_uri . "?" . $query_string;

    $requestCore = new RequestCore ();
    $requestCore->set_request_url($url);

    $requestCore->set_method($method);
    $requestCore->set_body($body);

    foreach ($headers as $key => $value) {
        $requestCore->add_header($key, $value);
    }

    $requestCore->send_request();
    $result = $requestCore->get_response_body();

    return $result;
}
