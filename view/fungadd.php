<?php
define('ACTION','fungadd');
define('ISLOGIN',true);
include dirname(__FILE__)."/../class/hong_core.php";
$app = hong_core::instance();
$app->getPageData();
$app->view->filterBefore = "任务编号: <input name='gid' value='".$app->view->gid."' /><br/>
任务名称: <input name='names' value='".$app->view->names."' /><br/>
功能组ID: <input name='funlid' value='".$app->view->funlid."' /><br/>
用户类型: <input name='isNew' value='".$app->view->isNew."' /> 0新用户; 大于1小于100指定注册时间与当前间隔的天数; 255轮询; 254有第三方账号设备; 大于200小于250注册时间大于X-200天的用户; 大于100小于200活跃时间小于X-100天的用户<br/>
指定设备: <input name='mackey' value='".$app->view->mackey."' /><br/>
设备表: <input name='devtb' value='".$app->view->devtb."' /><br/>";
$app->view->filterV['submit'] = true;
include HROOT."include/nheader.php";
include HROOT."include/nfooter.php"; 
?>