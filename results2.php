<?php
//包含数据库连接文件
header("Content-type:text/html;charset=utf-8");
session_start();
$userid = $_SESSION['userid'];

include('conn.php');

$result = mysql_query("select bug.bid,bug.btitle,bug.bid, bug.btime,user.username from bug, userproject,user where userproject.pid=bug.pid and userproject.uid='$userid' and bug.uid=user.uid order by bug.btime asc"); //执行SQL查询指令
echo "<table border=1, width=100%><tr>";
echo "<td width=10%>&nbsp;"."bug编号"."&nbsp;</td>";
echo "<td width=30%>&nbsp;"."标题"."&nbsp;</td>";
echo "<td width=10%>&nbsp;"."详情"."&nbsp;</td>";
echo "<td width=25%>&nbsp;"."提交时间"."&nbsp;</td>";
echo "<td width=25%>&nbsp;"."提交人"."&nbsp;</td>";
echo"</tr>";
$tempid=1;
while($rows = mysql_fetch_row($result)){//使用while遍历所有记录，并显示在表格的tr中
	echo "<tr>";
	for($i = 0; $i < count($rows); $i++)
		if($i == 2){
			echo "<td><a href=\"detail.php?id=".$rows[$i]."\">详情</a></td>";	
		} else if ($i==0){
			echo "<td>&nbsp;".$tempid."</td>";
		}  else {
			echo "<td>&nbsp;".$rows[$i]."</td>";
		}
	$tempid++;
}
echo "</tr></table>";

?>
