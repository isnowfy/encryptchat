<?php    
$con =@mysql_connect("localhost","user","pass")or die("数据库服务器连接失败！");  
@mysql_select_db("database") or die("数据库不存在或不可用！");  
mysql_query("SET NAMES 'utf8'");  
mysql_query("SET CHARACTER_SET_CLIENT=utf8");  
mysql_query("SET CHARACTER_SET_RESULTS=utf8");  
//设定用于一个脚本中所有日期时间函数的本地默认时区，否则会有8小时时间差  
$timezone_identifier = "PRC";  //本地时区标识符  
date_default_timezone_set($timezone_identifier);  
?>  
