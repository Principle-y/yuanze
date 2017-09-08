<?php
require_once(".\conn.php");
require_once("my_class.php");
$id=intval($_GET['id']);
$title=$_GET['title'];
$user=$_GET['user'];
$time=$_GET['time'];
//echo$id;exit;
$sql="select * from news where id=$id";
$query=mysql_query($sql);
$res=mysql_fetch_array($query);
$res['count']++;
$count=$res['count'];
$sql="update news set count='$count' where id='$id'";
    $query=mysql_query($sql);
//echo$res['count'];exit;
/*统计总访客*/
@session_start();  
$counter = intval(file_get_contents("counter.dat"));  
if(!$_SESSION['news'])  
{  
 $_SESSION['news'] = true;  
 $counter++;  
 $fp = fopen("counter.dat","w");  
 fwrite($fp, $counter);  
 fclose($fp);  
}
function getText($id)
{
$sql="select * from news where id=$id";
$query=mysql_query($sql);
$res=mysql_fetch_array($query);
$res['count']++;
echo$res['content'];
}
function getNews($grade,$id)
        {
            if ($grade=='lm3') {
                 $sql="select * from news where $grade=$id order by id desc";
                 $query=mysql_query($sql);
            }
            elseif ($grade=='lm2') {
                $sql="select * from news where lm3=0 and $grade=$id order by id desc ";
                $query=mysql_query($sql);
            }
            elseif ($grade=='lm1') {
                $sql="select * from news where lm3=0 and lm2=0 and $grade=$id order by id desc ";
				
                //echo$sql;exit;
                $query=mysql_query($sql);
            }
            while($res=mysql_fetch_assoc($query)){
				if(str_width($res['title'])>8){
					$res_title=substr_cn($res['title'],8).'...';
					}
					else{$res_title=$res['title'];}
                echo"<p class='glyphicon glyphicon-pushpin star-icon'><a href='news.php?id=$res[id]&title=$res[title]&user=$res[adduser]&time=$res[time]' class='news' >$res_title</a></p></br><span>$res[time]</span>";
				
            }
        }

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1 , user-scalable=no">
    <title>Yuanze的个人网站/新闻</title>   

<link rel="bookmark" type="image/x-icon" href="images/favicon.ico"/>
<link rel="shortcut icon" href="images/favicon.ico"/>
<link rel="icon" href="images/favicon.ico"/>

 
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-maizi.css"/>
<style >
.bg{background:url(images/whiteBg1.png) repeat;
}

</style>
</head>
<body>
<!--导航-->

<!--导航-->
<div class="container">
<img class="img-responsive" src=".\images\banner1.jpg"/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default ">
                <div class="panel-heading ">
                  <div class="search d7">
                  <b class="pad mar_t15">当前位置：\<a href="../index.php">首页</a>\<a href="news.php">新闻</a></b>
                </div>
            </div>
                
                <div class="panel-body">
                    <div class="media well">
                    <div class="col-md-2">

                <?php
        getNews('lm1',89);
    ?>
                    </div>
                    <div class="col-md-10 bg media-right">
                        <h1 class="text-center"><?php echo $title;?></h1>
                        <h3 class="text-right">作者：<?php echo $user;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i><?php echo $time;?> </i></h3>
                        <div class="row">
                            <div class="col-md-1">
                            </div>
                            
                            <div class="col-md-10">
                                <p class="pad suojing"><?php getText($id);?></p>
                            </div>
                            <div class="col-md-1">
                            </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!--footer-->
<?php require_once('footer.php');?>
<!--footer-->

<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/Chart.js"></script>
<script src="js/script.js"></script>
<script src="js/LiuYanZiShuXianZhi.js"></script>
<script src="fabuliuyan.js"></script>
</body>
</html>
