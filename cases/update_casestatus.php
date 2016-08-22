<?php
	session_start();
        //检测是否登录，若没登录则转向登录界面
        if(!isset($_SESSION['userid'])){
                header("Location:login.html");
                exit();
        }
        $uid=$_SESSION['userid'];


$cid = intval($_REQUEST['cid']);
$cresult = $_REQUEST['cresult'];
$cbug = $_REQUEST['cbug'];
$pid = intval($_REQUEST['pid']);


include 'conn.php';

//$sql = "update users set firstname='$firstname',lastname='$lastname',phone='$phone',email='$email' where id=$id";
//$sql = "update case_mmorpg set cresult='$cresult',cbug='$cbug' where cid=$cid";
$sql = "update usercase set cresult='$cresult',cbug='$cbug' where cid=$cid and pid=$pid and uid=$uid";

$result = @mysql_query($sql);
if ($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('msg'=>mysql_error()));
}
?>
