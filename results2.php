<?php
//包含数据库连接文件
header("Content-type:text/html;charset=utf-8");
include('conn.php');

$result = mysql_query("select bug.btitle, bug.bid,bug.btime, user.username from bug left join user on bug.uid = user.uid"); //执行SQL查询指令
echo "<table border=1, width=100%><tr>";
echo "<td width=40%>&nbsp;"."标题"."&nbsp;</td>";
echo "<td width=10%>&nbsp;"."详情"."&nbsp;</td>";
echo "<td width=25%>&nbsp;"."提交时间"."&nbsp;</td>";
echo "<td width=25%>&nbsp;"."提交人"."&nbsp;</td>";
echo"</tr>";
while($rows = mysql_fetch_row($result)){//使用while遍历所有记录，并显示在表格的tr中
	echo "<tr>";
	for($i = 0; $i < count($rows); $i++)
		if($i == 1){
			echo "<td><a href=\"detail.php?id=".$rows[$i]."\">详情</a></td>";	
		} else {
			echo "<td>&nbsp;".$rows[$i]."</td>";
		}
}
echo "</tr></table>";

?>
