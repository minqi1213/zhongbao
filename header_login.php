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
		function newUser(){
			$('#dlg').dialog('open').dialog('setTitle','New User');
			$('#fm').form('clear');
			url = './cases/save_user.php';
		}
		function editCase(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','执行用例');
				$('#fm').form('load',row);
				$('#cstatus').val(row.cstatus);
				url = './cases/update_casestatus.php?cid='+row.cid+'&pid='+row.pid;
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
			return "<a href='detail.php?id="+value+"' target='_blank' >"+value+"</a>";
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
				pageSize:50,
				pageList: [50, 100, 150],
				queryParams:{
					pname:$('#projectselect').text()
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
    <td class="label_header" width="20%">
      <img src="s-logo.gif" alt="" height="20" width="20" />
      <span class="menu_header"><a class="menu_a" href="submit_bug.php">提交</a></span></td>
    <td class="label_header" width="20%">
      <img src="s-logo.gif" alt="" height="20" width="20" />
      <span class="menu_header"><a class="menu_a" href="buglist_engineer.php">查询</a></span></td>
    <td class="label_header" width="20%">
      <img src="s-logo.gif" alt="" height="20" width="20" />
      <span class="menu_header"><a class="menu_a" href="case_engineer.php">测试用例</a></span></td>
    <td class="label_header" width="20%" >
      <img src="s-logo.gif" alt="" height="20" width="20" />
      <span class="menu_header" ><a class="menu_a" href="my.php">任务接取中心</a></span></td>
    <td class="label_header" width="20%">
      <img src="s-logo.gif" alt="" height="20" width="20" />
      <span class="menu_header"><a class="menu_a" href="login.php?action=logout">注销</a></span></td>
  </tr>
  </table>

