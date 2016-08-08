<?php 
/*****

作者：何刚
QQ：490836716

*/
class page_list_class{//实现分页类
	 var   $list_arr;//所有记录的数组
	 var $counttotal;//记录数//
	 var $count_page;//页数//
	 var $apage_count;//每页记录数//
	 var $thepage;//当前页//
	 var $nextpage;//下一页
	 var $lastpage;//上一页//
	 var $endpage;//尾页
	var $startpage=1;//首页
	var $page_list;//页面链接列表
	  function __construct($sqlall,$p_count="",$p_num="")
		{
	
	
	
	
	
	
    if($p_count=="")
   {$p_count=5;}
      $this->apage_count=$p_count;//每页记录数
	  
   if($p_num=="")
   {$p_num==1;}
   if($p_num==1||$p_num=="")
   {
   $this->lastpage=0;
   }
   else
   {
    $this->lastpage=$p_num-1;
  
   }
   
   $limtstart=($p_num-1)*$p_count;
  $sql=$sqlall." limit  ".$limtstart.",".$p_count."  ";
    $sql_all=mysql_query($sqlall);
    $sql_r=mysql_query($sql);
	$count=mysql_num_rows($sql_all);
		$thecount=mysql_num_rows($sql_r);

	$this->counttotal=$count;
	$pf=$count/$p_count;
	$p=(int)$pf;
	if($p<$pf)
	{$p=$p+1;}
	$this->count_page=$p;//总页数
 $this->endpage=$p;//尾页

	if($p_num>=$p)
	{
	$nextpage=0;
	}
	else
	{
	$nextpage=$p_num+1;
	}
	if($thecount>0)
  { $this->thepage=$p_num;}//当前页
	else
	{
	$this->thepage=1;
	}
	$this->nextpage=$nextpage;
	
	
	$i=0;
	while($bill_list=mysql_fetch_array($sql_r))
	{
	
	$bill_info[$i]=$bill_list;
	$i++;
	}
   $this->list_arr=$bill_info;
   
   
   
  
	   $astr=  $_SERVER['PHP_SELF']."?";

	
   $geturl=$_GET;
   foreach ($geturl as $get=>$getvalue)
   {
   if($get!="p_num")
  { 
  $astr.=$get."=".$getvalue."&";//带get参数的链接地址
  }
   }
   if($p>1){	//p>1开始
   $p_list="<ul>";

   $p_list.="<li><a href=\"".$astr."p_num=1\" >首页</a></li>";
      $p_list.="<li><a href=\"".$astr."p_num=".$p."\" >末页</a></li>";
  
  
	    if($this->nextpage!=0)
		{
     $p_list.="<li><a href=\"".$astr."p_num=".$this->nextpage."\" >下一页</a></li>";
		
		}

 if($this->lastpage!=0)
		{
     $p_list.="<li><a href=\"".$astr."p_num=".$this->lastpage."\" >上一页</a></li>";
		
		}
	
      $p_list.="</ul>";
	
    $p_list.="<ul>";
	if($p<10)//<if1>
  
	{ 
	for($pi=1;$pi<=$p;$pi++)
	{
  
		$atext=$pi;

   
	if($this->thepage==$pi)
   {
   $class=" class=\"thispage\" ";
   }
   
   else
   {
   $class=" ";
   }
   $p_list.="<li ".$class.">";
      $p_list.="<a href=\"".$astr."p_num=".$pi."\" >".$atext."</a>";

         $p_list.="</li>";

   }
  }//</if1>
  else
  {
  
  
	for($pi=1;$pi<=4;$pi++)
   {
  
    $atext=$pi;

   
   if($this->thepage==$pi)
   {
   $class=" class=\"thispage\" ";
   }
   
   else
   {
   $class=" ";
   }
   $p_list.="<li ".$class.">";
      $p_list.="<a href=\"".$astr."p_num=".$pi."\" >".$atext."</a>";

         $p_list.="</li>";

   }
  /////////////////
     $p_list.="<li>";
     $p_list.="<select style=\" border:0px;width:60px;margin:0px;padding:0px;height:20px;overflow:auto;\" onchange=\"window.location=this.value; \" >";
       $p_list.="<option value=\"#\">更多</option>";

  for($pi=5;$pi<$p-4;$pi++)
   {
  
    $atext=$pi;

   
   if($this->thepage==$pi)
   {
   $class=" selected=\"selected\" ";
   }
   
   else
   {
   $class=" ";
   }
   $p_list.="<option  value=".$astr."p_num=".$pi." ".$class.">";
      $p_list.="...".$atext."...";

         $p_list.="</option>";

   }        
   $p_list.="</select>";

  //////////////////
  for($pi=$p-4;$pi<=$p;$pi++)
   {
  
    $atext=$pi;

   
   if($this->thepage==$pi)
   {
   $class=" class=\"thispage\" ";
   }
   
   else
   {
   $class=" ";
   }
   $p_list.="<li ".$class.">";
      $p_list.="<a href=\"".$astr."p_num=".$pi."\" >".$atext."</a>";

         $p_list.="</li>";

   }
  //////////////////////
  
  
  }
 }  //p<1结束
 $p_list.="</ul>";
            $p_list.="<ul>";
			$p_list.="<li>"."共".$this->count_page."页";
			$p_list.=$this->counttotal."个记录";
			$p_list.="</li>";
			
          $p_list.="</ul>";

   
   $this->page_list=$p_list;
   }
   
  
   
  // 
   
   
   
}

/***按id删除数据start***/
function delete_byid($tb,$id)
{
	$sql="delete from ".$tb." where id='".$id."'";
	return mysql_query($sql);
}
/***按id删除数据end***/

/***按id删除数据start***/
function delete_by($tb,$col,$v)
{
	$sql="delete from ".$tb." where ".$col."='".$v."'";
	
	return mysql_query($sql);
}
/***按id删除数据end***/

/***按id修改数据start***/
function update_byid($tb,$col,$value,$wid)
{
	$sql="update ".$tb." set ".$col."='".$value."' where id='".$wid."'";
	return mysql_query($sql);
}
/***按id修改数据end***/



/***按某个字段单独修改数据start***/
function update_one($tb,$col,$value,$where_col,$where_value)
{
	$sql="update ".$tb." set ".$col."='".$value."' where ".$where_col."='".$where_value."'";
	return mysql_query($sql);
}
/***按某个字段单独修改数据end***/

function arr_update($tb,$arr,$wherename,$wherevalue)//按id修改记录和多个字段。
{
   

$sql="update ".$tb." set ";
$sql1="";
foreach($arr as $arrkey=>$arrvalue)
{
    $sql1.=", `".$arrkey."`='".$arrvalue."'  ";
    }
    $sql1=substr($sql1,1);//去除第一个字符“,”
    $sql.=$sql1;
    $sql.=" where ".$wherename."='".$wherevalue."'";
	//echo $sql;
	//echo "<br />";
    $result=mysql_query($sql);
    return $result;
 }
 
 function arr_update2($tb,$arr,$wherename,$wherevalue,$wherename2,$wherevalue2)//按id修改记录和多个字段。
{
   

$sql="update ".$tb." set ";
$sql1="";
foreach($arr as $arrkey=>$arrvalue)
{
    $sql1.=", `".$arrkey."`='".$arrvalue."'  ";
    }
    $sql1=substr($sql1,1);//去除第一个字符“,”
    $sql.=$sql1;
	$sql2="";
	$sql.="  where ".$wherename."='".$wherevalue."' and  ".$wherename2."='".$wherevalue2."' ";

	//echo $sql;
    $result=mysql_query($sql);
    return $result;
 }
 
 /****将POST参数转成函数 arr_insert 可用的数组并执行*/
 function insertpostarr($tb,$a){
$count=count($a);
$b=array();
for($i=0;$i<$count;$i++){
$key=$a[$i];
$b[$key]=trim($_POST[$key]);
	
}
arr_insert($tb,$b);
}

 function insertpostsarr($tb,$a,$tk){////////////////////////////////////////////

$inkeyarr=$_POST[$tk];
$incount=count($inkeyarr);

for ($i=0;$i<$incount;$i++){
	$b=array();
	$tki=trim($_POST[$tk][$i]);
	if($tki){
	for($j=0;$j<count($a);$j++){
		$key=$a[$j];
		$b[$key]=trim($_POST[$key][$i]);
	}
	arr_insert($tb,$b);

}
}


	
}







/***按字段数组和值数组插入数据start***/
function arr_insert($tb,$arr)//按数组键名对应该字段名，数组值对应字段值插入数据。
 {
    $insert_sql="insert into ".$tb;
	foreach($arr as $key=>$va)
		{
			$key="`".trim($key)."`";
			$va=trim($va);
		
			$col_sql.=",".$key;
			$val_sql.="','".$va;
		}
		 $col_sql.=")";
	 	 $val_sql.="')";
         $col_sql=substr($col_sql,1);//去除第一个字符“,”
         $val_sql=substr($val_sql,2);//去除前两个字符“',”
         $col_sql=" (".$col_sql;//前面加上“(”
         $val_sql="values (".$val_sql;//前面加上“values (”
		 $insert_sql.=$col_sql." ".$val_sql;
		//echo $insert_sql;
		// echo "<br />";
	   	return mysql_query($insert_sql);/*返回是否插入数据成功*/
       
 }

/***按字段数组和值数组插入数据end***/



/***将记录转换成数组start**函数执行查询的sql语句后从结果集中取得每一行作为关联数组，或数字数组，或二者兼有，最后返回一个二维数组*/
function rd_to_arr($find_sql)
		{
		
		$customer_list = array();
		$customer_i=0;
		$result=mysql_query($find_sql);
		while($c_obj=mysql_fetch_array($result))
		{$customer_list[$customer_i]= $c_obj;
		$customer_i++;
		}

		return $customer_list;
		}
/***将记录转换成数组end***/



/***查找数据（与）start***/

/***查找数据（与）end***/

/***查找数据（或）start***/

/***查找数据（或）end***/




function get_one_row($tb,$col_name,$col_value)
{
    $sql="select *  from ".$tb." where ".$col_name."='".$col_value."'";
    $result=mysql_query($sql);
	$rows=mysql_num_rows($result);
	if($rows>0){
    $row=mysql_fetch_array($result);
    return $row;
	}
	else{
	return 0;
	}
    }
	
	
	
	


function get_AllRecord_arr($tb,$col_name,$col_value)
{	
	//$AllRecord_ar=
    $sql="select *  from ".$tb." where ".$col_name."='".$col_value."'";
    $result=mysql_query($sql);
	$i=0;
	while($row=mysql_fetch_array($result))
	{
	$AllRecord_ar[$i]=$row;
	$i++;
	}   

    return $AllRecord_ar;
    }

function set_encoding($filerott,$mb_encoding)//转换成需要的编码格式
				{	
				$zfbm11=mb_detect_encoding($filerott,array("ASCII","UTF-8","GB2312","GBK","BIG5"));
                if($zfbm11!=$mb_encoding) 
					{$filerott=iconv($zfbm11,$mb_encoding,$filerott); }
					return $filerott;
					}
					
function get_day($x,$time="",$t="")//获取某一天的前后几天
{
if($time=="")
{$time=date('Y-m-d');}
if($t=="")
{$gettime=date("Y-m-d",strtotime($time)+60*60*24*$x);}
else
{
$gettime=date($t,strtotime($time)+60*60*24*$x);
}
return $gettime;
}					








function getproduct($get="kfs",$get1=""){//获取产品型号
$arr=array();
if($get=="kfs")
{
$sql="select * from tb_product_number where product_supplier='".$get1."'";
}
else 
{
$sql="select * from tb_product_number  where product_version_name='".$get1."'";
}


	if(!empty($_GET['p_num'])&&(int)$_GET['p_num']>0)
		{
		$page_num=$_GET['p_num'];
		}
		else 
		{
		$page_num=1;
		}
		
 
	if(!empty($_GET['p_count']))
		{
		$page_count=$_GET['p_count'];
		}
		else 
		{
		$page_count=50;
		}
		

 $p_listobj= new page_list_class($sql,$page_count,$page_num);
 
  $p_list=$p_listobj->list_arr;
  
 $p_list['pagelist']=$p_listobj->page_list;

return $p_list;

}






	 function seturl($g,$v,$g1="",$v1=""){//修改某个参数的链接
	 $thisurl=  $_SERVER['PHP_SELF']."?";	   
	      $geturl=$_GET;
		  $astr="";
   foreach ($geturl as $get=>$getvalue)
   {
   if($get!=$g&&$get!=$g1)
  { 
  $astr.=$get."=".$getvalue."&";//带get参数的链接地址
  }
  }
  if($g!=""&&$v!="")
  { 
  $astr.=$g."=".$v."&";//带get参数的链接地址
  }  
  if($g1!=""&&$v1!="")
  { 
  $astr.=$g1."=".$v1."&";//带get参数的链接地址
  } 
   
	   return  $thisurl.$astr;
	  } 
	   

function check_Privileges($str){
if($_SESSION['info_name']){
$info_name=$_SESSION['info_name'];
//echo $info_name;
}
$sql="SELECT * FROM `wh_admin_member` WHERE `info_name` = '".$info_name."' ";
$sq=mysql_query($sql);
$s=mysql_fetch_array($sq);
	$Privileges=$s['Privileges'];
	$pr=substr_count($Privileges,$str);
	if($pr>0){
	return true;
	}
	else{	return false;
}

}


function check_Privileges2($str){
if($_SESSION['info_name']){
$info_name=$_SESSION['info_name'];
//echo $info_name;
}
$sql="SELECT * FROM `wh_admin_member` WHERE `info_name` = '".$info_name."' ";
$sq=mysql_query($sql);
$s=mysql_fetch_array($sq);
	$Privileges=$s['privileges2'];
	$pr=substr_count($Privileges,$str);
	if($pr>0){
	return true;
	}
	else{	return false;
}

}

function check_strarr($str,$fgf,$word){
$a=explode($fgf,$str);
if (in_array($word,$a)){
return true;

}
else{ return false;}
}

function get_realname($uname){

$sql="SELECT * FROM `wh_admin_member` WHERE `info_name` = '".$uname."' ";
$sq=mysql_query($sql);
$s=mysql_fetch_array($sq);
$r=$sq['realname'];
return $r;

}

function get_acol($scol,$sval,$gcol){

$sql="SELECT * FROM `wh_admin_member` WHERE `".$scol."` = '".$sval."' ";
$sq=mysql_query($sql);
$s=mysql_fetch_array($sq);
$r=$s[$gcol];
return $r;

}


 function is_existed($tb,$c,$v){//检查数据是否存在
$sql="SELECT  * FROM  ".$tb." WHERE  ".$c."='".$v."' ";
$sq=mysql_query($sql);
$snum=mysql_num_rows($sq);
if($snum>0){return true;}
else{return false;}
}



 function get_rd_rows($tb,$c,$v){//检查数据是否存在
$sql="SELECT  * FROM  ".$tb." WHERE  ".$c."='".$v."' ";
$sq=mysql_query($sql);
$snum=mysql_num_rows($sq);

return $snum;


}
?>
