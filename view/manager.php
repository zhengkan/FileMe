<?php
require_once (DIRNAME(__FILE__) . "/header.php");
?>

<div align="center"><h1>您当前访问的是： 文件接受者（个人云空间管理界面）</h1></div>

========================================添加新任务====================================================
<pre>
定义一个上传任务名称，该任务名作为目录名，将本任务中上传的文件组织在该目录下<br>
</pre>
<form method="post" id="add_task">
    任务名称：<input type='text' id="task_name" name='task_name'/><br>
    <input type='hidden' id="str_manager_token" name='str_manager_token'
           value="<?php echo $_GET["fileme_manager_token"]?>"/><br>
    <input type="submit" value="创建">
</form>

========================================任务列表====================================================
<table id='taskDetailTable' class="ae-table ae-table-striped">
    <thead>
    <tr>
        <th width="15%" id="task_name_list">
            <p class="header02"><span>任务名称</span></p>
        </th>
        <th width="20%" id="task_dir">
            <p class="header02"><span>任务目录</span></p>
        </th>
        <th width="15%" id="task_ctime">
            <p class="header03"><span>创建时间</span></p>
        </th>
        <th width="15%" id="netdisk_url">
            <p class="header04"><span>任务详情</span></p>
        </th>
        <th width="20%" id="sender_url">
            <p class="header04"><span>文件上传页面（请右键“复制链接地址”，并提供给上传人员）</span></p>
        </th>
    </tr>
    </thead>
    <tbody width="100%" id="taskDetailTableBody">

    <?php
    $arr_manager_token = decode_token($_GET["fileme_manager_token"]);
    $access_token_info = json_decode($arr_manager_token["str_access_token_info"], true);
    $access_token = $access_token_info["access_token"];
    $baidu_pcs = new BaiduPCS($access_token);

    $response = $baidu_pcs->listFiles(FILEME_BASE_PATH);
    $response = json_decode($response, true);
    if (isset($response["error_code"]) && 110 === $response["error_code"]) {
        header("Location : http://" . HTTP_HOST . "/index.php");
        exit();
    }

    if(!empty($response["list"])){
        foreach ($response["list"] as $record) {
            if (1 === $record["isdir"]) {
                $path = $record["path"];
                $task_name = str_replace(FILEME_BASE_PATH, "", $record["path"]);
                $ctime = date("Y-m-d H:i", $record["ctime"]);
                $netdisk_uri = "http://pan.baidu.com/disk/home#dir/path=" . rawurlencode($path);

                $arr_fileme_sender_token = array();
                $arr_fileme_sender_token["str_access_token_info"] = $arr_manager_token["str_access_token_info"];
                $arr_fileme_sender_token["sender_path"] = $path;
                $str_fileme_sender_token = encode_token($arr_fileme_sender_token);
                $upload_uri = "http://" . HTTP_HOST . "/index.php?fileme_sender_token=$str_fileme_sender_token";
                echo "<tr class=\"ae-even\">";
                echo "<td>$task_name</td>";
                echo "<td>$path</td>";
                echo "<td>$ctime</td>";
                echo "<td><a href=\"$netdisk_uri\" target=\"_blank\">百度网盘传送门</a></td>";
                echo "<td><a href=\"$upload_uri\" target=\"_blank\"> 上传链接 </a></td>";
                echo "</tr>";
            }
        }
    }

    ?>
    </tbody>
</table>
</body>
</html>
<br><br>
<script type="text/javascript">
    var Q = jQuery;
    var validateLoginForm = function () {
        var task_name = Q("#task_name").val();
        if (task_name == "") {
            return "任务名不能为空！";
        }
        return "";
    }

    Q("#add_task").submit(function () {
        var res = validateLoginForm();
        if (res) {
            alert(res);
            return false;
        }
        var url = "/models/add_task.php";
        var data = {
            task_name:Q("#task_name").val(),
            str_manager_token:Q("#str_manager_token").val()

        }
        var callback = function (msg) {
            if (msg.status == -1) {
                alert(msg.content);
                return;
            } else if (msg.status == 0) {
                alert(msg.content);
                window.location.reload();
                return;
            } else {
                alert("Unknown error!");
                window.location.reload();
            }
        }
        jQuery.ajax({
            type:'POST',
            url:url,
            data:data,
            dataType:'json',
            success:callback,
            error:function (xhr) {
                if (xhr.status != 201 && xhr.status != 200) {
                    alert('添加失败, 请稍后再试');
                    window.location.reload();
                    return false;
                }
            }
        });

        return false;
    });
</script>
