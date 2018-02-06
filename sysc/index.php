<?php
define('ACTION','sysc_index');
include "../class/hong_core.php";
$app = hong_core::instance();
if(!$app->isLogin())
{
	$app->redirect('login.php');
}
$pagetitle = "-传奇国度后台";
include "../include/header.php";
?>
后台管理
<?php include "../include/footer.php"; ?>