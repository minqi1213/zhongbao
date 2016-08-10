<?php
session_start();
if(!isset($_SESSION['userid'])){
	require('header.php');
} else {
	if($_SESSION['role']=='cp'){
		require('header_cp.php');
	} else if ($_SESSION['role']=='engineer'){
		require('header_login.php');
	}
}
  
?>
  <!-- page content -->
  <p>欢迎来到SunnyTest众包服务平台。
	请花一些时间来了解我们。</p>
  <p>我们专注于服务手游测试。欢迎加入我们。</p>
<?php
  require('footer.php');
?>

