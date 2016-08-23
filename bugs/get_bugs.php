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
	$pname = isset($_POST['pname']) ? strtolower("case_".trim($_POST['pname'])):"";
	$projectid = isset($_POST['projectid']) ? intval($_POST['projectid']):0;
	$isuser = isset($_POST['isuser']) ? intval($_POST['isuser']):0;
	$keyword = isset($_POST['keyword'])? trim($_POST['keyword']):"";
	
	//search query keyword and project user
	$query_keyword = "";
	if($keyword == ""){
		$query_keyword = "";
	} else {
		$arr = preg_split('/[\n\r\t\s]+/i', $keyword);
		for ($i=0;$i<count($arr);$i++){
			$query_keyword = $query_keyword."(bug.btitle like '%$arr[$i]%' or bug.bdescription like '%$arr[$i]%') and ";
		}
	}
	$query_user= ($isuser==1)? " and bug.uid="."$userid" : '';
	$query_project = ($projectid==0)? '' : " and bug.pid="."$projectid";


	include 'conn.php';
	//$rs = mysql_query("select count(*) from case_mmorpg");
	$rs = mysql_query("select count(*) from bug, userproject,user where ".$query_keyword."userproject.pid=bug.pid and userproject.uid='$uid'".$query_user."$query_project"." and bug.uid=user.uid order by bug.btime asc");
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
	//$rs = mysql_query("select case_mmorpg.cid,cmodel,ccase,cexpect,ctype,cresult,cbug from $pname limit $offset,$rows");
	$rs= mysql_query("select bug.bid,bug.btitle, bug.btime,user.username from bug, userproject,user where ".$query_keyword."userproject.pid=bug.pid and userproject.uid='$uid'".$query_user."$query_project"." and bug.uid=user.uid order by bug.btime asc limit $offset,$rows");
	$items = array();
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}
	$result["rows"] = $items;
	echo json_encode($result);
?>

