<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>��ҳ</title>
</head>
 
<body>
 
<table cellpadding="0" cellspacing="0" border="1" width="100%">
<tr>
<td>����</td>
<td>����</td>
<td>��������</td>
</tr>
<?php
include("conn.php");
include("pager.class.php");
//$db = mysqli_connect('localhost','sunnytest','sunnytest123','zhongbao');
 
$sqlall = "select count(*) from bug";
//$attrall = $db->Query($sqlall);
$attrall = mysql_query($sqlall);
var_dump($attrall); //��ʾ��һ����ά����
 
$total = $attrall[0][0];
 
$page = new Page($total,20);//��Ҫ���� 1.����������(��������һҳ��ʾ���٣���ѯ������ture���ʹӵ�һҳ��ʾ��)
 
 
$sql = "select bug.btitle, bug.btime, user.username from bug left join user on bug.uid = user.uid ".$page->limit; //SQL���ƴ��limit ��ס�ӿո�
 
//$attr = $db->Query($sql);
$attr = mysql_query($sql);
var_dump($attr);
while($rows = mysql_fetch_row($attr)){//ʹ��while�������м�¼������ʾ�ڱ���tr��
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
     
    //���÷�ҳ��Ϣ
    echo "<div>".$page->fpage()."</div>";//�������д����
?>
</body>
</html>