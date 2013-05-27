<?php

$arr = array(
    'step1. 登录百度账号',
    '       并访问 http://developer.baidu.com/bae，完成开发者中心的绑定手机等流程',
    '',

    'step2. 创建一个应用',
    '       访问 http://developer.baidu.com/dev#/create，选择web应用即可',
    '       创建完成后，记录下你的三项信息，方便下面流程中使用： 应用ID，API Key，Secret Key',
    '',

    'step3. 域名（代码运行环境域名）',
    '       方案一：BAE上登记一个域名，代码放在BAE上运行',
    '           “云平台” => “云环境(BAE)” => “托管设置”，登入自己的应用域名',  
    '           访问： http://developer.baidu.com/bae/bce/app/create-devappid-${appid}',
    '       方案二：自己拥有域名 or 自己本机调试环境',
    '',

    'step4. 开启应用访问pcs权限',
    '       "开放API" => "API管理" => "API列表"，开启 PCS API，并输入一个本应用在pcs中的应用目录，假设叫做 aaaabbbbcccc',
    '       访问 http://developer.baidu.com/dev#/api/${appid}/list',
    '',

    'step5. OAuth 回调地址白名单',
    '       由于本应用选择的是 OAuth2.0 Authorization Code ,需要去平台提交回调白名单',
    '       按step3中的域名，字符串为 http://${host}/models/oauth_callback.php',
    '       访问：http://developer.baidu.com/dev#/api/${appid}/safe',
    '',

    'step6. 代码配置文件 conf.php',
    '       FILEME_APP_CLIENT_ID：         step2 API Key',
    '       FILEME_APP_CLIENT_SECRET_KEY： step2 Secret Key',
    '       FILEME_BASE_PATH：             step3 应用目录，例如/apps/aaaabbbbcccc/',
    '',

    'step7. 代码部署',
    '       访问本程序 http://${host}/index.php',
    '',
);

echo "<pre>";
foreach($arr as $line){
    echo $line;
    echo "<br>";
}
echo "</pre>";

