<?php
header("Content-type:text/html;charset=utf-8");
session_start();

//注销登录
if(is_array($_GET)&&count($_GET)>0){
	if($_GET['action'] == "logout"){
		unset($_SESSION['userid']);
		unset($_SESSION['username']);
		echo '注销登录成功！点击此处 <a href="login.html">登录</a>';
		exit;
}

}

//登录
if(!isset($_POST['submit'])){
	exit('非法访问!');
}
$username = htmlspecialchars($_POST['username']);
$password = MD5($_POST['password']);
$role = $_POST['role'];

//包含数据库连接文件
//include('conn.php');
$conn = @mysql_connect("101.200.179.166","sunnytest","sunnytest123");
if (!$conn){
	die("连接数据库失败：" . mysql_error());
}
mysql_select_db("zhongbao", $conn);
//字符转换，读库
mysql_query("set character set 'gbk'");
//写库
mysql_query("set names 'gbk'");
//检测用户名及密码是否正确
if ($role == 'engineer'){
	$check_query = mysql_query("select uid from user where username='$username' and password='$password' limit 1");
} else if ($role == 'cp'){
	$check_query = mysql_query("select cpid from cp where cpname='$username' and password='$password' limit 1");
}

if($result = mysql_fetch_array($check_query)){
	//登录成功
	$_SESSION['username'] = $username;
	$_SESSION['role'] = $role;
	if($role == 'engineer'){
		$_SESSION['userid'] = $result['uid'];
		echo $username.' 工程师，欢迎您！进入 <a href="home.php">首页</a><br />';
	} else if ($role == 'cp'){
		$_SESSION['userid'] = $result['cpid'];
		echo $username.' 开发商，欢迎您！进入 <a href="home.php">首页</a><br />';
	}
	echo '点击此处 <a href="login.php?action=logout">注销</a> 登录！<br />';
	var_dump($_SESSION);
	exit;
} else {
	exit('登录失败！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
}
?>
