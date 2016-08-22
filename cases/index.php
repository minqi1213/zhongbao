<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="jquery,ui,easy,easyui,web">
	<meta name="description" content="easyui help you build your web page easily!">
	<title>jQuery EasyUI CRUD Demo</title>
	<link rel="stylesheet" type="text/css" href="../css/easyui.css">
	<link rel="stylesheet" type="text/css" href="../css/icon.css">
	<link rel="stylesheet" type="text/css" href="../css/demo.css">
	<style type="text/css">
		#fm{
			margin:0;
			padding:10px 30px;
		}
		.ftitle{
			font-size:14px;
			font-weight:bold;
			color:#666;
			padding:5px 0;
			margin-bottom:10px;
			border-bottom:1px solid #ccc;
		}
		.fitem{
			margin-bottom:5px;
		}
		.fitem label{
			display:inline-block;
			width:80px;
		}
	</style>
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		var url;
		function newUser(){
			$('#dlg').dialog('open').dialog('setTitle','New User');
			$('#fm').form('clear');
			url = 'save_user.php';
		}
		function editCase(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','执行用例');
				$('#fm').form('load',row);
				$('#cstatus').val(row.cstatus);
				url = 'update_casestatus.php?cid='+row.cid+'&pid='+row.pid;
			}
		}
		function saveStatus(){
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){
					var result = eval('('+result+')');
					if (result.success){
						$('#dlg').dialog('close');		// close the dialog
						$('#dg').datagrid('reload');	// reload the user data
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.msg
						});
					}
				}
			});
		}
		function removeUser(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('Confirm','Are you sure you want to remove this user?',function(r){
					if (r){
						$.post('remove_user.php',{id:row.id},function(result){
							if (result.success){
								$('#dg').datagrid('reload');	// reload the user data
							} else {
								$.messager.show({	// show error message
									title: 'Error',
									msg: result.msg
								});
							}
						},'json');
					}
				});
			}
		}
		function rowformatter(value,row,index){
			return "<a href='../detail.php?id="+value+"' target='_blank' >"+value+"</a>";
		}
		function formatResult(val,row){
			if (val == '失败'){
				return '<span style="color:red;">'+val+'</span>';
			} else if ( val == '通过'){
				return '<span style="color:green;">'+val+'</span>';
			} else {
				return val;
			}
		}
		function loadDataGridWithParam(){
			$('#dg').datagrid({
				queryParams:{
					pname:$('#projectselect').text()
				}
			});
			
		}
	</script>
</head>
<body>
	<h2>Basic CRUD Application</h2>
	<div class="demo-info" style="margin-bottom:10px">
		<div class="demo-tip icon-tip">&nbsp;</div>
		<div>Click the buttons on datagrid toolbar to do crud actions.</div>
	</div>
	
	<table id="dg" title="我的用例" class="easyui-datagrid" style="width:80%;height:400px"
			url="get_cases.php"
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
</body>
</html>
