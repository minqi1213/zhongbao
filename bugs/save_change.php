<?php
session_start();
$userid = $_SESSION['userid'];
$bproject = $_POST['projectselect_displaybug'];
$bid = $_POST['bid'];
$btitle = trim($_POST['btitle']);
$bdescription = trim($_POST['bdescription']);
$type1 = $_FILES['photo1']['type'];
$type2 = $_FILES['photo2']['type'];
//图片保存
$files1 = $_FILES["photo1"];
$files2 = $_FILES["photo2"];
if($files1["size"]>2097152 || $files2["size"]>2097152){ //图片大小判断
	echo json_encode(array('msg'=>'图片大小不能超过2M'));
	exit;
}

$upload_dir = "upload/"; //upload文件夹
if(!file_exists($upload_dir)){
        mkdir($upload_dir); //创建目录 成功则返回true 失败则返回false
}
//图片1
$fname1 = $files1["tmp_name"]; //在服务器临时存储名称a
if($fname1 != ""){
	$image_info1 = getimagesize($fname1);
	$name1 = $files1["name"];
	$str_name1 = pathinfo($name1); //以数组的形式返回文件路劲的信息
	$extname1 = strtolower($str_name1["extension"]); //把字符串改为小写 extensiorn扩展名
	$file_name1 = date("YmdHis").rand(1000,9999).".".$extname1;
	$str_file1 = $upload_dir.$file_name1; //文件目录a
	if(!move_uploaded_file($files1["tmp_name"],"../".$str_file1)){ //将上传的文件移动到新的目录 要移动文件和文件新目录 成功则返回true/    
                echo json_encode(array('msg'=>'图片上传失败，请稍后重试！'));;
                exit;
        }
}
//图片2
$fname2 = $files2["tmp_name"]; //在服务器临时存储名称
if($fname2 != ""){
	$image_info2 = getimagesize($fname2);
	$name2 = $files2["name"];
	$str_name2 = pathinfo($name2); //以数组的形式返回文件路劲的信息
	$extname2 = strtolower($str_name2["extension"]); //把字符串改为小写 extensiorn扩展名
	$file_name2 = date("YmdHis").rand(1000,9999).".".$extname2;
	$str_file2 = $upload_dir.$file_name2; //文件目录	
	if(!move_uploaded_file($files2["tmp_name"],"../".$str_file2)){ //将上传的文件移动到新的目录 要移动文件和文件新目录 成功则返回true/    
		echo json_encode(array('msg'=>'图片上传失败，请稍后重试！'));;
        	exit;
	}
}
$str_file1 = ($str_file1!=NULL)?$str_file1:"";
$str_file2 = ($str_file2!=NULL)?$str_file2:"";
$query_photo1 = ($str_file1 == "")?"":",binarydata='$str_file1'";
$query_photo2 = ($str_file2 == "")?"":",binarydata2='$str_file2'";

include('conn.php');
//$sql = "INSERT INTO bug(uid,pid,btitle,bdescription,type,binarydata,binarydata2)VALUES('$userid','$bproject','$btitle','$bdescription','$type1','$str_file1','$str_file2')";
$sql = "UPDATE bug SET btitle='$btitle',bdescription='$bdescription',pid='$bproject'".$query_photo1.$query_photo2." where bid=$bid";
$result = @mysql_query($sql);
if ($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('msg'=>'Some errors occured.'));
}
?>
