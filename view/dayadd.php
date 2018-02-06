<?php
define('ACTION','dayadd');
define('ISLOGIN',true);
include dirname(__FILE__)."/../class/hong_core.php";
$app = hong_core::instance();
$app->getPageData();
$app->view->filterBefore = "日期: <input name='btime' id='btime' value='".$app->view->btime."' /><br/>
任务编号: <input name='gpid' value='".$app->view->gpid."' /><br/>
要求数量: <input name='rNum' value='".$app->view->rNum."' /><br/>
执行间隔: <input name='btype' value='".$app->view->btype."' /><br/>";
$app->view->filterV["submit"] = true;
include HROOT."include/nheader.php";
include HROOT."include/nfooter.php"; 
