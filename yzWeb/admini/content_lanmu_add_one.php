<?php
require_once("conn.php");
print_r($_POST);

if (!empty($_POST[gradeone])) 
{
    $sql1="insert into lm(lm1) values('$_POST[gradeone]')";
$sql1="INSERT INTO  `lm` (  `id` ,  `lm1` ,  `lm2` ,  `lm3` ,  `lmid` ) 
VALUES (
NULL ,  '$_POST[gradeone]',  '',  '',  '0'
)";

    $query=mysql_query($sql1);
   if($query){
	if(mysql_insert_id()>0){
	 header("Location:content_lanmu.php"); 
            }
}else{
	echo "sql语句执行失败啦!";
}
    //echo $sql1;var_dump($query);exit;
 //   header("Location:content_lanmu.php"); 
}
else{
echo "插入失败";
// header("Location:content_lanmu.php"); 
}
?>

