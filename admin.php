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
<script type="text/javascript" src="md5.js"></script>
<!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script-->
<script type="text/javascript">
function enAuth(id)
{
var url = "./auth.php?action=enauth&operateid=" + id
var sitepassword ="&sitepassword=<?php echo $_GET['sitepassword']; ?>"
url=url+sitepassword
url=url+"&random="+Math.random()
var div_id = "idstate" + id
loadState(url,div_id)
}

function deAuth(id)
{ 
var url = "./auth.php?action=deauth&operateid=" + id
var sitepassword ="&sitepassword=<?php echo $_GET['sitepassword']; ?>"
var div_id
url=url+sitepassword
url=url+"&random="+Math.random()
div_id = "idstate" + id
loadState(url,div_id)
}

/*function stateChanged(thing,div_id) 
{ 
 if (thing.readyState != 4 )
 { 
 document.getElementById(div_id).innerHTML="^_^"
 } 

 if (thing.readyState == 4 )
 { 
 document.getElementById(div_id).innerHTML= thing.responseText
 }
}
*/

function loadState(url,div_id)
{
var xmlHttp = GetXmlHttpObject();
//xmlHttp.onreadystatechange = stateChanged(xmlHttp,div_id);
document.getElementById(div_id).innerHTML = "N/A";
xmlHttp.open("GET",url,true);
xmlHttp.send(null);

/*$.get (url);
$(div_id).html("N/A");*/


}


function GetXmlHttpObject()
{
var xmlHttp=null;

try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}

function makemail(id)
{
var url
url = "mailmaker.php?sitepassword=<?php echo $_GET['sitepassword'];?>&mailid="
url = url + id
window.open (url, 'makemail', 'height=400, width=450, top=60, left=60, toolbar=no, menubar=no, scrollbars=yes, resizable=yes,location=yes, status=yes')
}
</script>
</head>
<body>
<script src="js/bootstrap.min.js"></script>
<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
					<a class="brand" href="/vpn">VPN管理系統</a>
					    <ul class="nav">
      <li><a href="./selfservice.php">認證啓動碼</a></li>
      <li><a href="<?echo $_SERVER['PHP_SELF']."?sitepassword=" . $_GET['sitepassword'];?>">管理員登入</a></li>

    </ul>
			</div>
		</div>
		<br>
		<br>
<?php
require ("config.php");
$sitepassword = md5(md5($sitepassword,false),false);
if ($_GET['sitepassword'] == $sitepassword)
{	
	$db = mysql_connect($dbserver,$dbuser,$dbpassword);
	mysql_select_db($dbname,$db);
	$sql = "SELECT * FROM vpn ORDER BY date DESC ;";
	$result = mysql_query($sql);
	echo "<div class=\"container-fluid\"><div class=\"row-fluid\"><div class=\"span12\"><ul class=\"nav nav-pills\"><li class=\"active\"><a href=\"./index.php\">Home</a></li><li><a href=\"javascript:makemail('ALL')\">發送訊息給所有用戶</a></li><li><a href=\"./auth.php?action=rebuildsecret&sitepassword=" . $_GET['sitepassword']."\">重新生成chap-secrets檔案</a></li><li><a href=\"./viewkey.php?sitepassword=" . $_GET['sitepassword']."\">查看尚未使用的啓用碼</a></li><li><a href=\"./auth.php?action=analyzelog&sitepassword=" . $_GET['sitepassword']."\">查看使用紀錄檔案</a></li><li><a href=\"./changepw.php?sitepassword=" . $_GET['sitepassword']."\">更改用戶密碼</a></li><li><a href=\"./adduser.php?sitepassword=" . $_GET['sitepassword']."\">新增用戶</a></li><li><a href=\"./deluser.php?sitepassword=" . $_GET['sitepassword']."\">刪除用戶</a></li><li class=\"disabled\"><a href=\"#\">注意:啟動、停用用戶以及更改用戶密碼之後請重新生成chap-secrets檔案喔！</a></li></li> </ul></div></div> </p><table class=\"table table-bordered\" width=\"100%\" border=\"1\"><tr><th>ID</th><th>email</th><th>密碼</th><th>IP</th><th>DateTime</th><th>開通理由（若是使用啓動碼，則顯示啓動碼）</th><th>Time</th><th>使用流量</th><th>狀態（1為開通）</th><th>操作</th></tr>";
	//echo "<h4>PPTP VPN管理系統</h4><p><a href=\"javascript:makemail('ALL')\">發送訊息給所有用戶</a>    <a href=\"./auth.php?action=rebuildsecret&sitepassword=" . $_GET['sitepassword'] . "\">重新生成chap-secrets檔案</a>     <a href=\"./viewkey.php?sitepassword=" . $_GET['sitepassword'] . "\">查看尚未使用的啓用碼</a>   <a href=\"./auth.php?action=analyzelog&sitepassword=" . $_GET['sitepassword'] . "\">查看使用紀錄檔案</a>  <a href=\"changepw.php?sitepassword=" . $_GET['sitepassword'] .  "\">更改用戶密碼</a> <a href=\"adduser.php?sitepassword=" . $_GET['sitepassword'] .  "\">新增用戶</a> <a href=\"deluser.php?sitepassword=" . $_GET['sitepassword'] .  "\">刪除用戶</a> <br />注意:啟動、停用用戶以及更改用戶密碼之後請重新生成chap-secrets檔案喔！</p><table width=\"100%\" border=\"1\"><tr><th>ID</th><th>email</th><th>密碼</th><th>IP</th><th>DateTime</th><th>開通理由（若是使用啓動碼，則顯示啓動碼）</th><th>Time</th><th>使用流量</th><th>狀態（1為開通）</th><th>操作</th></tr>";
	while ($row = mysql_fetch_assoc($result)) 
		{
		echo "<tr><td><h4>" . $row['id'] . " </h4></td><td> " . $row['name'] . " </td><td>" . $row['passwd'] . "</td><td> "  . $row['ip'] . "</td><td>" . date("D j F Y g.iA", strtotime($row['date'])) . "</td><td>";
		echo $row['reason'];
		echo "</td><td>" . $row['time'] . "</td><td>" . $row['data'] . "</td><td id=\"idstate" . $row['id'] . "\">" . $row['state'] . "</td><td><a href=\"javascript: enAuth(" . $row['id'] . ")\">開通</a><br /><a href=\"javascript: deAuth(" . $row['id'] . ")\">停用</a><br /><a href=\"javascript:makemail(" . $row['id'] . ")\">發送Email給他</a></td></tr>";

}
		echo "</table>";
}
else 
//echo "<br>";
//echo "<br>";
echo "<script type=\"text/javascript\" src=\"md5.js\"></script><form action=\"./admin.php\" method=\"GET\"><table><p>管理員登入</p><tr><td><input type=\"password\" name=\"sitepassword\" id=\"sitepassword\" value=\"\" /></td></tr><tr><td><input type=\"submit\" class=\"btn btn-primary\" value=\"Login\" onclick=\"encode()\" /></td></tr></table></form>";
?>
</body>
</html>
