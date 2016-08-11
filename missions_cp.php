<?php
//包含数据库连接文件
header("Content-type:text/html;charset=utf-8");
include('conn.php');
$cpid = $_SESSION['userid'];

$result = mysql_query("select project.pid, project.pname, project.ptime, cp.cpname, project.pid from project left join cp on project.cpid = cp.cpid 
where cp.cpid='$cpid'"); //执行SQL查询指令
echo "<table border=1, width=90%><tr>";
echo "<td  width=10%>&nbsp;"."任务编号"."&nbsp;</td>";
echo "<td  width=30%>&nbsp;"."任务名称"."&nbsp;</td>";
echo "<td  width=20%>&nbsp;"."提交时间"."&nbsp;</td>";
echo "<td  width=20%>&nbsp;"."提交人"."&nbsp;</td>";
echo "<td  width=20%>&nbsp;"."详情"."&nbsp;</td>";
echo"</tr>";
while($rows = mysql_fetch_row($result)){//使用while遍历所有记录，并显示在表格的tr中
	echo "<tr>";
	for($i = 0; $i < count($rows); $i++)
		if($i == 4){
			echo "<td><a href=\"detail.php?id=".$rows[$i]."\">详情</a></td>";	
		} else {
			echo "<td>&nbsp;".$rows[$i]."</td>";
		}
}
echo "</tr></table>";

?>
