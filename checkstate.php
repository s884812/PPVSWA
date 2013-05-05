<?php
require ("functions.php");
if (filter_var($_POST['name'],FILTER_VALIDATE_EMAIL) == TRUE)
{
	if (checkexist($_POST['name']) == TRUE) 
		{
		checkstate($_POST['name']);
		}
		else echo "錯誤： 賬號不存在";
}
else echo "錯誤： 提供的資訊不正確";
?>


