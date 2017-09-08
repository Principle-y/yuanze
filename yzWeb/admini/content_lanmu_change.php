<?php
header("Content-Type:text/html;charset=utf-8");
require_once(".\conn.php");
$name=$_POST['xiugai'];
$nameh=$_POST['xiugaih'];
$idh=$_POST['idxh'];
$sql="update lm set $name='$nameh' where id='$idh'";
//echo$sql;
mysql_query($sql);
 header("Location:content_lanmu.php?page=$page");
//var_dump(mysql_query($sql));exit;
?>
