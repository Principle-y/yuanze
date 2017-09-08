<?php
require_once('.\conn.php');
session_start();//开启session
if (empty($_SESSION['pass'])) {
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
    	<link rel="stylesheet" href="kindeditor/themes/default/default.css" />
	<link rel="stylesheet" href="kindeditor/plugins/code/prettify.css" />
	<script charset="utf-8" src="kindeditor/kindeditor.js"></script>
	<script charset="utf-8" src="kindeditor/lang/zh_CN.js"></script>
	<script charset="utf-8" src="kindeditor/plugins/code/prettify.js"></script>
	<script>
		KindEditor.ready(function(K) {
			var editor1 = K.create('textarea[name="content1"]', {
				cssPath : 'kindeditor/plugins/code/prettify.css',
				uploadJson : 'kindeditor/php/upload_json.php',
				fileManagerJson : 'kindeditor/php/file_manager_json.php',
				allowFileManager : true,
				afterCreate : function() {
					var self = this;
					K.ctrl(document, 13, function() {
						self.sync();
						K('form[name=example]')[0].submit();
					});
					K.ctrl(self.edit.doc, 13, function() {
						self.sync();
						K('form[name=example]')[0].submit();
					});
				}
			});
			prettyPrint();
		});
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
                <a href="content_post.php" class="list-group-item active">发布新闻</a>
                <a href="content_lanmu.php" class="list-group-item ">栏目管理</a>
                <a href="content_beifen.php" class="list-group-item ">备份数据</a>
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
                <li class="active">
                    <a href="content_post.php">发布新闻</a>
                </li>
                <li>
                    <a href="content_lanmu.php">栏目管理</a>
                </li>
                <li><a href="content_beifen.php">备份数据</a></li>
                <li><a href="content_photo.php">照片管理</a></li>
            </ul>
            <form  method="post" action="content_post_ok.php"class="mar_t15">
                <div class="form-group">
                    <label for="title">标题</label>
                    <input name="title"  type="text" id="title" class="form-control" placeholder="请输入文章标题">
                </div>
                <div class="form-group">
                    <label for="title">作者</label>
                    <input  name="user" type="text" id="title" class="form-control" placeholder="请输入文章作者">
                </div>
                <div class="form-group">
                    <label for="some_name">选择栏目</label>
                    <select  name="lanmu" id="some_name"class="form-control">
						<?php
							$sql="select id,lm1 from lm where lm1!=''";
							$query=mysql_query($sql);
							while($res=mysql_fetch_array($query))
							{
							echo"<option value='$res[id]*0*0'>$res[lm1]</option>";
							$sql1="select id,lm2 from lm where lmid=".$res[id];
							$query1=mysql_query($sql1);
							while($res1=mysql_fetch_array($query1))
							{
							echo" <option value='$res[id]*$res1[id]*0'>　　$res1[lm2]</option>";
							$sql2="select id,lm3 from lm where lmid=".$res1[id];
							$query2=mysql_query($sql2);
							while($res2=mysql_fetch_array($query2))
							{
							echo" <option value='$res[id]*$res1[id]*$res2[id]'>　　　　$res2[lm3]</option>"; 
							}
							}
							}
                        ?>

                    </select>
                </div>
                <div class="form-group">
                    <label for="content">文章内容</label>
                    <textarea  name="content1" id="content" class="form-control" rows="15" cols="10" placeholder="请输入文章正文部分"></textarea>
                </div>
                <div class="checkbox">
                    <button type="submit" class="btn btn-default pull-right">发布文章</button>
                </div>
            </form>

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
