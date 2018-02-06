<?php
define('ACTION','powerlist');
include "../class/hong_core.php";
$app = hong_core::instance();
if(!$app->isLogin())
{
	$app->redirect('login.php');
}
$pagetitle = "-权限列表-管理后台";
include "../include/header.php";
$data = $app->getPageData();
?>
<table class="dataTb">
<tr class='title_1'>
	<th>权限编号</th>
	<th>权限类</th>
	<th>父类编号</th>
	<th>权限方法</th>
	<th>是否显示</th>
	<th>标题</th>
	<th>操作</th>
</tr>
<tr><td colspan='7'><a href='poweradd.php'>添加权限</a></td></tr>
<?php foreach($data as $v) {?>
<tr>
	<?php foreach($v as $v2) {?>
	<td><?php echo $v2;?></td>
	<?php }?>
	<td><a href='poweredit.php?pid=<?php echo $v[0];?>'>修改</a> <a href='powerdel.php?pid=<?php echo $v[0];?>'>删除</a></td>
</tr>
<?php }?>
</table>
<?php include "../include/footer.php"; ?>