<?php
define('ACTION','groupedit');
include "../class/hong_core.php";
$app = hong_core::instance();
if(!$app->isLogin())
{
	$app->redirect('login.php');
}
$pagetitle = "-用户组管理-管理后台";
include "../include/header.php";
$data = $app->getPageData();
?>
<table class="dataTb">
<form method='post'>
<tr>
	<td colspan='4'><span class='msg'><?php echo $data['msg'];?></span>&nbsp;</td>
</tr>
<tr>
	<td>用户组编号</td>
	<td colspan='3'><input type='hidden' name='id' value='<?php echo $data['g']['id'];?>' /><?php echo $data['g']['id'];?></td>
</tr>
<tr>
	<td>组名</td>
	<td colspan='3'><input type='text' name='gname' value='<?php echo $data['g']['gname'];?>' /></td>
</tr>
<tr>
	<td width='100px'>权限列表</td>
	<td><input type='hidden' name='powerids' id='powerids' value='<?php echo $data['g']['powerids'];?>' />所有用户权限<br/><select id='pids1' multiple style='height:200px;'><?php foreach($data['plist'] as $v){echo "<option value='$v[id]'>$v[title]</option>";}?></select></td>
	<td width='60px'><input type='button' value='<<' onclick="deloption('pids2','pids1','powerids')"/><br/><input type='button' value='>>' onclick="addoption('pids1','pids2','powerids')" /></td>
	<td>当前用户组权限<br/><select id='pids2' multiple style='height:200px;'></select></td>
</tr>
<tr>
	<td>平台列表</td>
	<td width='180px'><input type='hidden' name='areas' id='areas' value='<?php echo $data['g']['areas'];?>' />所有平台<br/><select id='area1' multiple style='height:200px;'><?php foreach($app->gamelogdb as $k=>$v){echo "<option value='$k'>$k</option>";}?></select></td>
	<td><input type='button' value='<<' onclick="deloption('area2','area1','areas')"/><br/><input type='button' value='>>' onclick="addoption('area1','area2','areas')" /></td>
	<td>当前用户组平台<br/><select id='area2' multiple style='height:200px;'></select></td>
</tr>
<tr><td colspan='4'><input type='submit' value='提交' /></td></tr>
</form>
</table>
<script type='text/javascript' src='<?php echo $g_var['config']['webpath'] ?>js/powerids.js'></script>
<?php include "../include/footer.php"; ?>