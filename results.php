<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>分页</title>
</head>
 
<body>
 
<table cellpadding="0" cellspacing="0" border="1" width="100%">
<tr>
<td>代号</td>
<td>名称</td>
<td>父级名称</td>
</tr>
<?php
include("conn.php");
include("pager.class.php");
//$db = mysqli_connect('localhost','sunnytest','sunnytest123','zhongbao');
 
$sqlall = "select count(*) from bug";
//$attrall = $db->Query($sqlall);
$attrall = mysql_query($sqlall);
var_dump($attrall); //显示是一个二维数组
 
$total = $attrall[0][0];
 
$page = new Page($total,20);//需要参数 1.数据总条数(总条数，一页显示多少，查询条件，ture类型从第一页显示，)
 
 
$sql = "select bug.btitle, bug.btime, user.username from bug left join user on bug.uid = user.uid ".$page->limit; //SQL语句拼接limit 记住加空格
 
//$attr = $db->Query($sql);
$attr = mysql_query($sql);
var_dump($attr);
while($rows = mysql_fetch_row($attr)){//使用while遍历所有记录，并显示在表格的tr中
	echo "<tr>";
	for($i = 0; $i < count($rows); $i++)
		echo "<td>&nbsp;".$rows[$i]."</td>";
}
echo "</tr>";
//foreach($attr as $v)
//{
//    echo "<tr>
//            <td>{$v[0]}</td>
//            <td>{$v[1]}</td>
//            <td>{$v[2]}</td>
//        </tr>";  
//}
?>
</table>
 
<?php
     
    //调用分页信息
    echo "<div>".$page->fpage()."</div>";//里面可以写参数
?>
</body>
</html>