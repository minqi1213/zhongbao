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

define('ROOT',dirname(__FILE__).'/');

$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$mtitle = mysql_escape_string($_POST['missiontitle']);
$mdescription = mysql_escape_string($_POST['missiondesc']);

//var_dump($btitle);
//var_dump($bdescription);
//var_dump(ROOT.$str_file);

//$pname = $_POST['projectname'];
//包含数据库连接文件
//包含数据库连接文件
include('conn.php');

//写入数据
//$password = MD5($password);
$sql = "INSERT INTO project(cpid,pname,pdescription)VALUES('$userid','$mtitle','$mdescription')";
if(mysql_query($sql,$conn)){
	exit('任务提交成功！点击此处 <a href="home.php">返回首页</a>'); 
} else {
	echo '抱歉！添加数据失败：',mysql_error(),'<br />';
	echo '点击此处 <a href="javascript:history.back(-1);">返回</a> 重试';
}

?>

