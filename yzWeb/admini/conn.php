<?php
$conn=mysql_connect("103.48.169.25","a0304141922","dc07e110") or die(mysql_error("数据库 服务器链接失败"));
mysql_select_db("a0304141922",$conn) or die(mysql_error("数据库 服务器链接失败"));
mysql_query("set names utf8");
?>