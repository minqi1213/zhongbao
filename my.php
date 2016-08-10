<?php
header("Content-type:text/html;charset=utf-8");
session_start();

//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.html");
	exit();
}
if(!isset($_SESSION['userid'])){
	require('header.php');
} else {
	if($_SESSION['role']=='cp'){
		require('header_cp.php');
	}else if ($_SESSION['role']=='engineer'){
		require('header_login.php');
	}
}

//包含数据库连接文件
include('conn.php');
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$user_query = mysql_query("select * from user where uid=$userid limit 1");
$row = mysql_fetch_array($user_query);
echo '用户信息：<br />';
echo '用户ID：',$userid,'<br />';
echo '用户名：',$username,'<br />';
echo '邮箱：',$row['email'],'<br />';
echo '注册日期：',date("Y-m-d", $row['regdate']),'<br />';
echo '<a href="login.php?action=logout">注销</a><br />';
?>
<?php
  require('footer.php');
?>
