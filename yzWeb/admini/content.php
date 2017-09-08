<?php
/**
 * lm
 * news
 * 链接数据库
 * 使用循环取出所有的记录
 * 通过每一条记录取出title字段和所属栏目的ID并判断所属栏目的级别
 * 通过id从栏目表中取出所属栏目名称
 */
session_start();//开启session_start
if ( empty($_SESSION['pass'])) {
    echo "<script > 
        alert('请通过正常渠道登录');
        window.location.href='login.php';
    </script>";
}
header("Content-Type:text/html;charset=utf-8");
require_once("conn.php");

$sql_page="select count(*) from news order by id desc";
$query_page=mysql_query($sql_page);
$res_page=mysql_fetch_array($query_page);//总的记录条数
$page_size=10;
$pagecount=ceil($res_page[0]/$page_size);
//echo$pagecount;exit;
//echo$_GET[page];
//exit;
//接收页数的指并对其进行判断
if(empty($_GET['page'])){
    $page=1;    
}
else{
    if($_GET['page']>$pagecount){
        $page=$pagecount;
    }else if($_GET['page']<1){
        $page=1;
    }else{
        $page=$_GET['page'];
        }
}
//计算偏移值
$offset=($page-1)*$page_size;//计算每一页开始和结束值
$sql_content="select * from news order by id desc limit $offset,$page_size";
$query=mysql_query($sql_content);

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
        <a href="content.php" class="list-group-item active">新闻管理</a>
        <a href="content_post.php" class="list-group-item">发布新闻</a>
        <a href="content_lanmu.php" class="list-group-item">栏目管理</a>
        <a href="content_beifen.php" class="list-group-item">备份数据</a>
        <a href="content_photo.php" class="list-group-item">照片管理</a>
    </div>
</div>
<div class="col-md-10">
<div class="page-header">
    <h1>新闻管理</h1>
</div>
<ul class="nav nav-tabs">
    <li class="active"><a href="content.php">新闻管理</a></li>
    <li><a href="content_post.php">发布新闻</a></li>
    <li><a href="content_lanmu.php">栏目管理</a></li>
    <li><a href="content_beifen.php">备份数据</a></li>
    <li><a href="content_photo.php">照片管理</a></li>
</ul>
<table class="table">
    <thead>
    <tr>
        <th>文章标题</th>
        <th>作者</th>
        <th>所属栏目</th>
        <th>发布时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
<?php
while(@$res=mysql_fetch_array($query)){
?>
    <tr>
        <th scope="row"><?php echo $res['title'];?></th>
        <td><?php echo $res['adduser'];?></td>
        <td><?php    
                    if ($res[lm3]!=0) {
                        $sqllm="select * from lm where id=$res[lm3]";
                       // echo $sqllm;
                        $querylm=mysql_query($sqllm);                        
                        $reslm=mysql_fetch_array($querylm);
                       // var_dump($reslm);
                        $lmname=$reslm[lm3];
                    }
                    elseif ($res[lm2]!=0) {
                       $sqllm="select * from lm where id=$res[lm2]";
                       $querylm=mysql_query($sqllm);
                       $reslm=mysql_fetch_array($querylm);
                       $lmname= $reslm[lm2];
                    }
                    elseif ($res[lm1]!=0) {
                        $sqllm="select * from lm where id=$res[lm1]";
                       // echo $sqllm;
                       $querylm=mysql_query($sqllm);
                       $reslm=mysql_fetch_array($querylm);
                       $lmname= $reslm[lm1];
                    }     
                    echo $lmname;                
                    ?></td>
        <td><?php echo $res['time'];?></td>
        <td>
            <div role="presentation" class="dropdown">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    操作<span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <input type="hidden" name="page" value="<?php echo$page; ?>">
                    <li><a  onclick="return confirm('是否删除');" href="content_del.php?id=<?php echo $res[id];?>&page=<?php echo$page; ?>">删除</a></li>
                    <li><a href=".\content_update.php?id=<?php echo $res[id];?>&lmn=<?php echo $lmname;  ?>&page=<?php echo$page; ?>">编辑</a></li>
                </ul>
            </div>
        </td>
    </tr>
<?php
}
?>    
    </tbody>
</table>
<nav class="pull-right">
    <ul class="pagination">
<?php
 if($page==1){//如果当前页为第一页
?>

        <li class="disabled"><a href="#"><span aria-hidden="true">&laquo;</span></a></li>
        <li><a href="content.php?page=1">1</a></li>
        <li><a href="content.php?page=2">2 </a></li>
        <li><a href="content.php?page=3">3 </a></li>
        <li><a href="content.php?page=4">4 </a></li>
        <li><a href="content.php?page=5">5 </a></li>
        <li><a href="content.php?page=6">6 </a></li>
        <li><a href="content.php?page=<?php echo $page+1; ?>"><span aria-hidden="true">&raquo;</span></a></li>
<?php
        }
        elseif($page==$pagecount){
?>
        <li><a href="content.php?page=<?php echo $page-1; ?>"><span aria-hidden="true">&laquo;</span></a></li>
        <li><a href="content.php?page=1">1</a></li>
        <li><a href="content.php?page=2">2 </a></li>
        <li><a href="content.php?page=3">3 </a></li>
        <li><a href="content.php?page=4">4 </a></li>
        <li><a href="content.php?page=5">5 </a></li>
        <li><a href="content.php?page=6">6 </a></li>
        <li class="disabled"><a href="content.php?page=<?php echo $page+1; ?>"><span aria-hidden="true">&raquo;</span></a></li>
<?php
                }
        else{
?>
        <li><a href="content.php?page=<?php echo $page-1; ?>"><span aria-hidden="true">&laquo;</span></a></li>
        <li><a href="content.php?page=1">1</a></li>
        <li><a href="content.php?page=2">2 </a></li>
        <li><a href="content.php?page=3">3 </a></li>
        <li><a href="content.php?page=4">4 </a></li>
        <li><a href="content.php?page=5">5 </a></li>
        <li><a href="content.php?page=6">6 </a></li>
        <li><a href="content.php?page=<?php echo $page+1; ?>"><span aria-hidden="true">&raquo;</span></a></li>
<?php
}
?>
    </ul>
</nav>
</div>
</div>
</div>
<!--footer-->
<?php require_once('footer.php');?>
<!--footer-->


<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
