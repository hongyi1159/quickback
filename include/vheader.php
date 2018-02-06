<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<title> <?php echo $app->curarea,'-',$app->view->page['title']; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $app->getCssfile() ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo $g_var['config']['webpath'] ?>css/start/jquery-ui-1.8.16.custom.css" />
<script type='text/javascript' src='<?php echo $g_var['config']['webpath'] ?>js/jquery-1.4.2.min.js'></script>
<script type='text/javascript' src='<?php echo $g_var['config']['webpath'] ?>js/jquery-ui-1.8.16.custom.min.js'></script>
<script type='text/javascript'>
	var pt = '<?php echo $app->curarea;?>';
	var alist = [<?php echo "'所有','",implode("','",$app->arealist),"'";?>];
	<?php if(isset($g_var['config']['jsdate'])) echo "var jsdate = '",$g_var['config']['jsdate'],"';" ?>
</script>
</head>
<body>
<div id="top">
  <div class="top_user">Hello <strong><?php echo $app->userStatus->getUserName() ?></strong> - <a href="<?php echo $g_var['config']['webpath'] ?>login.php?act=logout">退出</a> <?php echo date('Y-m-d H:i:s');?></div>
  <ul class="view_menu">
	<li class="manage_title">米趣-数据后台</li>
	<li class="view_no_cur"><span id="select_area"></span></li>
	<?php $menu = $app->topMenu();
	foreach($menu as $v){echo "<li class='".($v['action']==$app->view->parentpage['action']?'view_cur':'view_no_cur')."'><a href='".$g_var['config']['webpath'].str_replace('_','/',$v['action']).".php'>$v[title]</a></li>"; }?>
	<li class="view_no_cur"><a href="<?php echo $g_var['config']['webpath'] ?>changpass.php">修改密码</a></li>
  </ul>
</div>
<?php echo $app->getMenu();?>