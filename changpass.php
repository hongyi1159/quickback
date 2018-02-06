<?php
define('ACTION','cq_menu');
include "class/hong_core.php";
$app = new hong_core();
if(!$app->isLogin())
{
	$app->redirect('login.php');
}
$msg = "";
if($_POST)
{
	if($_POST['pass1'] == $_POST['pass2'])
	{
		$app->userStatus->chpass($_POST['oldpass'],$_POST['pass1']);
		$msg = "密码修改成功";
	}
}
$pagetitle = "修改密码";
include "include/header.php";
?>
			<table class="dataTb">
			<tr class='title_1'><th colspan="2">修改密码</th></tr>
			<tr class='title_4'><th colspan="2"><?php echo $msg;?>&nbsp</th></tr>
			<form method="post">
			<tr><td>原密码</td><td><input name='oldpass' type='password'/></td></tr>
			<tr><td>新密码</td><td><input name='pass1' type='password'/></td></tr>
			<tr><td>确认密码</td><td><input name='pass2' type='password'/></td></tr>
			<tr><td colspan="2"><input value='确认' type='submit'/></td></tr>
			</form>
			</table>
<?php include "include/footer.php"; ?>