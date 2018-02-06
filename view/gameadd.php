<?php
define('ACTION','gameadd');
define('ISLOGIN',true);
include dirname(__FILE__)."/../class/hong_core.php";
$app = hong_core::instance();
$app->getPageData();
$app->view->filterBefore = "游戏编号: <input name='gid' value='".$app->view->gid."' /><br/><br/>
游戏名字: <input name='gname' value='".$app->view->gname."' /><br/>
用户fid: <input name='ufid' value='".$app->view->ufid."' /><br/>";
$app->view->filterV['submit'] = true;
include HROOT."include/nheader.php";
include HROOT."include/nfooter.php";