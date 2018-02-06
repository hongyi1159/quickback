<?php
define('ACTION','grouplist');
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
<tr class='title_1'><th>组编号</th><th>组名</th><th>操作</th></tr>
<?php foreach($data as $k => $v){
echo "<tr><td>$k</td><td>$v</td><td><a href='groupedit.php?gid=$k'>修改</a> <a href='groupdel.php?gid=$k'>删除</a></td></tr>";
}?>
</table>
<?php include "../include/footer.php"; ?>