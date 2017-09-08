<?php
//删除逻辑见面
header("Content-Type:text/html;charset=utf-8");
require_once("conn.php");
$ID=$_GET[id];//获取要删除照片的id
$page=$_GET[page];
$sql="delete from img where id='$ID'";
$query=mysql_query($sql);
//5.判断删除是否成功    mysql_affected_rows()
    if (mysql_affected_rows()>0) {
        header("location:content_photo.php?page=$page");
        exit;
    }
    else {
       header("location:content_photo.php?page=$page");
        exit;
    }
?>
