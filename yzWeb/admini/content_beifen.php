<?php
/**
 * lm
 * news
 * 链接数据库
 * 使用循环取出所有的记录
 * 通过每一条记录取出title字段和所属栏目的ID并判断所属栏目的级别
 * 通过id从栏目表中取出所属栏目名称
 */
session_start();//开启session
header("Content-Type:text/html;charset=utf-8");
require_once("conn.php");
if ( empty($_SESSION['pass'])) {
    echo "<script > 
        alert('请通过正常渠道登录');
        window.location.href='login.php';
    </script>";
}
ini_set("memory_limit","1024M");
error_reporting(E_ALL & ~ E_NOTICE);//显示 E_NOTICE 之外的所有错误信息 
global $mysqlhost, $mysqluser, $mysqlpwd, $mysqldb;
$mysqlhost="103.48.169.21";    //host name
$mysqluser="a0304141922";               //login name
$mysqlpwd="dc07e110";                //password
$mysqldb="a0304141922";          //name of database
include("my_class.php");
$d=new db($mysqlhost,$mysqluser,$mysqlpwd,$mysqldb);//创建了一个数据库操作对象
/*----------------------------------------------------界面----------------------------------------------*/
if(!$_POST['act']){//没提交备份之前，界面显示 
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1 , user-scalable=no">
    <title>Yuanze后台管理系统</title>

<link rel="bookmark" type="image/x-icon" href="images/favicon.ico"/>
<link rel="shortcut icon" href="images/favicon.ico"/>
<link rel="icon" href="images/favicon.ico"/>

    <link rel="stylesheet" href="css/bootstrap.min.new.css"/>
    <link rel="stylesheet" href="css/bootstrap-maizi.css"/>
</head>
<body>
<!--导航-->
<?php require_once("header.php");?>
<!--导航-->

<div class="container">
<div class="row">
<div class="col-md-2">
    <div class="list-group">
        <a href="content.php" class="list-group-item">新闻管理</a>
        <a href="content_post.php" class="list-group-item">发布新闻</a>
        <a href="content_lanmu.php" class="list-group-item">栏目管理</a>
        <a href="content_beifen.php" class="list-group-item active">备份数据</a>
        <a href="content_photo.php" class="list-group-item">照片管理</a>
    </div>
</div>
<div class="col-md-10">
<div class="page-header">
    <h1>新闻管理</h1>
</div>
<ul class="nav nav-tabs">
    <li><a href="content.php">新闻管理</a></li>
    <li><a href="content_post.php">发布新闻</a></li>
    <li><a href="content_lanmu.php">栏目管理</a></li>
    <li class="active"><a href="content_beifen.php">备份数据</a></li>
    <li><a href="content_photo.php">照片管理</a></li>
</ul>
<form name="form1" method="post" action="content_beifen.php">
<div class="form-group">
                <input  type="radio" name="bfzl" value="quanbubiao">备份全部数据
            </div>
<div class="form-group">        
        <input type="radio" name="bfzl" value="danbiao">备份单张表数据
        <select class="form-control" name="tablename">
            <option  value="">请选择</option>
            <?
    $d->query("show table status from $mysqldb");//show table status from 查看表的引擎类型等状态信息：
    while($d->fetch_row_array()){//mysql_fetch_array 获取记录集啊
    echo "<option  value='".$d->row_array_index('Name')."'>".$d->row_array_index('Name')."</option>";}
    ?>
        </select>
        <input class="pull-right  btn btn-default" type="submit" name="act" value="go">
</form>
</div>
<?
}else{
/*----------------------------------------------------主程序--------------------------------------------*/

    /*/////////////////////////////////////备份全部表/////////////////////////////////////-*/
    if($_POST['bfzl']=="quanbubiao"){
$tables=$d->query("show table status from $mysqldb"); //SHOW TABLE STATUS命令来获取每个数据表的信息
$sql="";
while($d->fetch_row_array($tables))//返回一个record结果集
{
    $table=$d->row_array_index("Name");//获取表的名字
    $sql.=creat_table_sql($table);//获取创建表的sql语句(creat table开始的地方)
    $d->query("select * from $table");//查找表中所有的记录
    $num_fields=$d->num_field();//返回结果集中字段的数目
    while($d->fetch_row_array())//生成插入数据的sql语句
    {
        $sql.=insert_table_date_sql($table,$num_fields);
    }
}
$filename=date("Ymd",time())."_all.sql";
if($_POST['act']=="go")
{
    if(write_file($sql,$filename))
        $msgs[]="全部数据表数据备份完成,生成备份文件'./backup/$filename'";
else 
         $msgs[]="备份全部数据表失败";
show_msg($msgs);
exit();        
    }
}
/*/////////////////////////////////////备份单表//////////////////////////////////////////////*/
elseif($_POST['bfzl']=="danbiao"){
if(!$_POST['tablename'])
{
    $msgs[]="请选择要备份的数据表"; show_msg($msgs);
    exit();
}
$sql=creat_table_sql($_POST['tablename']);
$d->query("select * from ".$_POST['tablename']);
$num_fields=$d->num_field();
while($d->fetch_row_array())//mysql_fetch_array()
{
    $sql.=insert_table_date_sql($_POST['tablename'],$num_fields);
}
    $filename=date("Ymd",time())."_".$_POST['tablename'].".sql";
    if($_POST['act']=="go")
    {
        if(write_file($sql,$filename))
        $msgs[]="表-".$_POST['tablename']."-数据备份完成,生成备份文件'./backup/$filename'";
        else $msgs[]="备份表-".$_POST['tablename']."-失败";
        show_msg($msgs);
        exit();
    }
}
else{
    echo "<script type='text/javascript' charset='utf-8'>
        alert('请选择数据备份方式!');
        window.location.href='content_beifen.php';
    </script>";
}
}
/*-----------------------------------------主程序结束--------------------------------------------*/

/*
 *
 *向文件写sql语句
 */
function write_file($sql,$filename)
{
    $re=true;
    mysql_query("set names utf8");
    if(!create_folder('backup'))//创建文件夹
    {
        exit;
    }
if(!@$fp=fopen("./backup/".$filename,"w+")) {$re=false; echo "failed to open target file";}
if(!@fwrite($fp,$sql)) {$re=false; echo "failed to write file";}
if(!@fclose($fp)) {$re=false; echo "failed to close target file";}
return $re;
}

function down_file($sql,$filename)
{
ob_end_clean();//b_end_clean — 清空（擦除）缓冲区并关闭输出缓冲
header("Content-Encoding: none");
header("Content-Type: ".(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'application/octetstream' : 'application/octet-stream'));
  
header("Content-Disposition: ".(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'inline; ' : 'attachment; ')."filename=".$filename);
  
header("Content-Length: ".strlen($sql));
header("Pragma: no-cache");
  
header("Expires: 0");
echo $sql;
$e=ob_get_contents();//得到缓存取的数据
ob_end_clean();
}
/*
 *
 *创建目录
 */
function create_folder($dir)
{

if(!is_dir($dir)) {
@mkdir($dir, 0777);//0777是文件夹的操作权限
}

if(is_dir($dir))
{

if($fp = @fopen("$dir/test.test", 'w'))
    {
@fclose($fp);
@unlink("$dir/test.test");
$create_folder = 1;
}
else {
$create_folder = 0;
}

}

return $create_folder;

}
/*
 *返回创建表的sql语句
 * creat_table_sql   
 */
function creat_table_sql($table)
{
    global $d;
//如果表存在则先删除
$sql="DROP TABLE IF EXISTS ".$table.";\n";//1.让后边这个封号害惨了! <删除表>
//显示用于创建给定表的CREATE TABLE语句。本语句对视图也起作用。
$d->query("show create table ".$table);
$d->fetch_row_array();
//把匹配到的换行全部替换成了空字符串
$tmp=preg_replace("/\n/","",$d->row_array_index("Create Table"));
$sql.=$tmp.";\n";//2.想想，为什么这儿要加一个封号 <创建表>
return $sql;
}

/*
 *
 *组合插入sql语句   insert_table_date_sql
 */
function insert_table_date_sql($table,$num_fields)
{
    global $d; 
    $comma="";
    $sql .= "INSERT INTO ".$table." VALUES(";
    for($i = 0; $i < $num_fields; $i++)
    {
         //mysql_escape_string 转 义字符串  和mysql_real_escape_string 完全一样 
        $sql .= ($comma."'".mysql_escape_string($d->record[$i])."'"); $comma = ",";
    }
    $sql .= ");\n";//3.让后边这个封号害惨了…… <表中插入数据>
    return $sql;
}
/*
 *表格形式输出提示
 *
 */
function show_msg($msgs)
{

    $title="提示：";
    echo "<table width='100%' border='1'    cellpadding='0' cellspacing='1'>";
    echo "<tr><td>".$title."</td></tr>";
    echo "<tr><td><br><ul>";
    while (list($k,$v)=each($msgs))
    {//each — 返回数组中当前的键／值对并将数组指针向前移动一步
    echo "<li>".$v."</li>";
    }
    echo "</ul></td></tr></table>";
}
/*
 *  退出代码
 */
?>


<!--footer-->
<?php require_once('footer.php');?>
<!--footer-->


<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
