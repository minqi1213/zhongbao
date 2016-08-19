<?php

$cid = intval($_REQUEST['cid']);
$cresult = $_REQUEST['cresult'];
$cbug = $_REQUEST['cbug'];

include 'conn.php';

//$sql = "update users set firstname='$firstname',lastname='$lastname',phone='$phone',email='$email' where id=$id";
$sql = "update case_mmorpg set cresult='$cresult',cbug='$cbug' where cid=$cid";


$result = @mysql_query($sql);
if ($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('msg'=>mysql_error()));
}
?>
