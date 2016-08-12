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
// 判断action
$userid = $_SESSION['userid'];
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : ''; 
if($action=='accept'){
	$userid=$_POST['userid'];
	$projectid=$_POST['projectid'];
	include('conn.php');
	$accept_query=("INSERT INTO userproject(uid, pid, status) VALUES('$userid','$projectid','1')");
	if(mysql_query($accept_query,$conn)){
		echo'<script language="JavaScript">window.alert("接取任务进行中，请等待审核"),location.href="my.php";</script>'; 
	} else {
		echo'<script language="JavaScript">window.alert("抱歉！接取任务失败，请尝试其他项目"),location.href="my.php";</script>';  
	}
	header('location:my.php');  
    	exit();  
}

//包含数据库连接文件
include('conn.php');
$username = $_SESSION['username'];
$user_query = mysql_query("select * from user where uid=$userid limit 1");
$row = mysql_fetch_array($user_query);
echo '用户信息：<br />';
echo '用户ID：',$userid,'<br />';
echo '用户名：',$username,'<br />';
echo '邮箱：',$row['email'],'<br />';
echo '注册日期：',date("Y-m-d", $row['regdate']),'<br />';
echo '<a href="login.php?action=logout">注销</a><br />';
if($_SESSION['role']=='cp'){
	require('missions_cp.php');
}else if ($_SESSION['role']=='engineer'){
	require('missions_engineer.php');
}
?>
<?php
  require('footer.php');
?>
