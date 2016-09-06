<?php
	session_start();
	//检测是否登录，若没登录则转向登录界面
	if(!isset($_SESSION['userid'])){
		header("Location:login.html");
		exit();
	}
	$bid = isset($_POST['bid']) ? trim($_POST['bid']):"";
	include('./conn.php');
 	$items=array();
        $rs=mysql_query("select bid,pid,uid,btitle,bdescription,uid,binarydata,binarydata2 from bug where bid=$bid");
        while($row=mysql_fetch_object($rs)){
        	array_push($items , $row);
        }
        $result['rows']=$items;
	if(count($items)==0){
		echo "$.messager.show({
			title: '错误！',
			msg: '此bug不存在'
		});return;";
	} else {
       		echo json_encode($result);}
?>
