<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<title>VPN啓用認證</title>
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
		<br>
		<div class="alert alert-info">
<h4>您可以在這邊操作包含確認賬號狀態、自動啓用VPN帳號的動作</h4><br />
</div>
<?php
require ("config.php");

//echo "<h4>您可以在這邊操作包含確認賬號狀態、自動啓用VPN帳號的動作</h4><br />";
echo "<form action=\"./selfauth.php\" method=\"POST\">
<div class=\"alert alert-success\">
<h4>輸入email以及啓動碼進行開通</h4><br />
</div>
<table>
<tr>
<td>你的Email：  </td>
<td><input type=\"text\"  name=\"name\" value=\"\" /></td>
</tr>
<tr>
<td>啓動碼：</td>
<td><input type=\"text\" name=\"key\" value=\"\" /></td>
</tr>

<tr><td><input type=\"submit\" class=\"btn btn-primary\" value=\"啟動！\" /></td></tr>
</table></form><br /><br />

<div class=\"alert alert-success\">
<h4>確認您的賬號狀態</h4><br />
</div>

<form action=\"./checkstate.php\" method=\"POST\">
<table>
<tr>
<td>你的Email：</td>
<td><input type=\"text\" name=\"name\" value=\"\" /></td>
</tr>

<tr><td><input type=\"submit\" class=\"btn btn-primary\" value=\"檢查\" /></td></tr>
</table></form>";
?>
