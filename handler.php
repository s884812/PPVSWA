<html>
<head>
<title>驗證</title>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf8">
</head>
<body>

	<?php
	if((filter_var($_POST['name'],FILTER_VALIDATE_EMAIL) == true) && $_POST['name'] && $_POST['passwd'] && $_POST['reason']) {
		require("config.php");
		require("functions.php");
		$db = mysql_connect($dbserver,$dbuser,$dbpassword);
		mysql_select_db($dbname,$db);	
		$ip = arrangeip();
		$sql = sprintf("INSERT INTO vpn(date,name,reason,passwd,ip,state) VALUES(NOW(),'$_POST[name]','$_POST[reason]','$_POST[passwd]','$ip',\"0\");");
		mysql_query($sql);
		echo "您的申請已收到，請等待站長審核或是 <a href=\"./selfservice.php\">使用啓動碼自行開通</a><br /> 注意：開通email也許會被丟入垃圾桶而非信件夾。。<br />另外請勿多次註冊。";
	}
	else {
		echo "錯誤。 <br />您沒有填入正確的email或是有其他錯誤。";
	}
	?>

</body>
</html>

