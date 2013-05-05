<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<title>VPN管理系統</title>
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
<style type="text/css">
body {
background-color: #fff4f4;
font-family: sans-serif;
color: teal;
}
h4 {
color: navy;
}

</style>
</head>
<body>
<script src="js/bootstrap.min.js"></script>
<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
					<a class="brand" href="/vpn">VPN管理系統</a>
					    <ul class="nav">
      <li><a href="./selfservice.php">認證啓動碼</a></li>
      <li><a href="./admin.php">管理員登入</a></li>

    </ul>
			</div>
		</div>
<?php
/* This file outputs a HTML form for email editing.*/
require("config.php");
require("functions.php");
$sitepassword = md5(md5($sitepassword,false),false);
if ($_GET['sitepassword'] == $sitepassword)
{
	echo "<br>";
	echo "<br>";
	echo "<form action=\"./mailsender.php\" method=\"POST\"><table><h4>發送訊息</h4><tr><td>給： </td><td><input type=\"text\" name=\"mailid\" value=\"" . $_GET['mailid'] . "\" /></td></tr><td>內容： </td><td><textarea name=\"mailbody\" rows=\"8\" cols=\"40\"></textarea></td></tr><tr><td><input type=\"hidden\" name=\"sitepassword\" value=\"" . $_GET['sitepassword'] . "\"></td><td><input type=\"submit\" class=\"btn btn-primary\" value=\"發送\" /></td></tr></table></form>";
}
else 
{
	echo "Incorrect Password.";
	fallback();
}
?>
</body></html>
