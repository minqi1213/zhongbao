<?php
header("Content-type:text/html;charset=utf-8");
session_start();
//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.html");
	exit();
} else {
	require('header_login.php');
}


$userid = $_SESSION['userid'];
include('conn.php');
$project_result = mysql_query("select project.pid,project.pname from project,userproject where userproject.uid='$userid' and userproject.status=1 and userproject.pid=project.pid"); //执行SQL查询指令
//项目和提交人选择菜单
echo "<fieldset>";
echo "<legend>bug列表</legend>";
echo "<form action=\"buglist_engineer.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"bugfilter_form\" id=\"bugfitler_form\">";
echo "<p><label for=\"bugfilter_project\" class=\"label\">&nbsp;&nbsp;&nbsp;&nbsp;请选择项目:&nbsp;&nbsp;";
echo "<select id=\"bugfilter_project\" name=\"bugfilter_project\">";
echo "<option value=0>所有项目</option>";
while($project_rows = mysql_fetch_row($project_result)){//使用while遍历所有记录，并显示在select
	echo "<option value=\"$project_rows[0]\"".($_POST['bugfilter_project']==$project_rows[0]?"selected=selected":"").">$project_rows[1]</option>";
}
echo "</select>";
echo "</label><label for=\"bugfilter_user\" class=\"label\">&nbsp;&nbsp;&nbsp;&nbsp;请选择提交人:&nbsp;&nbsp;";
echo "<select id=\"bugfilter_user\" name=\"bugfilter_user\">";
echo "<option value=0 ".($_POST['bugfilter_user']==0?"selected=selected":"").">所有人</option>";
echo "<option value=1 ".($_POST['bugfilter_user']==1?"selected=selected":"").">我</option>";
echo "</select>";
echo "</label><label style=\"display:inline-block;width:50%;\" for=\"bugfilter_keyword\" class=\"label\" align=\"right\">&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<input style=\"width:90%;\" id=\"bugfilter_keyword\" name=\"bugfilter_keyword\" type=\"text\" class=\"input\" placeholder=\"请输入要搜索的关键字，以空格隔开\"/>";
echo "</label><label for=\"bugfilter_submit\" class=\"label\" align=\"right\">&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<input type=\"hidden\" name=\"action\" value=\"bug_search\">";
echo "<input type=\"submit\" name=\"bugfilter_submit\" value=\"  搜索bug  \" class=\"left\" align=\"right\"/>";
echo "</label></p>";
echo "</form>";

$action = isset($_REQUEST['action'])? $_REQUEST['action'] : ''; 
if ($action == 'bug_search'){
	$projectid = $_POST['bugfilter_project'];
	$isuser = $_POST['bugfilter_user'];
	$keyword = trim($_POST['bugfilter_keyword']);
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
//	$result = mysql_query("select bug.bid,bug.btitle,bug.bid, bug.btime,user.username from bug, userproject,user where userproject.pid=bug.pid and userproject.uid='$userid'".$query_user."$query_project"." and bug.uid=user.uid order by bug.btime asc"); //执行SQL查询指令
	$result = mysql_query("select bug.bid,bug.btitle,bug.bid, bug.btime,user.username from bug, userproject,user where ".$query_keyword."userproject.pid=bug.pid and userproject.uid='$userid'".$query_user."$query_project"." and bug.uid=user.uid order by bug.btime asc"); //执行SQL查询指令
} else {
//展现buglist
	$result = mysql_query("select bug.bid,bug.btitle,bug.bid, bug.btime,user.username from bug, userproject,user where userproject.pid=bug.pid and userproject.uid='$userid' and bug.uid=user.uid order by bug.btime asc"); //执行SQL查询指令
}
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
echo "</fieldset>";

?>
<?php
  require('footer.php');
?>
