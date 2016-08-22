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
	<table id="dg" title="我的用例" class="easyui-datagrid" style="width:80%"
			url="./cases/get_cases.php"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="cmodel" width="10%">模块</th>
				<th field="ccase" width="40%">测试用例</th>
				<th field="cexpect" width="20%">期待结果</th>
				<th field="ctype" width="10%">测试类型</th>
				<th data-options="field:'cresult',formatter:formatResult" width="10%">测试结果</th>
				<th data-options="field:'cbug',formatter:rowformatter" width="10%" >bug</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar" style="padding:5px;height:auto">
		<div>
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editCase()">执行用例</a>
		</div>
		<div>
			项目: 
			<select id="projectselect" class="easyui-combobox" panelHeight="auto" style="width:100px">
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
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="loadDataGridWithParam()">选择</a>
		</div>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:600px;height:400px;padding:10px 20px"
			closed="true" buttons="#dlg-buttons">
		<div class="ftitle">用例状态</div>
		<form id="fm" method="post" novalidate>
			<div class="fitem">
				<label>用例:</label>
				<textarea name="ccase" class="easyui-validatebox" disabled="disabled" style="width:100%;resize:none;"></textarea>
			</div>
			<div class="fitem">
				<label>期望结果:</label>
				<textarea name="cexpect" class="easyui-validatebox" disabled="disabled" style="width:100%;resize:none;"></textarea>
			</div>
			<div class="fitem">
				<label>实际结果:</label>
				<select id="cresult" name="cresult">
					<option value='未执行'>未执行</option>
					<option value='通过'>通过</option>
					<option value='失败'>失败</option>
				</select>
			</div>
			<div class="fitem">
				<label>bug:</label>
				<input name="cbug" class="easyui-validatebox">
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveStatus()">保存</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">取消</a>
	</div>
	</td></tr>
	</table>

<?php
  require('footer.php');
?>
