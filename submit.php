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
$btitle = $_POST['bugtitle'];
$bdescription = $_POST['bugdesc'];
$image = mysql_escape_string(file_get_contents($_FILES['photo']['tmp_name']));  
$type = $_FILES['photo']['type'];

//图片保存
$files =$_FILES["photo"];
if($files["size"]>2097152){ //图片大小判断
	echo "上传图片不能大于2M";
	echo "<meta http-equiv='REFRESH' CONTENT='1;URL=submit.html'>";
	exit;
}
$fname = $files["tmp_name"]; //在服务器临时存储名称
$image_info = getimagesize($fname);
$name = $files["name"];
$str_name = pathinfo($name); //以数组的形式返回文件路劲的信息
$extname = strtolower($str_name["extension"]); //把字符串改为小写 extensiorn扩展名
$upload_dir = "upload/"; //upload文件夹
$file_name = date("YmdHis").rand(1000,9999).".".$extname;
$str_file = $upload_dir.$file_name; //文件目录

//var_dump($btitle);
//var_dump($bdescription);
//var_dump(ROOT.$str_file);

//$pname = $_POST['projectname'];
//包含数据库连接文件
//包含数据库连接文件
include('conn.php');

//写入数据
//$password = MD5($password);
$sql = "INSERT INTO bug(uid,pid,btitle,bdescription,type,binarydata)VALUES('$userid',1,'$btitle','$bdescription','$type','$str_file')";
if(mysql_query($sql,$conn)){
	if(!file_exists($upload_dir)){
		mkdir($upload_dir); //创建目录 成功则返回true 失败则返回flase
	}
	if(!move_uploaded_file($files["tmp_name"],$str_file)){ //将上传的文件移动到新的目录 要移动文件和文件新目录 成功则返回true
		echo "图片上传失败";
		exit('图片上传失败！点击此处 <a href="home.php">返回首页</a>');
	} else{
		//echo "<img src=".$str_file.">";
		echo "图片上传成功";
		exit('bug提交成功！点击此处 <a href="home.php">返回首页</a>'); 
	}
} else {
	echo '抱歉！添加数据失败：',mysql_error(),'<br />';
	echo '点击此处 <a href="javascript:history.back(-1);">返回</a> 重试';
}

?>

