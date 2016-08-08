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
　　
　　$link = mysql_connect("localhost","root",""); //连接数据库
　　mysql_select_db("cs");//选择哪个数据库
　　mysql_query("set names utf-8"); //设置数据库字符编码为中文
　　$sql = mysql_query("select *from persons");
　　$pagesize = 5; //显示条数
　　$sum = mysql_num_rows($sql); //判断 一共有多少条数据
　　$count = ceil($sum/$pagesize);//求出一共有多少页
　　$pages = $count; //显示最后一页
　　$init = 1;
　　$page_len = 7;
　　$max_p = $count;
　　if(empty($_GET["page"])|| $_GET["page"]<0){
　　$page = 1;
　　}else{
　　$page = $_GET["page"];
　　}
　　$off = ($page-1)*$pagesize; //求出数据库查询的第一个数据
　　$he = mysql_query("select * from persons limit $off,$pagesize");//按照off开始，到pagesize规律显示
　　echo "一共 ".$sum." 条数据";
　　while($row = mysql_fetch_array($he)){
　　echo "";
　　echo "".$row['id']."";
　　echo "".$row['FirstName']."";
　　echo " ";
　　}
　　?>
　　
　　$page_len = ($page_len%2)?$page_len:$page_len+1;//如果余为1则为真，为0则为假
　　$pageoffset = ($page_len-1)/2;//页码偏移量
　　$key ="";
　　if($page!=1){
　　$key.="第一页 ";
　　$key.="上一页 ";
　　}else{
　　$key.="第一页 ";
　　$key.="上一页 ";
　　}
　　if($pages>$page_len){
　　if($page<=$pageoffset){
　　$init=1;
　　$max_p = $page_len;
　　}else{
　　if($page+$pageoffset>=$pages+1){
　　$init = $pages - $page_len+1;
　　}else{
　　$init = $page-$pageoffset;
　　$max_p = $page + $pageoffset;
　　}
　　}
　　}
　　for($i=$init;$i<=$max_p;$i++){
　　if($i==$page){
　　$key.="[ ".$i." ]";
　　}else{
　　$key.="$i";
　　}
　　}
　　if($i-1!=$page){
　　$key.="下一页";
　　$key.="最后一页";
　　}else{
　　$key.="下一页";
　　$key.="最后一页";
　　}
　　echo "";
　　echo "".$key."";
　　echo "";
?>