<?php  
// �������ݿ�
header("Content-type:text/html;charset=utf-8");
  
$conn=@mysql_connect("101.200.179.166","sunnytest","sunnytest123")  or die(mysql_error());  
@mysql_select_db('zhongbao',$conn) or die(mysql_error()); 
// �ж�action  
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : ''; 
// �ϴ�ͼƬ  
if($action=='add'){  
    $image = mysql_escape_string(file_get_contents($_FILES['photo']['tmp_name']));  
    $type = $_FILES['photo']['type']; 
    var_dump($image);
    var_dump($type);
    $sqlstr = "insert into photo(type,binarydata) values('".$type."','".$image."')";  
    @mysql_query($sqlstr) or die(mysql_error());  
    header('location:upload_image_todb.php');  
    exit();  
// ��ʾͼƬ  
}elseif($action=='show'){  
    $id = isset($_GET['id'])? intval($_GET['id']) : 0;  
    $sqlstr = "select * from photo where imageid=$id";  
    $query = mysql_query($sqlstr) or die(mysql_error());  
    $thread = mysql_fetch_assoc($query);  
    if($thread){  
        header('content-type:'.$thread['type']);  
        echo $thread['binarydata'];  
        exit(); 
    }  
}else{  
// ��ʾͼƬ�б��ϴ���  
?>  
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">  
<html>  
 <head>  
  <meta http-equiv="content-type" content="text/html; charset=gbk">  
  <title> upload image to db demo </title>  
 </head>  
  
 <body>  
  <form name="form1" method="post" action="upload_image_todb.php" enctype="multipart/form-data">  
  <p>ͼƬ��<input type="file" name="photo"></p>  
  <p><input type="hidden" name="action" value="add"><input type="submit" name="b1" value="�ύ"></p>  
  </form>  
  
<?php  
    $sqlstr = "select * from photo order by imageid desc";  
    $query = mysql_query($sqlstr) or die(mysql_error());  
    $result = array();  
    while($thread=mysql_fetch_assoc($query)){  
        $result[] = $thread;  
    }  
    foreach($result as $val){  
        echo '<p><img src="upload_image_todb.php?action=show&id='.$val['imageid'].'&t='.time().'" width="150"></p>';  
    }  
?>  
</body>  
</html>  
<?php  
}  
?>
