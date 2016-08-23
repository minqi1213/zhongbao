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
			<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newBug()">新建bug</a>
		</div>
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
	
	<!-- Dailog for create new bug-->
	<div id="dlg_newbug" class="easyui-dialog" style="width:70%;height:90%;padding:10px 20px"
			closed="true" buttons="#dlg-buttons">
		<div class="ftitle">新建bug</div>
		<form id="fm_newbug" method="post" enctype="multipart/form-data" novalidate>
			<div class="fitem">
				<label>请选择项目:</label>
				<select id="projectselect_newbug" name="projectselect_newbug" data-options="required:true" class="easyui-combobox" panelHeight="auto" style="width:100px">
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
			</div>
			<div class="fitem">
				<label>bug标题:</label>
				<input name="btitle" class="easyui-textbox" style="width:90%;resize:none;" data-options="required:true"/>
			</div>
			<div class="fitem">
				<label>bug详情:</label>
				<textarea name="bdescription" class="easyui-textbox" data-options="multiline:true,required:true" style="width:90%;height:300px;resize:none;">
前提条件：

复现步骤：
	1.
	2.
	3.
测试结果：

期待结果：

复现率：

备注：

设备信息：
	设备：
	系统版本：
Bug优先级：
</textarea>
			</div>
			<div style="margin-bottom:20px">
				<div>截图1:</div>
				<input class="easyui-filebox" name="photo1" data-options="prompt:'选择一张截图...'" style="width:90%">
			</div>
			<div style="margin-bottom:20px">
				<div>截图2:</div>
				<input class="easyui-filebox" name="photo2" data-options="prompt:'选择一张截图...'" style="width:90%">
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveBug()">保存</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_newbug').dialog('close')">取消</a>
	</div>
	</td></tr>
	</table>	

<?php
  require('footer.php');
?>
