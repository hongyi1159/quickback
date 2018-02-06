<?php
define('ISLOGIN',true);
include "./class/hong_core.php";
hong_core::instance();
$msql = '';
if(isset($_GET['msql']))
{
	set_time_limit(0);
	$msql = $_GET['msql'];
	if(count($app->view->viewser) == 1)
	{
		$v1 = $app->gamelogdb[$app->viewonearea][$app->view->viewser[0]];
		$msdb = $app->loadmsdb($app->viewonearea,$app->view->viewser[0],$v1[0],$v1[1]);
		$app->view->data = $msdb->getRows($msql);
	}
}
include "./include/nheader.php";
echo "<select name='ser'>";
foreach($app->view->serlist as $v)
	echo "<option value='".$v."' ".(in_array($v,$app->view->viewser)?"selected='selected'":"")." >S$v</option>";
echo "</select><br /><textarea name='msql' style='width:500px;height:100px;'>",$msql,"</textarea>","<br/><input type='submit' value='提交' />";
include "./include/nfooter.php";