<?php
define('ACTION','useradd');
include "../class/hong_core.php";
$app = hong_core::instance();
if(!$app->isLogin())
{
	$app->redirect('login.php');
}
$pagetitle = "-修改用户-管理后台";
include "../include/header.php";
$data = $app->getPageData();
?>
<table class="dataTb">
<form method='post'>
<tr><td colspan='2'><span class='msg'><?php echo $data['msg'];?></span>&nbsp;</td></tr>
<tr><td>用户名</td><td><input type='text' name='username' value='' /></td></tr>
<tr><td>真实姓名</td><td><input type='text' name='truename' value='' /></td></tr>
<tr><td>密码</td><td><input type='password' name='passwd' value='' /></td></tr>
<tr><td>是否锁定</td><td><select name='isLock'><option value='0'>否</option><option value='1'>是</option></select></td></tr>
<tr><td>用户组</td><td><select name='groupid'><?php foreach($data['glist'] as $k=>$v){echo "<option value='$k'>$v</option>";}?></select></td></tr>
<tr><td colspan='2'><input type='submit' value='提交' /></td></tr>
</form>
</table>
<?php include "../include/footer.php"; ?>