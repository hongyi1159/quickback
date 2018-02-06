<?php
define('ACTION','userdel');
include "../class/hong_core.php";
$app = hong_core::instance();
if(!$app->isLogin())
{
	$app->redirect('login.php');
}
$pagetitle = "-删除用户-管理后台";
include "../include/header.php";
$data = $app->getPageData();

echo "<span class='msg' >".$data['msg']."</span><script type='text/javascript'>setTimeout(function(){location.href='userlist.php'},2000)</script>";

include "../include/footer.php"; ?>