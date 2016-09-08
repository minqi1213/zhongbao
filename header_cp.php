<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>SunnyTest</title>
	<link rel="stylesheet" type="text/css" href="./css/easyui.css">
	<link rel="stylesheet" type="text/css" href="./css/icon.css">
	<link rel="stylesheet" type="text/css" href="./css/demo.css">
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
    h1 {color:white; font-size:24pt; text-align:center;
        font-family:arial,sans-serif}
    .menu_header {color:white; font-size:12pt; text-align:center;
           font-family:arial,sans-serif; font-weight:bold}
    .label_header {background:black}
    p {color:black; font-size:12pt; text-align:justify;
       font-family:arial,sans-serif}
    p.foot {color:white; font-size:9pt; text-align:center;
            font-family:arial,sans-serif; font-weight:bold}
    a.menu_a:link,a.menu_a:visited,a.menu_a:active {color:white}
    fieldset{width:90%; margin: 0 auto;}
    legend{font-weight:bold; font-size:14px;}
  </style>
	<script type="text/javascript" src="./js/jquery.min.js"></script>
	<script type="text/javascript" src="./js/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		var url;
		function displayBug(index){
			$('#dg_bug_cp').datagrid('selectRow',index);
			$('#btitle_display').textbox('readonly',true);
                        $('#bdescription_display').textbox('readonly',true);
			$('#imgarea_display').css('display','block');
			$('#filearea_display').css('display','none');
			$('#dlg-buttons-display').css('display','none');
			var row=$('#dg_bug_cp').datagrid('getSelected');
			if (row){
				$('#dlg_displaybug').dialog('open').dialog('setTitle','bug详情');
				$('#fm_displaybug').form('clear');
				$('#fm_displaybug').form('load',row);
				$('#projectselect_displaybug').combobox('setValue',row.pid);
				$('#projectselect_displaybug').combobox('disable');
				var userid = <?php 
					session_start();
					echo $_SESSION['userid'];
				?>;
				if(userid != row.uid){
					$("div.dialog-toolbar [id='edit_bug_toolbar']").eq(0).hide();
				} else {
					$("div.dialog-toolbar [id='edit_bug_toolbar']").eq(0).show();
				}
				if(row.binarydata==""){
					document.getElementById('display_photo1').style.visibility="hidden";
					$('#display_photo1').attr('src',"");
				} else {
					document.getElementById('display_photo1').style.visibility="visible";
					$('#display_photo1').attr('src',row.binarydata);
				}
                                if(row.binarydata2==""){
                                        document.getElementById('display_photo2').style.visibility="hidden";
					$('#display_photo2').attr('src',"");
                                } else {
					document.getElementById('display_photo2').style.visibility="visible";
                                        $('#display_photo2').attr('src',row.binarydata2);
                                }
			}
		}
		function showImg(src){
			$('#dlg_displayimg').dialog('open').dialog('setTitle','截图');
			$('#display_img').attr('src','');
			$('#display_img').attr('src',src);
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
		function displayMission(index){
			$('#dg_mission_cp').datagrid('selectRow',index);
			var row=$('#dg_mission_cp').datagrid('getSelected');
			if(row){
				$('#dlg_mission').dialog('open').dialog('setTitle','任务详情');
				//$("#dlg_mission").panel("move",{top:$(document).scrollTop() + ($(window).height()-400) * 0.5}); 
				$('#fm_mission').form('clear');
				$('#fm_mission').form('load',row);
			}
		}
		function newMission(){
			$('#dlg_mission_new').dialog('open').dialog('setTitle','新建任务');
			$('#fm_mission_new').form('clear');
			url='./missions/save_mission.php';
		}
		function saveMission(){
			$('#savebtn_newmission').linkbutton("disable");
			$('#fm_mission_new').form('submit',{
                                url: url,
                                onSubmit: function(){
                                        return $(this).form('validate');
                                },
                                success: function(result){
                                        result = result.substring(result.indexOf('{'),result.indexOf('}')+1);
                                        var result = eval('('+result+')');
                                        if (result.success){
                                                $('#dlg_mission_new').dialog('close');              // close the dialog
                                                $('#dg_mission_cp').datagrid('reload');    // reload the user data
                                        } else {
                                                $.messager.show({
                                                        title: 'Error',
                                                        msg: result.msg
                                                });
                                        }
					$('#savebtn_newmission').linkbutton("enable");
                                }
                        });
		}
		function rowformatter(value,row,index){
                        //return "<a href='detail.php?id="+value+"' target='_blank' >"+value+"</a>";
			return "<div><a href=\"#\" class=\"easyui-linkbutton\" plain=\"true\" onclick=\"showBug('"+value+"')\">"+value+"</a></div>";
                }
		function rowformatter_buglist(value,row,index){
			//return "<a href='detail.php?id="+value+"' target='_blank' >"+value+"</a>";
			return "<div><a href=\"#\" class=\"easyui-linkbutton\" plain=\"true\" onclick=\"displayBug('"+index+"')\">"+value+"</a></div>";
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
		function rowformatter_pstatus(val,row){
			if (val == '1'){
				return '测试中';
			} else if (val == '2'){
				return '已完成';
			} else {
				return '待测试';
			}
		}
		function rowformatter_securitystatus(val,row){
			if (val == '1'){
				return '不安全';
			} else if (val == '2'){
				return '安全';
			} else {
				return '待安全测试';
			}
		}
		function rowformatter_paccept(value,rowData,rowIndex){
			if (rowData.status == '1'||rowData.status == '2' ){
                                return '已操作完成';
                        } else {
				return "<div><a href=\"#\" class=\"easyui-linkbutton\" plain=\"true\" onclick=\"acceptMission('"+rowData.pid+"')\">接取</a></div>";
                        }
		}
		function rowformatter_pinfo(value,row,index){
			return "<div><a href=\"#\" class=\"easyui-linkbutton\" plain=\"true\" onclick=\"displayMission('"+index+"')\">详情</a></div>";
		}
		function loadDataGridWithParam(){
			$('#dg').datagrid({
				pageSize:50,
				pageList: [50, 100, 150],
				queryParams:{
					pname:$('#projectselect').combobox('getText')
				}
			});
			
		}
		function loadDataGridBugWithParamCP(){
			$('#dg_bug_cp').datagrid({
				queryParams:{
					projectid:$('#projectselect_bug').combobox('getValue'),
					keyword:$('#projectselect_input').val()
				}
			});
		}
	</script>
</head>
<body>

  <!-- page header -->
  <table width="100%" cellpadding="12" cellspacing="0" border="0">
  <tr bgcolor="black">
    <td align="left"><img src="logo.gif" alt="TLA logo" height="70" width="70"></td>
    <td>
        <h1>SunnyTest 众包</h1>
    </td>
    <td align="right"><img src="logo.gif" alt="TLA logo" height="70" width="70" /></td>
  </tr>
  </table>

  <!-- menu -->
  <table width="100%" bgcolor="white" cellpadding="4" cellspacing="4">
  <tr >
	<td class="label_header" width="25%">
      		<img src="s-logo.gif" alt="" height="20" width="20" />
      		<span class="menu_header"><a class="menu_a" href="submit_mission.html">发布任务</a></span></td>
    	<td class="label_header" width="25%">
      		<img src="s-logo.gif" alt="" height="20" width="20" />
      		<span class="menu_header"><a class="menu_a" href="buglist_cp.php">查询bug</a></span></td>
    	<td class="label_header" width="25%" >
      		<img src="s-logo.gif" alt="" height="20" width="20" />
      		<span class="menu_header" ><a class="menu_a" href="mission_cp.php">任务中心</a></span></td>
    	<td class="label_header" width="25%">
      		<img src="s-logo.gif" alt="" height="20" width="20" />
      		<span class="menu_header"><a class="menu_a" href="login.php?action=logout">注销</a></span></td>
  </tr>
  </table>

	<!-- Dailog for create new bug-->
	<div id="dlg_displaybug" class="easyui-dialog" style="width:75%;height:500px;left:15%;top:10%;padding:10px 20px"
			closed="true" buttons="#dlg-buttons-display"data-options="
		toolbar: [{
					text:'编辑',
					id:'edit_bug_toolbar',
					iconCls:'icon-edit',
					handler:function(){
						editBug()
					}
				}]
	" >
		<div class="ftitle">bug详情</div>
		<form id="fm_displaybug" method="post" enctype="multipart/form-data" novalidate>
			<div class="fitem">
				<label>项目:</label>
				<select id="projectselect_displaybug" name="projectselect_displaybug" disabled="disabled" data-options="required:true" class="easyui-combobox" panelHeight="auto" style="width:100px">
<?php
	session_start();
	$uid = $_SESSION['userid'];
	include('conn.php');
	$result = mysql_query("select project.pid,project.pname from project where project.cpid='$uid'"); //执行SQL查询指令
	while($rows = mysql_fetch_row($result)){//使用while遍历所有记录，并显示在select
		echo "<option value=\"$rows[0]\">$rows[1]</option>";
	}
?>
			</select>
			</div>
			<div class="fitem">
                                <label>bug编号:</label>
                                <input id="bid_display" name="bid" class="easyui-textbox" style="width:90%;resize:none;" readOnly=true data-options="required:true"/>
                        </div>
			<div class="fitem">
				<label>bug标题:</label>
				<input id="btitle_display" name="btitle" class="easyui-textbox" style="width:90%;resize:none;" data-options="required:true"/>
			</div>
			<div class="fitem">
				<label>bug详情:</label>
				<textarea id="bdescription_display" name="bdescription" class="easyui-textbox" data-options="multiline:true,required:true" style="width:90%;height:300px;resize:none;"></textarea>
			</div>
			<br><br>
			<div id="filearea_display">
			<div style="margin-bottom:20px">
				<div>截图1:</div>
				<input class="easyui-filebox" name="photo1" data-options="prompt:'选择一张截图...'" style="width:90%">
			</div>
			<div style="margin-bottom:20px">
				<div>截图2:</div>
				<input class="easyui-filebox" name="photo2" data-options="prompt:'选择一张截图...'" style="width:90%">
			</div>
			</div>
			<div id="imgarea_display">
			<div style="width:100%">
			<div style="margin-bottom:20px;width:50%;float:left">
				<div>截图1:</div>
				<img id="display_photo1" name="display_photo1" width="90%" src="" onclick="javascript:showImg(src)">
			</div>
			<div style="margin-bottom:20px;width:50%;float:left">
				<div>截图2:</div>
				<img id="display_photo2" name="display_photo2" width="90%" src="" onclick="javascript:showImg(src)">
			</div>
			</div>
			</div>
		</form>
	</div>
	<div id="dlg-buttons-display">
		<a id="savebtn_editbug" href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveChange()">保存</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_displaybug').dialog('close');">取消</a>
	</div>

	<div id="dlg_displayimg" class="easyui-dialog"  style="width:100%;height:100%;"
			closed="true">
		<div style="margin-bottom:20px;width:100%;float:left">
                	<img id="display_img" name="display_img" width="100%" src="">
                </div>
	</div>
