<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
    <style type="text/css">  
    *{  
        margin:0;  
        padding:0;  
    }  
    #lay{  
        margin:100px 100px 100px 100px;  
    }  
    a{  
        padding:5px;  
        font-size:13px;  
        text-decoration:none;  
    }  
    span{  
        font-size:13px;  
    }  
    table{  
        border:1px solid red;  
        border-collapse:collapse;  
    }  
    </style>
����
����$link = mysql_connect("localhost","root",""); //�������ݿ�
����mysql_select_db("cs");//ѡ���ĸ����ݿ�
����mysql_query("set names utf-8"); //�������ݿ��ַ�����Ϊ����
����$sql = mysql_query("select *from persons");
����$pagesize = 5; //��ʾ����
����$sum = mysql_num_rows($sql); //�ж� һ���ж���������
����$count = ceil($sum/$pagesize);//���һ���ж���ҳ
����$pages = $count; //��ʾ���һҳ
����$init = 1;
����$page_len = 7;
����$max_p = $count;
����if(empty($_GET["page"])|| $_GET["page"]<0){
����$page = 1;
����}else{
����$page = $_GET["page"];
����}
����$off = ($page-1)*$pagesize; //������ݿ��ѯ�ĵ�һ������
����$he = mysql_query("select * from persons limit $off,$pagesize");//����off��ʼ����pagesize������ʾ
����echo "һ�� ".$sum." ������";
����while($row = mysql_fetch_array($he)){
����echo "";
����echo "".$row['id']."";
����echo "".$row['FirstName']."";
����echo " ";
����}
����?>
����
����$page_len = ($page_len%2)?$page_len:$page_len+1;//�����Ϊ1��Ϊ�棬Ϊ0��Ϊ��
����$pageoffset = ($page_len-1)/2;//ҳ��ƫ����
����$key ="";
����if($page!=1){
����$key.="��һҳ ";
����$key.="��һҳ ";
����}else{
����$key.="��һҳ ";
����$key.="��һҳ ";
����}
����if($pages>$page_len){
����if($page<=$pageoffset){
����$init=1;
����$max_p = $page_len;
����}else{
����if($page+$pageoffset>=$pages+1){
����$init = $pages - $page_len+1;
����}else{
����$init = $page-$pageoffset;
����$max_p = $page + $pageoffset;
����}
����}
����}
����for($i=$init;$i<=$max_p;$i++){
����if($i==$page){
����$key.="[ ".$i." ]";
����}else{
����$key.="$i";
����}
����}
����if($i-1!=$page){
����$key.="��һҳ";
����$key.="���һҳ";
����}else{
����$key.="��һҳ";
����$key.="���һҳ";
����}
����echo "";
����echo "".$key."";
����echo "";
?>