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
?>

	<table width="100%"><tr><td align="center" valign="middle">
	<table id="dg_bug" title="我的bug" class="easyui-datagrid" style="width:80%"
			url="./bugs/get_bugs.php"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="btitle" width="60%">标题</th>
				<th data-options="field:'bid',formatter:rowformatter" width="10%">详情</th>
				<th field="btime" width="20%">提交时间</th>
				<th data-options="field:'username'" width="10%" >提交人</th>
			</tr>
		</thead>
	</table>

	<div id="toolbar" style="padding:5px;height:auto">
		<div>
			&nbsp;&nbsp;&nbsp;&nbsp;请选择项目:&nbsp;&nbsp;
			<select id="projectselect_bug" class="easyui-combobox" panelHeight="auto" style="width:100px">
				<option value=0>所有项目</option>
<?php
	session_start();
	$uid = $_SESSION['userid'];
	include('conn.php');
	$result = mysql_query("select project.pid,project.pname from project,userproject where userproject.uid='$uid' and userproject.status=1 and userproject.pid=project.pid"); //执行SQL查询指令
	while($rows = mysql_fetch_row($result)){//使用while遍历所有记录，并显示在select
		echo "<option value=\"$rows[0]\">$rows[1]</option>";
	}
?>
			</select>
			&nbsp;&nbsp;&nbsp;&nbsp;请选择提交人:&nbsp;&nbsp;
			<select id="projectselect_user" class="easyui-combobox" panelHeight="auto" style="width:100px">
				<option value=0>所有人</option>
				<option value=1>我</option>
			</select>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input id="projectselect_input" class="easyui-textbox" style="width:40%" data-options="prompt:'请输入要搜索的关键字，以空格隔开'"/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="loadDataGridBugWithParam()">搜索</a>
		</div>
	</div>

<?php
  require('footer.php');
?>
