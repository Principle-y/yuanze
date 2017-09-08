<?php
header("Content-Type:text/html;charset=utf-8");
require_once("conn.php");
$id=intval($_GET['id']);//intval 防注入
$page=$_GET['page'];
$sql="delete from news where id=$id";
$query=mysql_query($sql);
if (mysql_affected_rows()>0) {
header("Location:content.php?page=$page"); 
}
?>
