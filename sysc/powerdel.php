<?php
define('ACTION','powerdel');
define('ISLOGIN',true);
include "../class/hong_core.php";
$app = hong_core::instance();
$pagetitle = "-删除权限-管理后台";
include "../include/header.php";
$data = $app->getPageData();

echo "<span class='msg' >".$data['msg']."</span><script type='text/javascript'>setTimeout(function(){location.href='powerlist.php'},2000)</script>";

include "../include/footer.php"; ?>