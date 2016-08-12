<?php
//包含数据库连接文件
header("Content-type:text/html;charset=utf-8");
include('conn.php');
$uid = $_SESSION['userid'];

$result = mysql_query("select project.pid, project.pname, project.ptime, userproject.status, project.pid from project left join userproject on project.pid = userproject.pid and userproject.uid='$uid'"); //执行SQL查询指令
echo "<table border=1, width=90%><tr>";
echo "<td  width=10%>&nbsp;"."任务编号"."&nbsp;</td>";
echo "<td  width=30%>&nbsp;"."任务名称"."&nbsp;</td>";
echo "<td  width=20%>&nbsp;"."提交时间"."&nbsp;</td>";
echo "<td  width=20%>&nbsp;"."接取状态"."&nbsp;</td>";
echo "<td  width=20%>&nbsp;"."是否接取"."&nbsp;</td>";
echo"</tr>";
while($rows = mysql_fetch_row($result)){//使用while遍历所有记录，并显示在表格的tr中
	echo "<tr>";
	for($i = 0; $i < count($rows); $i++)
		if($i == 4){
			if($rows[3]==1||$rows[3]==2){
				echo "<td>&nbsp;已操作完成，请等待</td>";
			} else {
			echo "<td valign=\"middle\"><div text-align=\"center\"><form name=\"form_accept\" method=\"post\" action=\"my.php\">
				<p><input type=\"hidden\" name=\"action\" value=\"accept\">
				   <input type=\"hidden\" name=\"userid\" value=\"$uid\">
				   <input type=\"hidden\" name=\"projectid\" value=\"".$rows[$i]."\">
				   <input  type=\"submit\" name=\"submit_accept\" value=\"接取\">
				</p>
				</form></div></td>";
			}	
		} else if ( $i == 3){
			if($rows[$i]=='2'){
				echo "<td>&nbsp;已接取</td>";
			} else if ($rows[$i]=='1'){
				echo "<td>&nbsp;审核中</td>";
			} else {
				echo "<td>&nbsp;未接取</td>";
			}
		} else {
			echo "<td>&nbsp;".$rows[$i]."</td>";
		}
}
echo "</tr></table>";

?>
