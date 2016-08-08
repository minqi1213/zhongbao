<?php
$bh = $_GET["id"];

echo $bh;
//包含数据库连接文件
include('conn.php');

$user_query = mysql_query("select btitle,bdescription from bug where bid=$bh limit 1");
$row = mysql_fetch_array($user_query);



?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>bug详情</title>
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
<?php
session_start();
if(!isset($_SESSION['userid'])){
	require('header.php');
} else {
	require('header_login.php');
}
  
?>
<div>
<fieldset>
<legend>bug详情</legend>
<form name="RegForm" method="post" action="submit.php" onSubmit="return InputCheck(this)">
<p>
<label for="bugtitle" class="label">bug标题:</label>
<textarea id="bugtitle" name="bugtitle" type="text" class="input" rows="1">
<?php
	echo $row['btitle'];
?>
</textarea>
<p/>
<p>
<label for="bugdesc" class="label">bug描述:</label>
<textarea id="bugdesc" name="bugdesc" type="text" class="input" >
<?php
	echo $row['bdescription'];
?>
</textarea>
<p/>
</form>
</fieldset>
</div>
<body>
</body>
</html>
