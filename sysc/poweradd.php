<?php
define('ACTION','poweradd');
include "../class/hong_core.php";
$app = hong_core::instance();
if(!$app->isLogin())
{
	$app->redirect('login.php');
}
$pagetitle = "-添加权限-管理后台";
include "../include/header.php";
$data = $app->getPageData();
?>
<table class="dataTb">
<tr><td colspan='2'><a href='powerlist.php'>权限列表</a></td></tr>
<form method='post'>
<tr><td>权限类名</td><td><input type='text' name='pages' value='' /></td></tr>
<tr><td>父权限</td><td><input type='text' name='pid' value='' /></td></tr>
<tr><td>权限方法</td><td><input type='text' name='action' value='' /></td></tr>
<tr><td>是否显示</td><td><select name='isshow'><option value='0'>否</option><option value='1'>是</option></select></td></tr>
<tr><td>标题</td><td><input type='text' name='title' value='' /></td></tr>
<tr><td colspan='2'><input type='submit' value='提交' /></td></tr>
</form>
</table>
<?php include "../include/footer.php"; ?>