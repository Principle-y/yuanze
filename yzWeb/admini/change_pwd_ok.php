<?php
//修改密码php界面

header("Content-Type:text/html;charset=utf-8");
$mima1=$_GET[password];//获取输入的原始密码，和新密码，用户名，验证码
$mima2=$_GET[password1];
$mima3=$_GET[password2];
$user=$_GET[email];
if (!empty($mima2) && !empty($mima3) && !empty($mima1) && !empty($user)) {
require_once("conn.php");
//echo$yz;
//echo$_SESSION['code'];exit;
$sql="select * from admin limit 1";//
$query=mysql_query($sql);
$res=mysql_fetch_array($query);
//var_dump($res);exit;

if ($mima2==$mima3 && $user==$res['admin'] && $mima1==$res['pwd']) {
    $sql="update admin set pwd='$mima2' where admin='$user'";
    //echo$sql;
$query=mysql_query($sql);
//var_dump($query);exit;
   echo "<script >
       alert('密码修改成功');
     window.location.href='index.php';
    </script>";
    exit;
}
}
else{
echo"<script >
        alert('请输入值');
     window.location.href='change_pwd.php';
    </script>";
    exit;
}
?>
