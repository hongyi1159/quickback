<?php
include "class/hong_core.php";
$app = hong_core::instance();
$pagetitle = "-出错了";
include "include/nheader.php";
?>
<table class="dataTb">
	<tr class="title_1"><td><font color="#FF2D2D"><?php echo $app->curarea;?></font> 平台—— 出错了</td></tr>
	<tr class="title_4"><td><?php if(isset($_GET['m'])) echo $_GET['m'];?><br /><span id="tm">5</span>秒后自动跳转到首页
	<script type='text/javascript'>
		function rtime()
		{
			var l = $("#tm").html();
			if(l > 0)
			{
				$("#tm").html(l-1);
				setTimeout(rtime,1000);
			}
			else
			{
				location.href = 'index.php';
			}
		}
		setTimeout(rtime,1000);
	</script></td></tr>
</table>
<?php include "include/nfooter.php"; ?>