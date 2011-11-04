<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<title>Chat room</title> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<script type="text/javascript" src="http://crypto-js.googlecode.com/files/2.3.0-crypto-md5.js"></script>
<script type="text/javascript" src="http://crypto-js.googlecode.com/files/2.4.0-crypto-sha1-hmac-pbkdf2-blockmodes-aes.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script> 
<script> 
room="";
user="";
password=""
function encrypt(myuser,mykey){
	user=myuser;
	password=mykey;
	$('#pass').fadeOut();
	$('#send').fadeIn();
	room=Crypto.MD5(mykey,{asString:true});
	chat('<?php echo date("Y-m-d H:i:s", time() + 0 * 3600);?>','<?php echo microtime(TRUE);?>');
}
function htmlEncode(value){
	return $('<div/>').text(value).html();
}
function doRequest(msg) {
    $.ajax({
	   type: "GET",
	   data: "id="+user+"&room="+room+"&msg="+Crypto.AES.encrypt(msg,password),
	   dataType: "json",
	   url: "protected/backend.php",
	   success: function(msg){
	   }
	});
}
function chat(timestamp,stamp) {
	$.ajax({
	   type: "GET",
	   data: "time="+timestamp+"&room="+room+"&stamp="+stamp,
	   dataType: "json",
	   url: "protected/backend.php",
	   success: function(msg){
		 chat(msg.timestamp,msg.stamp);
		 var timestamp=msg.timestamp;
		 var stamp=msg.stamp;
		 $('#content').append('<div><em>'+timestamp+' <font color="#FF0000">'+msg.user+':</font></em>' + Crypto.AES.decrypt(msg.msg,password) + '</div>');
	   },
	   error: function(msg){
		 chat(timestamp,stamp);
	   }
	});
}
</script> 
</head> 
<body> 
<div class="wrapper">
<span id="content" style="display:block;width:400px;height:300px;overflow:auto"></span> 
<p> 
    <form id="send" style="width:300px;display:none" action="" method="get" onsubmit="var tmp=$('#word').val().replace(/\?/g,'？');doRequest(tmp);$('#word').val('');return false;"> 
      <input style="width:250px" type="text" name="word" id="word" value="" /> 
      <input type="submit" name="submit" value="Send" /> 
    </form> 
    <form id="pass" action="" method="get" onsubmit="encrypt($('#user').val(),$('#pass').val());return false;"> 
      pass:<input type="text" name="pass" id="pass" value="" /> 
      user:<input type="text" name="user" id="user" value="" />
      <input type="submit" name="submit" value="save" /> 
    </form> 
</p> 
</div>
</body> 
</html>