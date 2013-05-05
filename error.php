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
		<br>
		<br>
<h1>請輸入以下所有空格，若你有啓動碼，可以直接在申請賬號之後自行啓用帳號。</h1><p>
<?php
/*This file outputs the form for application.*/
require ("config.php");
echo "<h4>這是提供" . $sitename . "的 PPTP VPN 服務頁面.  請填入底下所有的空格</h4><br />";
echo "<form action=\"./handler.php\" method=\"POST\">
<table>
<tr>
<td>請輸入Email</td>
<td><input type=\"text\" name=\"name\" value=\"\" /></td>
</tr>
<tr>
<td>密碼</td>
<td><input type=\"text\" name=\"passwd\" value=\"\" /></td>
</tr>
<tr>
<td>聯絡電話</td>
<td><textarea name=\"reason\" rows=\"8\" cols=\"40\"></textarea></td>
</tr>
<tr><td><input type=\"submit\" Class = \"btn btn-danger\" value=\"送出\" /></td></tr>
</table></form>";
?>

