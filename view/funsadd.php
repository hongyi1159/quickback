<?php
define('ACTION','funsadd');
define('ISLOGIN',true);
include dirname(__FILE__)."/../class/hong_core.php";
$app = hong_core::instance();
$app->getPageData();
$app->view->filterBefore = "功能编号: <input name='fid' value='".$app->view->fid."' /><br/>
游戏编号: <input name='gmid' value='".$app->view->gmid."' /><br/>
功能名称: <input name='names' value='".$app->view->names."' /><br/>
脚本路径: <input name='url' value='".$app->view->url."' /><br/>
等待类型: <select name='waittp'>";
foreach($app->config["waitarr"] as $k=>$v)
{
	$app->view->filterBefore .= "<option value='".$k."'".($app->view->waittp==$k?" selected":"").">".$v."</option>";
}
$app->view->filterBefore .= "</select><br/>
预计时间: <input name='xtime' value='".$app->view->xtime."' /><br/>";
$app->view->filterV['submit'] = true;
include HROOT."include/nheader.php";
include HROOT."include/nfooter.php";