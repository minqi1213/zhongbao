<?php
header("Content-type:text/html;charset=utf-8");
/*****************************
*数据库连接
*****************************/
$conn = @mysql_connect("101.200.179.166","sunnytest","sunnytest123");
if (!$conn){
	die("连接数据库失败：" . mysql_error());
}
mysql_select_db("zhongbao", $conn);
//字符转换，读库
mysql_query("set character set 'utf8'");
//写库
mysql_query("set names 'utf8'");
?>
