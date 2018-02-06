<?php
define('ACTION','setphone');
define('ISLOGIN',true);
include dirname(__FILE__)."/../class/hong_core.php";
$app = hong_core::instance();
$app->getPageData();
$app->view->colnum = 10;
include HROOT."include/vheader.php";
?>
<div style="float:left;margin-left:10px;text-align:left;" id="app">
	<!--卡槽位置:<input style='width:20px;' v-model="x" /> <input style='width:20px;' v-model="y" /><br/>
	ICCID:<input style='width:160px;' v-model="iccid" /><br/>
	手机号:<input style='width:120px;' v-model="phone" /><br/>
	<button v-on:click="save()">保存号码</button> <button v-on:click="ph()">拨号</button><br/-->
	卡批次:<input style='width:20px;' v-model="z" /> <button v-on:click="setz()">设置批次</button><br/>
	卡槽位置:<input style='width:20px;' v-model="x" /> <input style='width:20px;' v-model="y" /> <button v-on:click="ph()">开始读号码</button>
</div>
<?php
include HROOT."include/vfooter.php"; 