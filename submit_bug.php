<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>bug提交</title>
  <style type="text/css">
    html{font-size:12px;}
	fieldset{width:640px; margin: 0 auto;}
	legend{font-weight:bold; font-size:14px;}
	label{float:left; width:70px; margin-left:10px;}
	.left{margin-left:80px;}
	.input{width:500px;resize:none}
	#bugdesc{height:300px;}
	span{color: #666666;}
  </style>
<script language=JavaScript>
<!--

function InputCheck(RegForm)
{
  if (RegForm.bugtitle.value == "")
  {
    alert("bug标题不可为空!");
    RegForm.bugtitle.focus();
    return (false);
  }
  if (RegForm.bugdesc.value == "")
  {
    alert("bug描述不可为空!");
    RegForm.bugdesc.focus();
    return (false);
  }
}

//-->
</script>
</head>
<div>
<fieldset>
<legend>bug提交</legend>
<form name="RegForm" method="post" action="submit.php" enctype="multipart/form-data" onSubmit="return InputCheck(this)">
<?php
session_start();
include('conn.php');
$uid = $_SESSION['userid']; 
$result = mysql_query("select project.pid project.pname from project,userproject where userproject.uid='$uid' and userproject.status=1 and userproject.pid=project.pid"); //执行SQL查询指令
var_dump($result);
echo "<p>";
echo "<label for=\"userproject\" class=\"label\">请选择项目:</label>";
echo "<select id=\"userproject\" name=\"userproject\">";
echo "</select>";
echo "</p>";
?>
<p>
<label for="bugtitle" class="label">bug标题:</label>
<textarea id="bugtitle" name="bugtitle" type="text" class="input" rows="1"></textarea>
<p/>
<p>
<label for="bugdesc" class="label">bug描述:</label>
<textarea id="bugdesc" name="bugdesc" type="text" class="input" >
Title:

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
<p/>
<p>
<input type="hidden" name="action" value="add">
图片地址
<input id="photo" name="photo" type="file">
<input type="submit" name="submit" value="  提交bug  " class="left" />
</p>
</form>
</fieldset>
</div>
<body>
</body>
</html>
