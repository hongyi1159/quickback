<?php
define('ACTION','userlist');
include "../class/hong_core.php";
$app = hong_core::instance();
if(!$app->isLogin())
{
	$app->redirect('login.php');
}
$pagetitle = "-用户列表-管理后台";
include "../include/header.php";
$data = $app->getPageData();
?>
<table class="dataTb">
<tr class='title_1'>
	<th>用户编号</th>
	<th>用户名</th>
	<th>真实姓名</th>
	<th>是否锁定</th>
	<th>最后登录</th>
	<th>操作</th>
</tr>
<?php foreach($data as $v) {?>
<tr>
	<?php foreach($v as $v2) {?>
	<td><?php echo $v2;?></td>
	<?php }?>
	<td><a href='useredit.php?uid=<?php echo $v[0];?>'>修改</a> <a href='userdel.php?uid=<?php echo $v[0];?>'>删除</a></td>
</tr>
<?php }?>
</table>
<?php include "../include/footer.php"; ?>