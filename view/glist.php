<?php
define('ACTION','glist');
define('ISLOGIN',true);
include dirname(__FILE__)."/../class/hong_core.php";
$app = hong_core::instance();
$app->getPageData();
include HROOT."include/nheader.php";
include HROOT."include/nfooter.php"; 
?>