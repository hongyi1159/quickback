<?php
define('ACTION',$_GET['act']);
define('ISLOGIN',true);
include dirname(__FILE__)."/../class/hong_core.php";
$app = hong_core::instance();
$app->getPageData();
echo json_encode($app->view->data);