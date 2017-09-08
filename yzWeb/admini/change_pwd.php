<?php
session_start();//开启session
if ( empty($_SESSION['pass'])) {
    echo "<script > 
        alert('请通过正常渠道登录');
        window.location.href='login.php';
    </script>";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Yuanze 后台管理系统/修改密码</title>
        <!-- The stylesheet -->

<link rel="bookmark" type="image/x-icon" href="images/favicon.ico"/>
<link rel="shortcut icon" href="images/favicon.ico"/>
<link rel="icon" href="images/favicon.ico"/>

        <link rel="stylesheet" href="assets/css/styles.css" />
    </head>
    
    <body>

        <div id="main">
        	
        	<h1>Change Password!</h1>
        	
        	<form action="change_pwd_ok.php" method="get">
        		
        		<div class="row email">
	    			<input type="text" id="email" name="email" placeholder="Email" />
        		</div>
        		<div class="row pass">
        			<input type="password" id="password" name="password" placeholder="Password(old)" />
        		</div>
        		<div class="row pass">
        			<input type="password" id="password1" name="password1" placeholder="Password(new)" />
        		</div>
        		
        		<div class="row pass">
        			<input type="password" id="password2" name="password2" placeholder="Password (repeat)" disabled="true" />
        		</div>
        		
        		<!-- The rotating arrow -->
        		<div class="arrowCap"></div>
        		<div class="arrow"></div>
        		
        		<p class="meterText">Password Meter</p>
        		
        		<input type="submit" value="Register" />
        		
        	</form>
        </div>
        
        <script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
		<script src="assets/js/jquery.complexify.js"></script>
		<script src="assets/js/script.js"></script>
		     
    </body>
</html>
