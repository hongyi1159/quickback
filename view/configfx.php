<?php
define('ACTION','configfx');
define('ISLOGIN',true);
include dirname(__FILE__)."/../class/hong_core.php";
$app = hong_core::instance();
$app->view->filterV["btime"] = $app->view->filterV["etime"] = $app->view->filterV["submit"] = true;
$app->getPageData();
include HROOT."include/nheader.php";
include HROOT."include/nfooter.php"; 
