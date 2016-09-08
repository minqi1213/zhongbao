<?php
	session_start();
	$userid = $_SESSION['userid'];
	$mtitle = mysql_escape_string($_POST['pname']);
	$mdescription = mysql_escape_string($_POST['pdescription']);
	$files = $_FILES['application'];
	if($files["size"]>209715200){ //图片大小判断
		echo json_encode(array('msg'=>'文件大小不能超过200M'));
		exit;
	}

	$upload_dir = "applications/"; //upload文件夹
	if(!file_exists($upload_dir)){
        	mkdir($upload_dir); //创建目录 成功则返回true 失败则返回false
	}
	$fname = $files["tmp_name"]; //在服务器临时存储名称a
	if($fname != ""){
		$image_info = getimagesize($fname);
		$name = $files["name"];
		$str_name = pathinfo($name); //以数组的形式返回文件路劲的信息
		$extname = strtolower($str_name["extension"]); //把字符串改为小写 extensiorn扩展名
		$file_name = date("YmdHis").rand(1000,9999).".".$extname;
		$str_file = $upload_dir.$file_name; //文件目录a
		if(!move_uploaded_file($files["tmp_name"],"../".$str_file)){ //将上传的文件移动到新的目录 要移动文件和文件新目录 成功则返回true/    
                	echo json_encode(array('msg'=>'文件上传失败，请稍后重试！'));
                	exit;
        	}
	}
	$str_file = ($str_file!=NULL)?$str_file:"";

	include('conn.php');
	$sql = "INSERT INTO project(cpid,pname,pdescription,binarydata)VALUES('$userid','$mtitle','$mdescription','$str_file')";
	$result = @mysql_query($sql);
	if ($result){
		echo json_encode(array('success'=>true));
	} else {
		echo json_encode(array('msg'=>'操作失败，请稍后尝试'));
	}

?>
