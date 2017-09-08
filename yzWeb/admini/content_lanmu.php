<?php
session_start();//开启session
require_once('.\conn.php');
if ( empty($_SESSION['pass'])) {
    echo "<script >
        alert('请通过正常渠道登录');
        window.location.href='login.php';
    </script>";
}
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
    <script>
function tan()
{

    if (window.confirm('你确定要删除吗？？')) {
        return true;
    }
    return false;
}
    </script>
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
        <a href="content_lanmu.php" class="list-group-item active">栏目管理</a>
        <a href="content_beifen.php" class="list-group-item">备份数据</a>
        <a href="content_photo.php" class="list-group-item">照片管理</a>
    </div>
</div>
<div class="col-md-10">
<div class="page-header">
    <h1>新闻管理</h1>
</div>
<ul class="nav nav-tabs">
    <li>
        <a href="content.php">新闻管理</a>
    </li>
    <li>
        <a href="content_post.php">发布新闻</a>
    </li>
    <li class="active">
        <a href="content_lanmu.php">栏目管理</a>
    </li>
    <li><a href="content_beifen.php">备份数据</a></li>
    <li><a href="content_photo.php">照片管理</a></li>
</ul>
                <form class="form-group pad0" action="content_lanmu_add_one.php" method="post">
                    <div class="col-md-10">
                        <input type="text" class="form-control" placeholder="添加一级栏目" name="gradeone">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-default">添加</button>
                    </div>
                </form>
<?php
if(!empty($_GET['gradeone1'])){
?>
<form action="content_lanmu_add_one_child.php" method="post" class="form-group pad0">
<div class="col-md-10" >
    <input placeholder="<?php echo$_GET['parentlm'];?>添加子栏目为"type="text"class="form-control" name="gradeone12">
    <input type="hidden" name="parentid" value="<?php echo$_GET['parentid']?>">
    <input type="hidden" name="gradeone1" value="<?php echo$_GET['gradeone1']?>">
</div>
<div class="col-md-2">
    <button type="submit" class="btn btn-default">添加</button>
    <a href='content_lanmu.php'>取消</a>
</div>

</form>
<?php
}if(!empty($_GET['lm'])){
?>
<form action="content_lanmu_change.php" method="post" class="form-group pad0">    
<input type="hidden" name="idxh" value="<?php echo$_GET['idx'];?>">
<input type="hidden" name="xiugai" value="<?php echo$_GET['lm'];?>">
<div class="col-md-10" >
    <input  placeholder="<?php echo$_GET['name'];?>修改为" type="text" class="form-control" name="xiugaih">
</div>
<div class="col-md-2">
<button type="submit" class="btn btn-default">修改</button>
<a href='content_lanmu.php.php'>取消</a>
</div>
</form>
<?php
}
?>
<table class="table">
    <thead>
    <tr>
        <th>一级栏目</th>
        <th>二级栏目</th>
        <th>三级栏目</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <?php 
//////////////////////获取栏目显示////////////////////////////
//1.取出一级栏目
$sql="select lm1 ,id from lm where lm1!=''";
$query=mysql_query($sql);
while($res=mysql_fetch_array($query))
{
    ?>
    <td><?php echo $res['lm1'];?></td>
    <td></td>
    <td></td>
    <td>
            <div role="presentation" class="dropdown">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    操作<span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <?php
                        echo"<li><a href='content_lanmu_del.php?id=$res[id]&lmd=lm1' onclick='return tan()'>删除</a></li>
                    <li><a href='content_lanmu.php?name=$res[lm1]&idx=$res[id]&lm=lm1'>编辑</a></li>
                    <li><a href='content_lanmu.php?parentlm=$res[lm1]&parentid=$res[id]&gradeone1=lm2'>添加下一级</a></li>"
                    ?>
                </ul>
            </div>
    </td>
</tr>
<?php
    //取出当前一级栏目下的所有二级栏目
    $sql1="select lm2,id from lm where lmid=".$res['id'];
    $query1=mysql_query($sql1);
    while(@$res1=mysql_fetch_array($query1))
    {
?>
    <td></td>
    <td><?php echo $res1['lm2'];?></td>    
    <td></td>
    <td>
            <div role="presentation" class="dropdown">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    操作<span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
              <?php
                  echo"<li><a href='content_lanmu_del.php?id=$res1[id]&lmd=lm2' onclick='return tan()'>删除</a></li>
                    <li><a href='content_lanmu.php?name=$res1[lm2]&idx=$res1[id]&lm=lm2'>编辑</a></li>
                    <li><a href='content_lanmu.php?parentlm=$res1[lm2]&parentid=$res1[id]&gradeone1=lm3'>添加下一级</a></li>";
              ?>
                    
                </ul>
            </div>
    </td>
</tr>
<?php


     //取出当前一级栏目下的所有二级栏目
    $sql2="select lm3,id from lm where lmid=".$res1['id'];
    $query2=mysql_query($sql2);
    while(@$res2=mysql_fetch_array($query2))
    {
?>
    <td></td>
    <td></td>    
    <td><?php echo$res2['lm3']; ?></td>
    <td>
            <div role="presentation" class="dropdown">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    操作<span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                <?php
                    echo"<li><a href='content_lanmu_del.php?id=$res2[id]&lmd=lm3 ' onclick='return tan()'>删除</a></li>
                    <li><a href='content_lanmu.php?name=$res2[lm3]&idx=$res2[id]&lm=lm3'>编辑</a></li>";
                ?>                    
                </ul>
            </div>
    </td>
</tr>
<?php
}
}
}

 ?>
    </tbody>
</table>

</div>
</div>
</div>
<!--footer-->
<?php require_once("footer.php");?>
<!--footer-->


<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
