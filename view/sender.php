<?php
require_once (DIRNAME(__FILE__) . "/header.php");
?>

<div align="center"><h1>您当前访问的是： 文件发送者 </h1></div>

<?php
$arr_sender_token = decode_token($_GET["fileme_sender_token"]);
$access_token_info = json_decode($arr_sender_token["str_access_token_info"], true);
$access_token = $access_token_info["access_token"];
$sender_path = $arr_sender_token["sender_path"];
?>
========================================上传文件====================================================
<br><br>
你的文件将上传至目标用户的 <b style="background-color: #C9FECA"><?php echo $sender_path?> </b>目录<br><br>

上传文件：<input type="file" id="file" name="uploadFile"/><br>
<input type="button" onclick="uploadFile()" value="上传"/>
<input type='hidden' id="fileme_sender_token" name='fileme_sender_token'
       value="<?php echo $_GET["fileme_sender_token"]?>"/><br>
<div id="display_upload" style="background-color: #C9FECA"></div>

<br><br>
========================================已上传文件====================================================
<br><br>
<table id='taskDetailTable' class="ae-table ae-table-striped">
    <thead>
    <tr>
        <th width="20%" id="h_filesize">
            <p class="header02"><span>文件名称</span></p>
        </th>
        <th width="20%" id="h_filetype">
            <p class="header03"><span>文件上传时间</span></p>
        </th>
    </tr>
    </thead>
    <tbody width="100%" id="fileDetailTableBody">

    <?php
    $baidu_pcs = new BaiduPCS($access_token);
    $response = $baidu_pcs->listFiles($sender_path);
    $response = json_decode($response, true);

    foreach ($response["list"] as $record) {
        if (0 === $record["isdir"]) {
            $path = $record["path"];
            $ctime = date("Y-m-d H:i", $record["ctime"]);

            echo "<tr class=\"ae-even\">";
            echo "<td>$path</td>";
            echo "<td>$ctime</td>";
            echo "</tr>";
        }
    }

    ?>
    </tbody>
</table>

</body>
</html>
