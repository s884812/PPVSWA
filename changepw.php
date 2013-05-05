<html> 
<head> 
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
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
<form name="form1" method="post" action="<?echo $_SERVER['PHP_SELF']."?sitepassword=" . $_GET['sitepassword'];?>">
<br>
<br>
<br>
欲更改之帳號：<input type="text" name="data1"> 
<p>新密碼：&nbsp; <input type="text" name="data2"></p>
<p>&nbsp;<input type="hidden" name="id" value="1"><input type="submit" class="btn btn-danger" name="Submit" value="送出"> 
</p>
</form> 
</body> 
</html>

<?php
include "./config.php" ;
$sitepassword = md5(md5($sitepassword,false),false);
if ($_GET['sitepassword'] != $sitepassword)
{
echo "管理員密碼錯誤";
}else{

$link = mysql_pconnect($dbserver , $dbuser ,$dbpassword ) or die ("無法連接".mysql_error()); 
mysql_select_db($dbname, $link) or die ("無法選擇資料庫".mysql_error()); 
$sql1 = "UPDATE  `vpn` SET  `passwd` =  '$_POST[data2]' WHERE  `vpn`.`name` =  '$_POST[data1]' LIMIT 1;";
//UPDATE  `vpn` SET  `passwd` =  '$_POST[data2]' WHERE  `vpn`.`name` =  ''$_POST[data1]'' LIMIT 1
//$sql2 = "UPDATE `cdb_uc_members` SET `username` = '$_POST[data1]' WHERE `cdb_uc_members`.`uid` = '$_POST[data2]' LIMIT 1;";
mysql_query("SET NAMES 'utf8' ");
mysql_query($sql1, $link) or die ("無法修改".mysql_error()); 
//mysql_query($sql2, $link) or die ("無法修改".mysql_error());
mysql_close($link);
if ($_POST[data1] = $_POST[data1]){
echo $_POST[data1];
echo '用戶更改成功，別忘記要重新生成chap-secrets檔案哦！';
}else{
echo "尚未輸入欲更改之用戶名<br>";
}

}

//function changepw(){}

?>