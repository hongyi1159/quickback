<?php
define('ACTION','view_menu');
define('ISLOGIN',true);
include dirname(__FILE__)."/../class/hong_core.php";
$app = hong_core::instance();
$pagetitle = "-米趣后台";
include HROOT."include/header.php";
echo $app->curarea,"&nbsp&nbsp后台";
include HROOT."include/footer.php"; 
?>