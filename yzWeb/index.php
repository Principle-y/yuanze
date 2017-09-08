 <?php
		
require_once(".\admin\conn.php");
require_once(".\admin\my_class.php");	
/*统计总访客*/
@session_start();  
$counter = intval(file_get_contents("counter.dat"));  
if(!$_SESSION['jingyun'])  
{  
 $_SESSION['jingyun'] = true;  
 $counter++;  
 $fp = fopen("counter.dat","w");  
 fwrite($fp, $counter);  
 fclose($fp);  
}
/*当前在线人数统计*/
$online_log = "count.dat"; //保存人数的文件,
$timeout = 30;//30秒内没动作者,认为掉线
$entries = file($online_log);

$temp = array();

for ($i=0;$i<count($entries);$i++) {
$entry = explode(",",trim($entries[$i]));
if (($entry[0] != $_SERVER["REMOTE_ADDR"]) && ($entry[1] > time())) {
array_push($temp,$entry[0].",".$entry[1]."\n"); //取出其他浏览者的信息,并去掉超时者,保存进$temp
}
}

array_push($temp,$_SERVER["REMOTE_ADDR"].",".(time() + ($timeout))."\n"); //更新浏览者的时间
$users_online = count($temp); //计算在线人数

$entries = implode("",$temp);
//写入文件
$fp = fopen($online_log,"w");
flock($fp,LOCK_EX); //flock() 不能在NFS以及其他的一些网络文件系统中正常工作
fputs($fp,$entries);
flock($fp,LOCK_UN);
fclose($fp);
/*获取新闻函数*/
        function getNews($grade,$id)
        {
            if ($grade=='lm3') {
                 $sql="select * from news where $grade=$id order by id desc limit 12";
                 $query=mysql_query($sql);
            }
            elseif ($grade=='lm2') {
                $sql="select * from news where lm3=0 and $grade=$id order by id desc limit 12 ";
                $query=mysql_query($sql);
            }
            elseif ($grade=='lm1') {
                $sql="select * from news where lm3=0 and lm2=0 and $grade=$id order by id desc limit 12";
				
                //echo$sql;exit;
                $query=mysql_query($sql);
            }
            while($res=mysql_fetch_assoc($query)){
				if(str_width($res['title'])>10){
					$res_title=substr_cn($res['title'],10).'.';
					}
					else{$res_title=$res['title'];}
                echo"<p class='glyphicon glyphicon-pushpin star-icon'><a href='admin/news.php?id=$res[id]&title=$res[title]&user=$res[adduser]&time=$res[time]' class='news' >$res_title</a><i>$res[time]</i></p>";
				
            }
        }
?>

<!DOCTYPE html >
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<!--IE8配置-->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--自适应配置-->
<meta name="viewport" content="width=device-width, initial-scale=1 , user-scalable=no">
<meta name="Keywords" content="袁泽，袁泽的个人网站，宝鸡袁泽，宝鸡文理通信工程,宝鸡文理，宝鸡，个人网站，宝鸡大学，技术博客，个性网站，互联网"/>
<meta name="Description" content="这是袁泽的个人主页!欢迎大家围观！" />

<title>Yuanze的个人网站</title>
<script src="js/jquery-3.1.1.min.js"></script>
<script charset="utf-8">
    $(function(){          var MobileUA = (function() {             
    var ua = navigator.userAgent.toLowerCase();         
    var mua ={                 
         IOS: /ipod|iPhone|ipad/.test(ua), //iOS                  
         IPHONE: /iphone/.test(ua), //iPhone                  
         IPAD: /ipad/.test(ua), //iPad                  
         android: /android/.test(ua), //Android Device                  
         Windows: /windows/.test(ua), //Windows Device                  
         TOUCH_DEVICE: ('ontouchstart' in window) || /touch/.test(ua), //Touch Device                  
         MOBILE: /mobile/.test(ua), //Mobile Device (iPad)                  
         ANDROID_TABLET: false, //Android Tablet                 
         WINDOWS_TABLET: false, //Windows Tablet                
         TABLET: false, //Tablet (iPad, Android, Windows)                
         SMART_PHONE: false //Smart Phone (iPhone, Android)             
    };                   
        mua.ANDROID_TABLET = mua.ANDROID && !mua.MOBILE;            
        mua.WINDOWS_TABLET = mua.WINDOWS && /tablet/.test(ua);  
        mua.TABLET = mua.IPAD || mua.ANDROID_TABLET || mua.WINDOWS_TABLET; 
        mua.SMART_PHONE = mua.MOBILE && !mua.TABLET;                
        return mua;          }());                //SmartPhone        
        if (MobileUA.SMART_PHONE) {              // 移动端链接地址  
            document.location.href = 'yuanze/%E6%89%8B%E6%9C%BA%E7%AB%AF/index.html';          }     
    });
</script>
<link rel="bookmark" type="image/x-icon" href="images/favicon.ico"/>
<link rel="shortcut icon" href="images/favicon.ico"/>
<link rel="icon" href="images/favicon.ico"/>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap_index.css">
<link rel="stylesheet" href="css/animate.css">
</head>

<body style="overflow:-Scroll;overflow-x:hidden">

<!--导航-->
<nav class="navbar navbar-default navbar-fixed-top">
<div class="container">

<!--小屏幕导航按钮和LOGO-->
    <div class="navbar-header">
        <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php"><img class="img-responsive" src="images/logo.gif"/></a>
    </div>  
    <!--小屏幕导航按钮和LOGO-->
    <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
            <li><a class="animBtn themeD" href="#home">首页</a></li>
            <li><a class="animBtn themeD" href="#bbs">前端开发</a></li>
            <li><a class="animBtn themeD" href="#html5">最新动态</a></li>
            <li><a class="animBtn themeD" href="#course">大学生活</a></li>
            <li><a class="animBtn themeD" href="#app">专业简介</a></li>
            <li><a class="animBtn themeD" href="#page">作品赏析</a></li>
            <li><a class="animBtn themeD" href="#contect">与我联系</a></li>
        </ul>
        
</nav>

</div>
<!--导航-->
<!--home-->
<section id="home"> </section>
<!--home-->
<section id="bbs">
	<div class="container">
    	<div class="row wow fadeIn"data-wow-duration="2s" >
        	<div class="col-md-12">
            	<h2><span class="glyphicon glyphicon-leaf"></span>&nbsp;前端掌握</h2>
            </div>  
        	<div class="col-md-4 wow bounceInLeft">
            <a href="http://www.runoob.com/css/css-tutorial.html">
            	<img class="img-responsive" src="images/01.gif"alt=""/>
                <h3>CSS3</h3>
                <p>作为一项新的技术，CSS3.0可以做出来很多好看的效果，学好CSS3.0对找工作是由很大帮助的</p>
            </a>
            </div>
            <div class="col-md-4 wow bounceInDown">
            <a href="http://www.runoob.com/html/html-tutorial.html">
            	<img class="img-responsive" src="images/02.gif" alt=""/>
                <h3>HTML5</h3>
                <p>  HTML5将会取代99年制定的HTML 4.01、XHTML 1.0标准，以期能在互联网应用迅速发展的时候，使网络标准达到符合当代的网络需求，为桌面和移动平台带来无缝衔接的丰富内容。</p>
            </a> 
            </div>
            <div class="col-md-4 wow bounceInRight">
            <a href="http://www.runoob.com/js/js-tutorial.html">
            	<img class="img-responsive" src="images/03.gif" alt=""/>
                <h3>JavaScript</h3>
                <p>JvaScript一种直译式脚本语言，是一种动态类型、弱类型、基于原型的语言，内置支持类型。它的解释器被称为JavaScript引擎，为浏览器的一部分，广泛用于客户端的脚本语言，最早是在HTML（标准通用标记语言下的一个应用）网页上使用，用来给HTML网页增加动态功能。</p> 
            </a>
            </div>
            
        </div>
        <div class="row wow fadeInUp"data-wow-duration="0.5s" >
        	<div class="col-md-4 wow bounceInLeft">
            <a href="http://www.runoob.com/bootstrap/bootstrap-tutorial.html">
            	<img class="img-responsive" src="images/06.gif" alt=""/>
                <h3>Bootstrap</h3>
                <p>Bootstrap 是基于 HTML、CSS、JAVASCRIPT 的，它简洁灵活，使得 Web 开发更加快捷。它由Twitter的设计师Mark Otto和Jacob Thornton合作开发，是一个CSS/HTML框架。Bootstrap提供了优雅的HTML和CSS规范，它即是由动态CSS语言Less写成。</p> 
            </a>
            
            
            </div>
            <div class="col-md-4 wow bounceInUp">
            <a href="http://www.runoob.com/angularjs/angularjs-tutorial.html">
            	<img class="img-responsive" src="images/04.gif"alt=""/>
                <h3>AngularJS</h3>
                <p>AngularJS是为了克服HTML在构建应用上的不足而设计的。HTML是一门很好的伪静态文本展示设计的声明式语言，但要构建WEB应用的话它就显得乏力了。</p> 
            </a>
            
            
            </div>
            <div class="col-md-4 wow bounceInRight">
            <a href="http://www.runoob.com/jquery/jquery-tutorial.html">
            	<img class="img-responsive" src="images/05.gif" alt=""/>
                <h3>Jquery</h3>
                <p>jQuery是一个快速、简洁的JavaScript框架，是继Prototype之后又一个优秀的JavaScript代码库（或JavaScript框架）。jQuery设计的宗旨是“write Less，Do More”，即倡导写更少的代码，做更多的事情。它封装JavaScript常用的功能代码，提供一种简便的JavaScript设计模式，优化HTML文档操作、事件处理、动画设计和Ajax交互。</p>
            </a> 
            </div>
            
        </div>
    </div>
</section>
<!--bbs-->
<!--HTML5-->
<section id="html5">
	<div class="container">
    	<div class="row">
        <div class="col-md-12">
            	<h2 class="row wow fadeIn"><span class="glyphicon glyphicon-leaf"></span>&nbsp;最新动态</h2>
            </div>
        	<div class="col-md-6 col-sm-12 wow fadeInLeft"data-wow-duration="0.8s" >
                <h3>及时更新，最新动态<a href="admin/news_more.php"><i>More</i></a></h3>
                <?php
        getNews('lm1',89);
    ?>
            </div>
            <div class="col-md-6 col-sm-12  wow fadeInRight"data-wow-duration="0.8s" >
            	<embed src='http://player.youku.com/player.php/sid/XMjYxMjAyMzMxNg==/v.swf' allowFullScreen='true' quality='high' width='640' height='400' align='middle' allowScriptAccess='always' type='application/x-shockwave-flash'></embed>

            </div>
        </div>
    </div>
</section>
<!--HTML5-->
<!--bootstrap-->


<!--bootstrap-->
<!--course-->
<section id="course">
	<div class="container">
    	<div class="row wow fadeIn"data-wow-duration="1.5s" >   
        	<div class="col-md-12">
            	<h2><span class="glyphicon glyphicon-leaf"></span>&nbsp;大学生活</h2>
            </div>    	
            <div class="zzsc-container">
	<div class="container mt50">
		<div class="row">
			<div class="col-md-3 col-sm-6">
				<div class="box">
					<img class="img-responsive" src="images/1.jpg" alt="">
					<div class="over-layer">
						<h3 class="title">星星</h3>
						<p class="description">脸如雕刻般五官分明，有棱有角的脸俊美异常。外表看起来好象放荡不拘，但眼里不经意流露出的精光让人不敢小看。一头乌黑茂密的头发，一双剑眉下却是一对细长的桃花眼，充满了多情，让人一不小心就会沦陷进去。高挺的鼻子，厚薄适中的红唇这时却漾着另人目眩的笑容。</p>
					</div>
				</div>
			</div><div class="col-md-3 col-sm-6">
				<div class="box">
					<img class="img-responsive" src="images/2.jpg" alt="">
					<div class="over-layer">
						<h3 class="title">大飞哥</h3>
						<p class="description">眼睛像大海一样的深邃，鼻子英挺，嘴唇性感，你的五官组合起来是那样的俊朗，而且你有着像小麦色那样健康的肤色，给人一种很阳光的感觉。</p>
					</div>
				</div>
			</div>
            <div class="col-md-3 col-sm-6">
				<div class="box">
					<img  class="img-responsive" src="images/3.jpg" alt="">
					<div class="over-layer">
						<h3 class="title">曹杰</h3>
						<p class="description">肤色白皙，五官清秀中带着一抹俊俏，帅气中又带着一抹温柔！他身上散发出来的气质好复杂，像是各种气质的混合，但在那些温柔与帅气中，又有着他自己独特的空灵与俊秀！</p>
					</div>
				</div>
			</div><div class="col-md-3 col-sm-6">
				<div class="box">
					<img class="img-responsive" src="images/4.jpg" alt="">
					<div class="over-layer">
						<h3 class="title">靖博</h3>
						<p class="description">只见他身材伟岸，肤色古铜，五官轮廓分明而深邃，犹如希腊的雕塑，幽暗深邃的冰眸子，显得狂野不拘，邪魅性感。</p>
					</div>
				</div>
			</div>
            <div class="col-md-3 col-sm-6">
				<div class="box">
					<img class="img-responsive" src="images/5.jpg" alt="">
					<div class="over-layer">
						<h3 class="title">宣&超</h3>
						<p class="description">只见他身材伟岸，肤色古铜，五官轮廓分明而深邃，犹如希腊的雕塑，幽暗深邃的冰眸子，显得狂野不拘，邪魅性感。</p>
					</div>
				</div>
			</div><div class="col-md-3 col-sm-6">
				<div class="box">
					<img class="img-responsive" src="images/6.jpg" alt="">
					<div class="over-layer">
						<h3 class="title">鑫德</h3>
						<p class="description">一表人才
玉质金相
英俊潇洒</p>
					</div>
				</div>
			</div>
            <div class="col-md-3 col-sm-6">
				<div class="box">
					<img class="img-responsive" src="images/7.jpg" alt="">
					<div class="over-layer">
						<h3 class="title">李伟</h3>
						<p class="description">立体的五官刀刻般俊美，整个人发出一种威震天下的王者之气，邪恶而俊美的脸上此时噙着一抹放荡不拘的微笑。</p>
					</div>
				</div>
			</div><div class="col-md-3 col-sm-6">
				<div class="box">
					<img class="img-responsive" src="images/8.jpg" alt="">
					<div class="over-layer">
						<h3 class="title">王木木</h3>
						<p class="description">一张坏坏的笑脸，连两道浓浓的眉毛也泛起柔柔的涟漪，好像一直都带着笑意，弯弯的，像是夜空里皎洁的上弦月。白皙的皮肤衬托着淡淡桃红色的嘴唇，俊美突出的五官，完美的脸型，特别是左耳闪着炫目光亮的钻石耳钉，给他的阳光帅气中加入了一丝不羁。</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
        </div>
    </div>
		
			
		</div>
	</div>
</div>    
</section>
<!--course-->
<!--APP-->
<section id="app">
	<div class="container">
    	<div class="row ">
        <div class="col-md-12">
            	<h2 class="row wow fadeIn"><span class="glyphicon glyphicon-leaf"></span>&nbsp;专业简介</h2>
            </div>
        	<div class="col-md-6 col-sm-12  wow bounceInDown">
            	<h3>通信工程</h3>
                <img src="images/txgc.gif" class="img-responsive"/>
                <p>通信工程（也作电信工程，旧称远距离通信工程、弱电工程）是电子工程的一个重要分支，电子信息类子专业，同时也是其中一个基础学科。该学科关注的是通信过程中的信息传输和信号处理的原理和应用。本专业学习通信技术、通信系统和通信网等方面的知识，能在通信领域中从事研究、设计、制造、运营及在国民经济各部门和国防工业中从事开发、应用通信技术与设备！</p>
                
            </div>
            <div class="col-md-6 col-sm-12  wow bounceInUp">
            	<h3>开设课程</h3>
<table class="table table-hover">
    <thead>
    <tr>
        <th>大一</th>
        <th>大二</th>
        <th>大三</th>
        <th>大四</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>高等数学</td>
        <td>电子线路基础</td>
        <td>微机原理</td>
        <td>数字图像处理</td>
    </tr>   
    <tr>
        <td>通信工程导论</td>
        <td>高频电子线路</td>
        <td>通信工程专业英语</td>
        <td>面向对象程序设计</td>
    </tr>   
    <tr>
        <td>大学英语</td>
        <td>信号与系统</td>
        <td>计算机软件技术基础</td>
        <td>移动通信</td>
    </tr>   
    <tr>
        <td>中国近代史纲要</td>
        <td>数据结构</td>
        <td>数字信号处理</td>
        <td>光纤通信</td>
    </tr>   
    <tr>
        <td>大学物理</td>
        <td>EDA技术</td>
        <td>MATLAB教程及应用</td>
        <td>程序交换技术</td>
    </tr>   
    <tr>
        <td>思想道德与法律基础</td>
        <td>电磁场与电磁波</td>
        <td>彩电原理</td>
        <td></td>
    </tr>   
    <tr>
        <td>C语言程序设计</td>
        <td>马克思主义基本原理</td>
        <td>信息论与编码技术</td>
        <td></td>
    </tr>   
    <tr>
        <td>线性代数</td>
        <td>数字逻辑电路</td>
        <td>Java语言程序设计</td>
        <td></td>
    </tr>   
    <tr>
        <td>计算机应用基础</td>
        <td>CAD技术</td>
        <td>单片机原理及应用</td>
        <td></td>
    </tr>   
    <tr>
        <td>大学体育</td>
        <td>大学物理2</td>
        <td>通信原理</td>
        <td></td>
    </tr>   
    </tbody>
</table>
            </div>
        </div>
    </div>
</section>
<!--APP-->

<!--page-->
<section id="page">
	<div class="container">
		<div class="row ">
        <div class="col-md-12">
     <h2 class="row wow fadeIn"><span class="glyphicon glyphicon-leaf"></span>&nbsp;作品赏析</h2>
    </div>
    
			<div class="col-md-4 col-sm-6 wow zoomIn">
            <h4>标准商业网站</h4>
				<div class="box1">
					<div class="box-img">
						<img src="images/wy1.png" alt="">
					</div>
					<div class="box-content">
						<h4 class="title">商业网站</h4>
						<p class="description">运用基础HTML结合CSS搭建的第一个网页</p>						
					</div>
				</div>               
                        <a href="yuanze/网站开发商业界面/index.html" class="btn btn-primary" target="_blank" role="button">点击查看</a>
			</div>

			<div class="col-md-4 col-sm-6 wow zoomIn">
            <h4>Bootstrap网站</h4>
				<div class="box1">
					<div class="box-img">
						<img src="images/wy2.png" alt="">
					</div>
					<div class="box-content">
						<h4 class="title">Bootstrap网站</h4>
						<p class="description">运用Bootstrap集合Jquery搭建的一个网站</p>						
					</div>
				</div>                
                        <a href="yuanze/bootstrap页面/index.html" class="btn btn-primary" target="_blank" role="button">点击查看</a>
			</div>

			<div class="col-md-4 col-sm-6 wow zoomIn">
            <h4>手机端网站</h4>

				<div class="box1">
					<div class="box-img">
						<img src="images/wy3.png" alt="">
					</div>
					<div class="box-content">
						<h4 class="title">手机端网站</h4>
						<p class="description">在手机端显示的一个网站</p>						
					</div>
				</div>
                <a href="yuanze/手机端/index.html"class="btn btn-primary" target="_blank" role="button">点击查看</a>
			</div>
            <div class="col-md-4 col-sm-6 wow zoomIn">
            <h4>响应式网站1</h4>
				<div class="box1">
					<div class="box-img">
						<img src="images/wy4.png" alt="">
					</div>
					<div class="box-content">
						<h4 class="title">响应式网站</h4>
						<p class="description">页面元素随页面大小变化而变化</p>						
					</div>
				</div>
                <a href="yuanze/yuanze/index.html"class="btn btn-primary" target="_blank" role="button">点击查看</a>
			</div>

			<div class="col-md-4 col-sm-6 wow zoomIn">
            <h4>响应式网站2</h4>
				<div class="box1">
					<div class="box-img">
						<img src="images/wy5.png" alt="">
					</div>
					<div class="box-content">
						<h4 class="title">响应式网站</h4>
						<p class="description">页面元素随页面大小变化而变化</p>						
					</div>
				</div>
                <a href="yuanze/liwei/index.html"class="btn btn-primary" target="_blank" role="button">点击查看</a>
			</div>

			<div class="col-md-4 col-sm-6 wow zoomIn">
            <h4>PC端网站第一版</h4>
				<div class="box1">
					<div class="box-img">
						<img src="images/wy6.png" alt="">
					</div>
					<div class="box-content">
						<h4 class="title">PC端网站</h4>
						<p class="description">由yuanze设计页面钱缘同学完成代码部分的网站</p>						
					</div>
				</div>
                <a href="yuanze/index.html" class="btn btn-primary" target="_blank" role="button">点击查看</a>
			</div>
		</div>
	</div>
</section>
<!--page-->
<!--contect-->
<section id="contect">
    <div class="lvjing">
        <div class="container">
            <div class="row">
            <div class="col-md-12">
     <h2 class="row wow fadeIn"><span class="glyphicon glyphicon-leaf"></span>&nbsp;与我联系</h2>
    </div>
                <div class="col-md-6 wow fadeInLeft"data-wow-duration="0.8s" >
                    <p>2016年3月于宝鸡市学苑学习中心学习网页设计，主要学习了前端设计，包括HTML、CSS、JavaScript，还学习了PHP语言，经过一年的学习已经对网页设计有了基本的认识，现可以进行简单的网页设计，后台搭建，如有需要，请与我联系！</p>
                    <address>
                    	<p><span class="glyphicon glyphicon-calendar"></span>&nbsp;&nbsp;地址：宝鸡市宝鸡文理学院老校区</p>
                        <p><span class="glyphicon glyphicon-earphone"></span>&nbsp;&nbsp;联系电话：13636824408</p>
                        <p><span class="glyphicon glyphicon-envelope"></span>&nbsp;&nbsp;邮箱:yz1046304484@qq.com</p>
                        <p><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<a href="admin\login.php">管理员登录</a></p>
                    </address>
                </div>
<div class="col-md-6 wow fadeInRight"data-wow-duration="0.8s" >
                	
                        <div class="col-md-8">
                        	<a href="admin/liuyan.php"><input type="submit" class="form-control" value="留言板"/></a>
                        </div>
                        <div class="col-md-8">
                        	<a href="admin/photo.php"><input type="submit" class="form-control" value="相册"/></a>
                        </div>
			</div>
            <!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare" style="margin:10px 0 0 -4px">
        <a class="bds_tsina"></a>
        <a class="bds_tqq"></a>
        <a class="bds_renren"></a>
        <a class="bds_qzone"></a>
        <a class="bds_douban"></a>
        <a class="bds_xg"></a>
        <span class="bds_more">更多</span>
		<a class="shareCount"></a>
    </div>
<script type="text/javascript" id="bdshare_js" data="type=tools" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
    document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + new Date().getHours
();
</script>
<!-- Baidu Button END -->          
            <div class="img_ col-md-12 ">
            <h2 class="row wow fadeIn"><span class="glyphicon glyphicon-leaf"></span>&nbsp;友情链接</h2>
        	<ul class="list-group">
                <li ><a href="http://www.yangli2017.com/"><img class="img-responsive" src="images/yangli_logo.jpg"/></a></li>
                <li ><a href="http://www.lifan007.com"><img class="img-responsive" src="images/lifan_logo.jpg"/></a></li>
                <li ><a href="#"><img class="img-responsive" src="images/linli_logo.jpg"/></a></li>
                <li ><a href="http://mengyangweb.com/web/index.php"><img class="img-responsive" src="images/mengyang_logo.jpg"/></a></li>
                <li ><a href="http://chenyunvip.com/"><img class="img-responsive" src="images/chenyun_logo.jpg"/></a></li>
                <li ><a href="http://2017chen.com/index.php"><img class="img-responsive" src="images/wangchen_logo.jpg"/></a></li>
                <li ><a href="http://www.wyd2017.com/"><img class="img-responsive" src="images/wangyindan_logo.jpg"/></a></li>
                <li ><a href="http://zhao96e8.com/"><img class="img-responsive" src="images/zhaozhen_logo.jpg"/></a></li>
                
        	</ul>
        </div>
        	</div>       
    	</div>

     </div>    

</section>
<!--contect-->
<!--footer-->
<?php require_once('.\admin\footer.php');?>
<!--footer-->

<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.singlePageNav.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/mymouse.js" id="mymouse"></script>
<!--导航js-->
<script src='js/delaunay.js'></script> 
<script src='js/TweenMax.js'></script>

<script>
const TWO_PI = Math.PI * 2;
var images = [], 
    imageIndex = 0;

var image,
    imageWidth = 1920,
    imageHeight =900;
 
var vertices = [],
    indices = [],
    prevfrag = [],
    fragments = [];

var margin = 50;

var container = document.getElementById('home');

var clickPosition = [imageWidth * 0.5, imageHeight * 0.5];

window.onload = function() {
    TweenMax.set(container, {perspective:500});
    var urls = [
            'images/01.jpg',
            'images/02.jpg',
            'images/03.jpg',
            'images/04.jpg',
        ],
        image,
        loaded = 0;
    images[0] = image = new Image();
        image.onload = function() {
            if (++loaded === 1) {
                
                for (var i = 1; i < urls.length; i++) {
                    images[i] = image = new Image();

                    image.src = urls[i];
                } 
                placeImage();
            }
        };
        image.src = urls[0]; 
};

function placeImage(transitionIn) {
    image = images[imageIndex];

    if (++imageIndex === images.length) imageIndex = 0;
  
    var num = Math.random();
    if(num < .25) {
      image.direction = "left";
    } else if(num < .5) {
      image.direction = "top";
    } else if(num < .75) {
      image.direction = "bottom";
    } else {
      image.direction = "right";
    }

    container.appendChild(image);
    image.style.opacity = 0;
  
    if (transitionIn !== false) {
        triangulateIn();
    }
}

function triangulateIn(event) {
    var box = image.getBoundingClientRect(),
        top = box.top,
        left = box.left;
  
    if(image.direction == "left") {
      clickPosition[0] = 0; 
      clickPosition[1] = imageHeight / 2;
    } else if(image.direction == "top") {
      clickPosition[0] = imageWidth / 2;
      clickPosition[1] = 0;
    } else if(image.direction == "bottom") {
      clickPosition[0] = imageWidth / 2;
      clickPosition[1] = imageHeight;
    } else if(image.direction == "right") {
      clickPosition[0] = imageWidth;
      clickPosition[1] = imageHeight / 2;
    } 
    

    triangulate();
    build();
}

function triangulate() {
    for(var i = 0; i < 40; i++) {      
      x = -margin + Math.random() * (imageWidth + margin * 2);
      y = -margin + Math.random() * (imageHeight + margin * 2);
      vertices.push([x, y]);
    }
    vertices.push([0,0]);
    vertices.push([imageWidth,0]);
    vertices.push([imageWidth, imageHeight]);
    vertices.push([0, imageHeight]);
  
    vertices.forEach(function(v) {
        v[0] = clamp(v[0], 0, imageWidth);
        v[1] = clamp(v[1], 0, imageHeight);
    });
  
    indices = Delaunay.triangulate(vertices);
}

function build() {
    var p0, p1, p2,
        fragment;

    var tl0 = new TimelineMax({onComplete:buildCompleteHandler});

    for (var i = 0; i < indices.length; i += 3) {
        p0 = vertices[indices[i + 0]];
        p1 = vertices[indices[i + 1]];
        p2 = vertices[indices[i + 2]];

        fragment = new Fragment(p0, p1, p2);

        var dx = fragment.centroid[0] - clickPosition[0],
            dy = fragment.centroid[1] - clickPosition[1],
            d = Math.sqrt(dx * dx + dy * dy),
            rx = 30 * sign(dy),
            ry = 90 * -sign(dx),
            delay = d * 0.003 * randomRange(0.9, 1.1);
        fragment.canvas.style.zIndex = Math.floor(d).toString();

        var tl1 = new TimelineMax(); 

        if(image.direction == "left") {
          rx = Math.abs(rx); 
          ry = 0;          
        } else if(image.direction == "top") {
          rx = 0;
          ry = Math.abs(ry);
        } else if(image.direction == "bottom") {
          rx = 0;
          ry = - Math.abs(ry);
        } else if(image.direction == "right") {
          rx = - Math.abs(rx);
          ry = 0;
        } 
        
        tl1.from(fragment.canvas, 1, {
              z:-50,
              rotationX:rx,
              rotationY:ry,
              scaleX:0,
              scaleY:0,
              ease:Cubic.easeIn
         });
        tl1.from(fragment.canvas, 0.4,{alpha:0}, 0.6);
      
        tl0.insert(tl1, delay);

        fragments.push(fragment);
        container.appendChild(fragment.canvas);
    }
}

function buildCompleteHandler() {
    // add pooling?
    image.style.opacity = 1;
    image.addEventListener('transitionend', function catchTrans() {
      fragments.forEach(function(f) {
          container.removeChild(f.canvas);
      });

      fragments.length = 0;
      vertices.length = 0;
      indices.length = 0;

      placeImage();
      this.removeEventListener('transitionend',catchTrans,false);
    }, false);
    
}

//////////////
// MATH UTILS
//////////////

function randomRange(min, max) {
    return min + (max - min) * Math.random();
}

function clamp(x, min, max) {
    return x < min ? min : (x > max ? max : x);
}

function sign(x) {
    return x < 0 ? -1 : 1;
}

//////////////
// FRAGMENT
//////////////

Fragment = function(v0, v1, v2) {
    this.v0 = v0;
    this.v1 = v1;
    this.v2 = v2;

    this.computeBoundingBox();
    this.computeCentroid();
    this.createCanvas();
    this.clip();
};
Fragment.prototype = {
    computeBoundingBox:function() {
        var xMin = Math.min(this.v0[0], this.v1[0], this.v2[0]),
            xMax = Math.max(this.v0[0], this.v1[0], this.v2[0]),
            yMin = Math.min(this.v0[1], this.v1[1], this.v2[1]),
            yMax = Math.max(this.v0[1], this.v1[1], this.v2[1]);

         this.box = {
            x:Math.round(xMin),
            y:Math.round(yMin),
            w:Math.round(xMax - xMin),
            h:Math.round(yMax - yMin)
        };

    },
    computeCentroid:function() {
        var x = (this.v0[0] + this.v1[0] + this.v2[0]) / 3,
            y = (this.v0[1] + this.v1[1] + this.v2[1]) / 3;

        this.centroid = [x, y];
    },
    createCanvas:function() {
        this.canvas = document.createElement('canvas');
        this.canvas.width = this.box.w;
        this.canvas.height = this.box.h;
        this.canvas.style.width = this.box.w + 'px';
        this.canvas.style.height = this.box.h + 'px';
        this.canvas.style.left = this.box.x + 'px';
        this.canvas.style.top = this.box.y + 'px';
        this.ctx = this.canvas.getContext('2d');
    },
    clip:function() {
        this.ctx.save();
        this.ctx.translate(-this.box.x, -this.box.y);
        this.ctx.beginPath();
        this.ctx.moveTo(this.v0[0], this.v0[1]);
        this.ctx.lineTo(this.v1[0], this.v1[1]);
        this.ctx.lineTo(this.v2[0], this.v2[1]);
        this.ctx.closePath();
        this.ctx.clip();
        this.ctx.drawImage(image, 0, 0);
        this.ctx.restore();
    }
};
</script>
<!--导航js结束-->
<script >
	$(function(){
		/*导航点击跳转效果插件*/
		$('.nav').singlePageNav({offset:70});
		/*小屏幕导航点击关闭菜单*/
		$('.navbar-collapse a').click(function(){
			$('.navbar-collapse').collapse('hide');
			});
		new WOW().init();
	})
</script>

</body>
</html>
