<?php
//包含数据库连接文件
header("Content-type:text/html;charset=utf-8");
include('conn.php');
$cpid = $_SESSION['userid'];

$result = mysql_query("select project.pid, project.pname, project.ptime, cp.cpname, project.pid, project.security, project.casestatus,project.bugstatus,project.pstatus from project left join cp on project.cpid = cp.cpid 
where cp.cpid='$cpid'"); //执行SQL查询指令
//case 执行状态
//bug 状态
//项目运行状态 0L待审核 1:测试中 2:已完成
//安全检测状态 0:待测试 1:不安全 2:安全
echo "<table border=1, width=90%><tr>";
echo "<td  width=10%>&nbsp;"."任务编号"."&nbsp;</td>";
echo "<td  width=20%>&nbsp;"."任务名称"."&nbsp;</td>";
echo "<td  width=10%>&nbsp;"."提交时间"."&nbsp;</td>";
echo "<td  width=10%>&nbsp;"."提交人"."&nbsp;</td>";
echo "<td  width=10%>&nbsp;"."详情"."&nbsp;</td>";
echo "<td  width=10%>&nbsp;"."安全状态"."&nbsp;</td>";
echo "<td  width=10%>&nbsp;"."case状态"."&nbsp;</td>";
echo "<td  width=10%>&nbsp;"."bug状态"."&nbsp;</td>";
echo "<td  width=10%>&nbsp;"."项目状态"."&nbsp;</td>";
echo"</tr>";
while($rows = mysql_fetch_row($result)){//使用while遍历所有记录，并显示在表格的tr中
	echo "<tr>";
	for($i = 0; $i < count($rows); $i++)
		if($i == 4){
			echo "<td><a href=\"detail.php?id=".$rows[$i]."\">详情</a></td>";	
		} else if ($i == 5){
			if ($rows[$i] == 0){
				echo "<td>&nbsp;待安全测试</td>";
			} else if ($rows[$i]==1){
				echo "<td>&nbsp;不安全</td>";
			} else if ($rows[$i]==2){
				echo "<td>&nbsp;安全</td>";
			}
		} else if($i==6) {
			echo "<td>&nbsp;0/1000</td>";
		} else if ($i==7){
			echo "<td>&nbsp;0/5000</td>";
		} else if ($i==8){
			if ($rows[$i] == 0){
                                echo "<td>&nbsp;待测试</td>";
                        } else if ($rows[$i]==1){
                                echo "<td>&nbsp;测试中</td>";
                        } else if ($rows[$i]==2){
                                echo "<td>&nbsp;已完成</td>";
                        }
		} else {
			echo "<td>&nbsp;".$rows[$i]."</td>";
		}
}
echo "</tr></table>";

?>
