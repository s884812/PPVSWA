<html>
<head>
<title></title>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf8">
</head>
<body>

<?php

function enauth($enauthid)
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$sql = "UPDATE vpn SET state = 1 WHERE id = " . $enauthid . ";";
	mysql_query($sql);
	$result = mysql_query($sql);
	$sql = "SELECT * FROM vpn WHERE id = " . $enauthid . ";";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);

	$mailsubject = "VPN :已開通";
	$mailbody = "您好：您在 " . $sitename . " 的VPN帳號已經被順利開通囉！\n\n您的賬號是：" . $row['name'] . "\n您的密碼是：" . $row['passwd'] . "\nVPN IP是：" . $vpnaddress . " \n\n". $sitename . "，我們的VPN是基於PPTP協定，若不會設定，請上網Google  PPTP連線方式。";
	$mailheaders = "From: " . $sitename . "<" . $siteemail . ">";
	mail($row['name'],$mailsubject,$mailbody,$mailheaders);
}


function selfenauth($name,$key)
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$sql = "UPDATE vpn SET state = 1 , reason = '" . $key . "' WHERE name = '" . $name . "';";
	mysql_query($sql);
	$result = mysql_query($sql);
	$sql = "SELECT * FROM vpn WHERE name = '" . $name . "';";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);

	$mailsubject = "VPN :已開通";
	$mailbody = "您好：您在 " . $sitename . " 的VPN帳號已經被順利開通囉！\n\n您的賬號是：" . $row['name'] . "\n您的密碼是：" . $row['passwd'] . "\nVPN IP是：" . $vpnaddress . " \n\n". $sitename . "，我們的VPN是基於PPTP協定，若不會設定，請上網Google  PPTP連線方式。";
	$mailheaders = "From: " . $sitename . "<" . $siteemail . ">";
	mail($row['name'],$mailsubject,$mailbody,$mailheaders);
	
	rebuildsecret();
	$sql = "UPDATE `vpn`.`key` SET state = 2 WHERE value = '" . $key . "';";	
	mysql_query($sql);
}




function deauth($deauthid)
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$sql = "UPDATE vpn SET state = 0 WHERE id = " . $deauthid . ";";
	mysql_query($sql);
	$result = mysql_query($sql);
	$sql = "SELECT * FROM vpn WHERE id = " . $deauthid . ";";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);

	$mailsubject = "VPN :已暫停";
	$mailbody = "您好：您在" . $sitename . "的VPN賬號已被暫停。\n\n您的賬號是：" . $row['name'] . "\n您的密碼是：" . $row['passwd'] . "\nVPN IP是：" . $vpnaddress . "\n\n有任何問題請通知我們。" . $siteemail ;
	$mailheaders = "From: " . $sitename . "<" . $siteemail . ">";
	mail($row['name'],$mailsubject,$mailbody,$mailheaders);
}

function rebuildsecret()
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);
	$sql = "SELECT * FROM vpn WHERE state = 1 ORDER BY date ASC;";
	$result = mysql_query($sql);
	$secretfile = fopen($secretfile,"w") or exit("ERROR Opening Secret File. " . $secretfile);
	while ($row = mysql_fetch_assoc($result))
		{
		$secretrow = $row['name'] . "  " . $vpnname . "  " . $row['passwd'] . "  " . $row['ip'] . " \n";
		fwrite($secretfile,$secretrow);
		}
	$oldfile = file_get_contents($oldsecretfile);
	fwrite($secretfile,$oldfile);
	fclose($secretfile);
}

function fallback()
{
echo "啓動失敗。<br />也許是您輸入了錯誤的賬號或是密碼<br />";
echo "<script type=\"text/javascript\" src=\"md5.js\"></script><form action=\"./admin.php\" method=\"GET\"><table><p>管理員登入</p><tr><td><input type=\"password\" name=\"sitepassword\" id=\"sitepassword\" value=\"\" /></td></tr><tr><td><input type=\"submit\" value=\"Login\" onclick=\"encode()\" /></td></tr></table></form>";
}


function newkey()
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	for ($i=0;$i<=4;$i++) 
	{
	$newkey = uniqid();
	$sql = "INSERT INTO  `vpn`.`key` (`value` ,`state`) VALUES ('" . $newkey . "',  '1');";
	mysql_query($sql);
	echo $newkey . "<br />";
	}
}


function verifykey($key)
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$sql = "SELECT * FROM `vpn`.`key` WHERE value = '" . $key . "';";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	if ($row['state'] == 1) return TRUE;else return FALSE;
}


function checkstate($name)
{
	require("config.php");
	analyzelog();
	analyzesublog();
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$sql = "SELECT * FROM vpn WHERE name = '" . $name . "';";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	if ($row['state'] == 1) $message = "親愛的客戶您好：您的賬號已被順利開通。<br/>您的賬號是：" . $row['name'] . "<br/>您的密碼是：" . $row['passwd'] . "<br/>VPN IP是：" . $vpnaddress . "<br/>您在此VPN上的IP為：" . $row['ip'] . "<br />您在此VPN上的IP為：" . $row['time'] . " 分鐘, 使用流量： " . $row['data'] . " bytes of data. ";
	else $message = "您好：您的賬號已被暫停。<br/>您的賬號是：" . $row['name'] . "<br/>您的密碼是：" . $row['passwd'] . "<br/>VPN IP是：" . $vpnaddress . "<br/>您在此VPN上的IP為：" . $row['ip'] . "<br />您在此VPN上的IP為：" . $row['time'] . " 分鐘, 使用流量：  " . $row['data'] . " bytes of data. ";
	echo $message;
}


function checkexist($name)
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$sql = "SELECT * FROM vpn WHERE name = '" . $name . "';";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	if ($row['name']) return TRUE;else return FALSE;
}


function usekey($name,$key)
{
	if (verifykey($key) == TRUE)
	{
	if (checkexist($name) == TRUE) selfenauth($name,$key);else exit("賬號不存在，請先註冊。");
	}
	else exit("此啓動碼以備使用或是無效。");
	echo "帳號： " . $name . " 已成功啓用。";
}

function listkey()
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$sql = "SELECT * FROM `vpn`.`key` WHERE state = 1;";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_assoc($result)) 
	{
	echo $row['value'] . "<br />";
	}
}


function sendmessage($id,$message)
{	
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$sql = "SELECT * FROM vpn WHERE id = " . $id . " ;";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	$mailto = $row['name'];
	$mailsubject = "VPN :Message";
	$mailbody = "您好：您收到這個Email因為您是 " . $sitename . "的 PPTP VPN 用戶。\n\n您的賬號是：" . $row['name'] . "\n您的密碼是：" . $row['passwd'] . "\n您在VPN上的IP是：" . $vpnaddress . "\n您使用了 " . $row['time'] . " 分鐘, 傳輸了 " . $row['data'] . " bytes 的流量. \n\n我們傳送給您的訊息：\n\n" . $message;
	$mailheaders = "From: " . $sitename . "<" . $siteemail . ">";
	mail($row['name'],$mailsubject,$mailbody,$mailheaders);
	echo "已經發送Mail給 ID " . $row['id'] . ".<br />";
}

function arrangeip()
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$sql = "Select id from vpn order by id DESC limit 1;";
	mysql_query($sql);
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	sscanf ($maxip,"%d.%d.%d.%d",$ip_8,$ip_16,$ip_24,$ip_32);
	$ip_32 = $ip_32 - $row['id'];
	$string = $ip_8 . "." . $ip_16 . "." . $ip_24 . "." . $ip_32;
	if (($ip_32 <= 1) || $ip_32 >= 255) return "*";
	else return ($string);
}

function analyzesublog()
{
	require("config.php");
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);	
	$log = file($sublogfile) or exit("開啟 sublogfile 時發生錯誤.");
	foreach ($log as $row)
	{
	$string = explode(" ",$row);
	sscanf ($string[3],"%d.%d.%d.%d",$ip_8,$ip_16,$ip_24,$ip_32);
	$logip = "ip_" . $ip_24 . "_" . $ip_32;

	if ($$logip) continue;
	$$logip = 1;
	$time = 0;
	$data = 0;
	foreach ($log as $subrow) 
		{
		$substring = explode(" ",$subrow);
		if ($string[3] == $substring[3])
			{
			$time += $substring[5];
			$data += $substring[4];
			$curkey = (key($log) - 1);
			unset($log[$curkey]);
			
			}
		}
	
	$sql = "UPDATE vpn SET time = " . $time . " , data = " . $data . " WHERE ip = '" . $string[3] . "';";
	mysql_query($sql);
//	echo $string[3] . " " . $time . " " . $data . "<br/>";
//	echo "<br/>";
	}
}



function analyzelog()
{
	require ("config.php");
	$newlog = file($logfile) or exit("開啟 logfile 時發生錯誤。");
	$targetfile = fopen($sublogfile,"a")  or exit("開啟 sublogfile 時發生錯誤。");
	$oldlog = file($analyzedlogfile) or exit("開啟 analyzedlogfile 時發生錯誤。");
	$diflog = array_diff($newlog,$oldlog);
	unset ($newlog);
	unset ($oldlog);
//	fwrite($targetfile,"#This sublog is generated by PPVSWA after analizing " . $logfile . "\n");
	foreach ($diflog as $row)
	{
	$row = str_replace("  "," ",$row);
	$string = explode(" ",$row);
	if (strncasecmp($string[4],"pppd",4) == 0) 
		{
		if (strncasecmp($string[5],"remote",6) == 0)
			{
			$ip =substr($string[8],0,-1);
			
			foreach ($diflog as $subrow)
				{
					$subrow = str_replace("  "," ",$subrow);
					$substring = explode(" ",$subrow);

					if (($substring[4] == $string[4])&&($substring[8] == "minutes.\n")) {$subtime = $substring[7];
					$curkey = key($diflog);
					unset($diflog[$curkey]);}
					if (($substring[4] == $string[4])&&($substring[10] == "bytes.\n")) 
					{
					$gonawrite = $substring[0] . " " . $substring[1] . " " . $substring[2] . " " . $ip . " " . ($substring[6] + $substring[9]) . " " . $subtime . "\n";
//					echo $gonawrite . "<br/>";
					fwrite($targetfile,$gonawrite);
					$curkey = (key($diflog) - 1);
					unset($difblog[$curkey]);

					break;
					}
					
					
				}
			}
		}
	else   {
	$curkey = (key($diflog) - 1);
	unset($diflog[$curkey]);
		}
	}
	fclose($targetfile);
	if (copy($logfile,$analyzedlogfile) != 1) 
	{
	$targetfile = fopen($sublogfile,"w");
	fclose($targetfile);
	$targetfile = fopen($analyzedlogfile,"w");
	fwrite($targetfile,"-1\n");
	fclose($targetfile);
	exit ("錯誤： 備份當前Log檔案時發生錯誤。 所有的 SubLogs 都已被刪除。. 將在下次重建. 請確保 '" . $analyzedlogfile ."' 是可以寫入的。");
	}
}


?>

</body>
</html>