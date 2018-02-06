<?php
include "class/hong_core.php";
$app = hong_core::instance();
$u = $app->userStatus;
if(isset($_GET['act']) && $_GET['act'] == 'logout')
{
	$u->loginOut();
}
else if($_POST)
{
	$u->login($_POST['id'],$_POST['pass']);
	if(isset($_POST['gm']))
	{
		setcookie('game',$_POST['gm']);
	}
	if($u->checkLogin())
	{
		$app->redirect("index.php");
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> 登陆后台 </title>
  <meta name="Generator" content="EditPlus">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
 </head>
<script type="text/javascript">
<!--
function tijiao(){

	if(document.f.id.value){
		if(document.f.pass.value){
			document.f.submit();
		}else{
			alert("密码为空");
			return false;
		}
	}else{
		alert("用户为空");
		return false;
	}
}	
//-->
</script>
 <body>
	<table width="100%" height="600" align="center" border="0">
		<tr>
			<td> 
				<form action="login.php" method="post" name="f" >
					<table width="300" height="200" align="center" border="1" bgcolor="#708090"">
						<tr>
							<td align="center">
								账&nbsp&nbsp&nbsp号
								<input type="text" style="width:150px" name="id" value=""></br></br>
								密&nbsp&nbsp&nbsp码
								<input type="password" style="width:150px" name="pass" value=""></br></br>
								<?php 
									if(count($app->config['gamelist']) > 1)
									{
										echo "游戏列表 <select name='gm'>";
										foreach($app->config['gamelist'] as $v)
										{
											echo "<option value='",$v,"'>",$v,"</option>";
										}
										echo '</select></br>';
									}
								?></br>
								<input type="submit" value="登陆" onclick="return tijiao();">&nbsp&nbsp&nbsp&nbsp
								<input type="reset" value="重置">
							</td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
	</table>
 </body>
</html>
