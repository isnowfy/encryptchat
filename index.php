<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<title>Chat room</title> 
<style type="text/css">html,body{
 width:100%;
 height:100%;
 margin:0px;
 padding:0px;
 background-color:#F0F7FF;
}
</style>
<script src="crypto.js" type="text/javascript"></script>
<script src="http://cdn.jqmobi.com/jq.mobi.min.js" type="text/javascript"></script> 
<script> 
room="";
user="";
password=""
function encrypt(myuser,mykey){
	user=myuser;
	password=Crypto.MD5(mykey+"password");
	$('#pass').toggle();
	$('#ss').toggle();
        $('#content').toggle();
	room=Crypto.MD5(mykey);
	chat('<?php echo date("Y-m-d H:i:s", time() + 0 * 3600);?>','<?php echo microtime(TRUE);?>');
}
function doRequest(msg) {
    $.ajax({
	   type: "POST",
	   data: {id:user,room:room,msg:Aes.Ctr.encrypt(msg,password,256)},
	   dataType: "json",
	   url: "protected/backend.php",
	   success: function(msg){
	   }
	});
}
function chat(timestamp,stamp) {
	$.ajax({
	   type: "POST",
	   data: {time:timestamp,room:room,stamp:stamp},
	   dataType: "json",
	   url: "protected/backend.php",
	   success: function(msg){
		 chat(msg.timestamp,msg.stamp);
		 var timestamp=msg.timestamp;
		 var stamp=msg.stamp;
		 div=document.getElementById('content');
		 div.innerHTML=div.innerHTML+'<div><em>'+timestamp+' <font color="#FF0000">'+msg.user+':</font></em>' + 
		 Aes.Ctr.decrypt(msg.msg,password,256) + '</div>';
		 div.scrollTop=div.scrollHeight;
	   },
	   error: function(msg){
		 chat(timestamp,stamp);
	   }
	});
}
</script> 
</head> 
<body> 
<div>
    <form id="pass" action="" method="get" onsubmit="encrypt($('#user').val(),$('#pass0').val());return false;"> 
      pass:<input type="text" name="pass" id="pass0" value="" /><br /> 
      user:<input type="text" name="user" id="user" value="" /><br />
      <input type="submit" name="submit" value="save" /> 
    </form> 
</div>
<div id="content" style="display:none;width:100%;overflow:auto;position:absolute;bottom:25px;top:0;"></div> 
<div id="ss" style="width:100%;display:none;position:absolute;bottom:0;border-up:1px solid #D9D9D9;">
    <form id="send" action="" method="get" onsubmit="var tmp=$('#word').val();doRequest(tmp);$('#word').val('');return false;"> 
      <input style="width:99%;" type="text" name="word" id="word" value="" /> 
    </form> 
</div>
</body> 
</html>
