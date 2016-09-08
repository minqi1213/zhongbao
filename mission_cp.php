<?php
header("Content-type:text/html;charset=utf-8");
session_start();
//检测是否登录，若没登录则转向登录界面
if(!isset($_SESSION['userid'])){
	header("Location:login.html");
	exit();
} else {
	require('header_cp.php');
}
?>
	<table width="100%"><tr><td align="center" valign="middle">
	<table id="dg_mission_cp" title="我的任务" class="easyui-datagrid" style="width:80%"
			url="./missions/get_missions_cp.php"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="pname" width="10%">任务名称</th>
				<th field="ptime" width="20%">发布时间</th>
				<th data-options="field:'pid',formatter:rowformatter_pinfo" width="10%" >任务详情</th>
				<th data-options="field:'security',formatter:rowformatter_securitystatus" width="15%">安全状态</th>
				<th field="casestatus" width="15%">case状态</th>
				<th field="bugstatus" width="15%">bug状态</th>
				<th data-options="field:'pstatus',formatter:rowformatter_pstatus" width="15%">项目状态</th>
				<th field="pdescription" hidden="true" width="0%">任务描述</th>
			</tr>
		</thead>
	</table>

	<div id="toolbar" style="padding:5px;height:auto">
		<div>
			<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newMission()">新建任务</a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editMission()">编辑任务</a>
		</div>
	</div>
	<div style="position:relative;width:100%">
	<div id="dlg_mission" class="easyui-dialog" style="width:600px;height:400px;left:25%;top:10%;padding:10px 20px"
			closed="true" buttons="#dlg-buttons-mission">
		<div class="ftitle">任务信息</div>
		<form id="fm_mission" method="post" novalidate>
			<div class="fitem">
				<label>任务名称:</label>
				<textarea name="pname" class="easyui-validatebox" disabled="disabled" style="width:100%;resize:none;"></textarea>
			</div>
			<div class="fitem">
				<label>任务描述:</label>
				<textarea name="pdescription" class="easyui-validatebox" disabled="disabled" style="width:100%;height:200px;resize:none;"></textarea>
			</div>
		</form>
	</div>
	<div id="dlg-buttons-mission">
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_mission').dialog('close')">关闭</a>
	</div>

	<div id="dlg_mission_new" class="easyui-dialog" style="width:600px;height:500px;left:25%;top:10%;padding:10px 20px"
			closed="true" buttons="#dlg-buttons-mission-new">
		<div class="ftitle">新增任务</div>
		<form id="fm_mission_new" method="post"  enctype="multipart/form-data" novalidate>
                        <div class="fitem">
                                <label>任务名称:</label>
                                <textarea name="pname" class="easyui-validatebox" style="width:100%;resize:none;" data-options="required:true"></textarea>
                        </div>
                        <div class="fitem">
                                <label>任务描述:</label>
                                <textarea name="pdescription" class="easyui-validatebox" style="width:100%;height:200px;resize:none;" data-options="required:true"></textarea>
                        </div>
			<div style="margin-bottom:20px">
				<div>应用程序:</div>
				<input class="easyui-filebox" name="application" data-options="prompt:'选择要上传的apk...'" style="width:90%">
			</div>
                </form>
	</div>
	<div id="dlg-buttons-mission-new">
		<a id="savebtn_newmission" href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveMission()">保存</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_mission_new').dialog('close')">关闭</a>
        </div>
	</div>	
	</td></tr> 
	</table>

<?php
  require('footer.php');
?>
