function uploadFile() {
    ajax = getajaxobject();
    var fileObj = document.getElementById("file").files[0]; // 获取文件对象
    fileme_sender_token = document.getElementById("fileme_sender_token").value;


    // FormData 对象
    var form = new FormData();
    form.append("uploadFile", fileObj);                           // 文件对象
    form.append("fileme_sender_token", fileme_sender_token);

    ajax.onreadystatechange = display_upload;
    ajax.timeout = 100000;
    ajax.open("POST", "models/upload.php", true);
    ajax.send(form);

}

function getajaxobject() {
    ajax = null;
    try {
        ajax = new XMLHttpRequest;
    } catch (e) {
        try {
            ajax = new ActiveXObject('Msxml2.XMLHTTP');
        } catch (e) {
            ajax = new ActiveXObject('Microsoft.XMLHTTP');
        }
    }
    return ajax;
}

function display_upload() {
    document.getElementById("display_upload").innerHTML = (ajax.readyState == 4 || ajax.readyState == 'complete') ? ajax.responseText
        : 'loading..';
}

