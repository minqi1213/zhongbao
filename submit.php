<?php
header("Content-type:text/html;charset=utf-8");
session_start();
//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.html");
	exit();
}

if(!isset($_POST['submit'])){
	exit('非法访问!');
}

$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$btitle = $_POST['bugtitle'];
$bdescription = $_POST['bugdesc'];
$image = mysql_escape_string(file_get_contents($_FILES['photo']['tmp_name']));  
$type = $_FILES['photo']['type'];

var_dump($btitle);
var_dump($bdescription);
var_dump($image);
var_dump($type);
//$pname = $_POST['projectname'];
//包含数据库连接文件
//包含数据库连接文件
include('conn.php');

//写入数据
//$password = MD5($password);
$sql = "INSERT INTO bug(uid,pid,btitle,bdescription,type,binarydata)VALUES('$userid',1,'$btitle','$bdescription','$type','$image')";
if(mysql_query($sql,$conn)){
	exit('bug提交成功！点击此处 <a href="home.php">返回首页</a>');
} else {
	echo '抱歉！添加数据失败：',mysql_error(),'<br />';
	echo '点击此处 <a href="javascript:history.back(-1);">返回</a> 重试';
}

?>

