<?php
/*
 *功能：添加传送过来的二级栏目和三级栏目到数据库
 *栏目名，栏目级别（lm2 lm3）
 * */
header("Content-Type:text/html;charset=utf-8");
//var_dump($_POST['gradeone1']);exit;
require_once("conn.php");
$parentid=$_POST['parentid'];
$gradeone1=$_POST['gradeone1'];
$gradeone12=$_POST['gradeone12'];
//echo"4568";
/*echo $parentid;
echo $gradeone1;
echo $gradeone12;exit;*/
if (!empty($gradeone12)) 
{
    if ($gradeone1=='lm2') {
         $sql1="INSERT INTO `lm` ( `id` , `lm1` , `lm2` , `lm3` , `lmid` ) 
    VALUES (
 NULL , '', '$gradeone12', '', '$parentid'
)"; 
    }
    if ($gradeone1=='lm3') {
        $sql1="INSERT INTO `lm` ( `id` , `lm1` , `lm2` , `lm3` , `lmid` ) 
    VALUES (
 NULL , '', '', '$gradeone12', '$parentid'
)"; 
    }
   
    //$sql1="INSERT INTO  `lm` (  `$gradeone1` ,  `lmid`) VALUES ('$gradeone12',  '$parentid')";
    //$sql="insert into lm($gradeone1,lmid) values('$gradeone12','$parentid')";
$query=mysql_query($sql1);
//echo$sql1;var_dump($query);exit;
    header("Location:content_lanmu.php"); 
}
else{
  header("Location:content_lanmu.php"); 
}
?>
