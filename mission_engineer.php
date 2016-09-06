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
	<table id="dg_mission" title="我的任务" class="easyui-datagrid" style="width:80%"
			url="./missions/get_missions.php"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="pname" width="20%">任务名称</th>
				<th field="ptime" width="40%">发布时间</th>
				<th data-options="field:'status',formatter:rowformatter_pstatus" width="20%">接取状态</th>
				<th data-options="field:'pstatus',formatter:rowformatter_paccept" width="10%">是否接取</th>
				<th data-options="field:'pid',formatter:rowformatter" width="10%" >任务详情</th>
			</tr>
		</thead>
	</table>
	
	</td></tr>
	</table>

	<div >
		<form id="fm_accept" method="post">
			<input type='hidden' name='pid'>
		</form>
	</div>

<?php
  require('footer.php');
?>
