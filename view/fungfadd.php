<?php
define('ACTION','fungfadd');
define('ISLOGIN',true);
include dirname(__FILE__)."/../class/hong_core.php";
$app = hong_core::instance();
$app->getPageData();
$app->view->filterBefore = "功能组编号: <input name='funlid' value='".$app->view->funlid."' /><br/>
功能编号: <input name='fid' value='".$app->view->fid."' /><br/>
排序号: <input name='sorts' value='".$app->view->sorts."' /> 从1开始<br/>
执行概率: <input name='prob' value='".$app->view->prob."' /><br/>";
$app->view->filterV['submit'] = true;
include HROOT."include/nheader.php";
include HROOT."include/nfooter.php";