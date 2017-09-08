<?php
/**
 *功能：把提交的内容入库
 *1.接值
 *2.准备数据（验证，切割grade）
 *3.进行插入操作
 */
header("Content-Type:text/html;charset=utf-8");
require_once('conn.php');
/*封装跳转函数*/
/*封装跳转函数结束*/
//print_r($_POST);exit;
$titlt=$_POST['title'];
$option=$_POST['lanmu'];
$user=$_POST['user'];
$content=$_POST['content1'];
$str=explode('*',$option);//explode(separator,string,limit)  php切割字符串函数，separator必需。规定在哪里分割字符串。string 必需。要分割的字符串。 limit 可选。规定所返回的数组元素的最大数目。 
date_default_timezone_set("PRC");//设置时区为中国
$time=date("Y-m-d H:i:s");
if (!empty($titlt)&&!empty($user)&&!empty($content)) {
$sql="INSERT INTO  `news` (  `id` ,  `lm1` ,  `lm2` ,  `lm3` ,  `title` ,  `content` ,  `time` ,  `hit` ,  `adduser` ,  `count` ) 
VALUES (
NULL ,  '$str[0]',  '$str[1]',  '$str[2]',  '$titlt',  '$content',  '$time',  '0',  '$user',  '0'
)";
    $query=mysql_query($sql);
    //secho $sql; var_dump($query);exit;
if (mysql_insert_id()>0) {
    header("Location:content.php");
    exit;
}
else {
   echo"<script >
alert('新闻发布失败!!!!!!');
window.location.href='content_post.php';
</script>";
exit;
}
}
else {
   echo"<script >
alert('新闻发布失败...');
window.location.href='content_post.php';
</script>";

exit;
}
?>
