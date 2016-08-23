<?php

$conn = @mysql_connect('101.200.179.166','sunnytest','sunnytest123');
if (!$conn) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db('zhongbao', $conn);

?>
