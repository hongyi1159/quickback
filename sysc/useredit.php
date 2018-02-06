<?php
define('ACTION','useredit');
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
<tr><td width='100px'>用户编号</td><td><input type='hidden' name='id' value='<?php echo $data['id'];?>' /><?php echo $data['id'];?></td></tr>
<tr><td>用户名</td><td><input type='text' name='username' value='<?php echo $data['username'];?>' /></td></tr>
<tr><td>真实姓名</td><td><input type='text' name='truename' value='<?php echo $data['truename'];?>' /></td></tr>
<tr><td>密码</td><td><input type='password' name='passwd' value='' /> <span class='msg'>修改密码为空时,密码不修改</span></td></tr>
<tr><td>是否锁定</td><td><select name='isLock'><option value='0' <?php echo $data['isLock']=='0'?'selected':'';?>>否</option><option value='1' <?php echo $data['isLock']=='1'?'selected':'';?>>是</option></select></td></tr>
<tr><td>用户组</td><td><select name='groupid'><?php foreach($data['glist'] as $k=>$v){echo "<option value='$k' ".($k==$data['groupid']?'selected':'').">$v</option>";}?></select></td></tr>
<tr><td colspan='2'><input type='submit' value='提交' /></td></tr>
</form>
</table>
<?php include "../include/footer.php"; ?>