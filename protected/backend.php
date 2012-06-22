<?php

require_once "dbcon.php";
$msg = isset($_POST['msg']) ? $_POST['msg'] : '';
$room = isset($_POST['room']) ? $_POST['room'] : '';
$time = date("H:i:s", time() + 0 * 3600);
$id = isset($_POST['id']) ? $_POST['id'] : '';
$stamp = microtime(TRUE);
require_once "getsafe.php";
$id = PAPI_GetSafeParam($id, "", XH_PARAM_TXT);
$room = PAPI_GetSafeParam($room, "", XH_PARAM_TXT);
//$msg = PAPI_GetSafeParam($msg, "", XH_PARAM_TXT);
if ($msg != '')
{
	$sql = "INSERT INTO record (room,user,time,content,timestamp) VALUES ('$room','$id','$time','$msg','$stamp')";    
	@mysql_query($sql);
	$response = array();
	$response['msg']       = $msg;
	$response['timestamp'] = $time;
	$response['stamp'] = $stamp;
	echo json_encode($response);
	flush();
	die();
}
$deletetime = $stamp-3600*24;
$sql = "delete from record where timestamp<'$deletetime'";    
@mysql_query($sql);
$time = isset($_POST['time']) ? $_POST['time'] : '';
$time = PAPI_GetSafeParam($time, "", XH_PARAM_TXT);
$stamp = isset($_POST['stamp']) ? $_POST['stamp'] : '';
$stamp = PAPI_GetSafeParam($stamp, "", XH_PARAM_TXT);
$sql = "select * from record where timestamp>'$stamp' and room='$room' order by timestamp ASC";    
$result = @mysql_query($sql);
$row = @mysql_num_rows($result);
while ($row == 0)
{
	usleep(10000); // sleep 10ms to unload the CPU
	$result = @mysql_query($sql);
	$row = @mysql_num_rows($result);
}

// return a json array
$response = array();
$row = mysql_fetch_row($result);
//{
	$response['msg']       = $row[4];
	$response['user']      = $row[2];
	$response['timestamp'] = $row[3];
	$response['stamp']     = $row[5];
	echo json_encode($response);
	flush();
//}
?>
