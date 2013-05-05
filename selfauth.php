<?php
require ("functions.php");
$_POST['key'] = str_replace(" ","",$_POST['key']);
if ((filter_var($_POST['name'],FILTER_VALIDATE_EMAIL) == true) && (strlen($_POST['key']) == 13)) usekey($_POST['name'],$_POST['key']);else echo "錯誤：提供的資料不正確，請返回檢查。";

?>
