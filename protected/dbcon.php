<?php    
$con =@mysql_connect("localhost","user","pass")or die("���ݿ����������ʧ�ܣ�");  
@mysql_select_db("database") or die("���ݿⲻ���ڻ򲻿��ã�");  
mysql_query("SET NAMES 'utf8'");  
mysql_query("SET CHARACTER_SET_CLIENT=utf8");  
mysql_query("SET CHARACTER_SET_RESULTS=utf8");  
//�趨����һ���ű�����������ʱ�亯���ı���Ĭ��ʱ�����������8Сʱʱ���  
$timezone_identifier = "PRC";  //����ʱ����ʶ��  
date_default_timezone_set($timezone_identifier);  
?>  
