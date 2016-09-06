<?php
	session_start();
	//检测是否登录，若没登录则转向登录界面
	if(!isset($_SESSION['userid'])){
		header("Location:login.html");
		exit();
	}
	$uid=$_SESSION['userid'];

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

	include 'conn.php';
	//$rs = mysql_query("select count(*) from case_mmorpg");
	$rs = mysql_query("select count(*) from project left join userproject on project.pid = userproject.pid and userproject.uid='$uid'");
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
	//$rs = mysql_query("select case_mmorpg.cid,cmodel,ccase,cexpect,ctype,cresult,cbug from $pname limit $offset,$rows");
	$rs= mysql_query("select project.pid, project.pname, project.ptime, userproject.status, userproject.status, project.pid,project.pdescription from project left join userproject on project.pid = userproject.pid and userproject.uid='$uid' limit $offset,$rows");
	$items = array();
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}
	$result["rows"] = $items;

	echo json_encode($result);
?>
