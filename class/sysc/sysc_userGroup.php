<?php
/**
 * @copyright  Copyright (c) 2010 
 * @link       
 * @since      File available since Release 0.0.0
 * @version    Release: 0.0.2
 * @author     hong <hongyi1159@126.com>
 */
class sysc_userGroup
{
	/*
	*	用户组列表
	*/
	function grouplist()
	{
		global $app;

		$dlist = $app->get_model('sys_userGroup')->groupList();

		return $dlist;
	}
	/*
	*	编辑用户组
	*/
	function groupedit()
	{
		global $app;
		$dlist['msg'] = '';

		if($_POST)
		{
			$app->get_model('sys_userGroup')->groupEdit($_POST);
		}

		if(isset($_GET['gid']) && is_numeric($_GET['gid']))
		{
			$uid = $_GET['gid'];
			$dlist['g'] = $app->get_model('sys_userGroup')->getGroupById($uid);
		}
		$dlist['plist'] = $app->get_model('sys_power')->getPowerAll();

		return $dlist;
	}
	/*
	*	添加用户组
	*/
	function groupadd()
	{
		global $app;
		$dlist['msg'] = '';

		if($_POST)
		{
			$app->get_model('sys_userGroup')->groupAdd($_POST);
		}

		$dlist['plist'] = $app->get_model('sys_power')->getPowerAll();

		return $dlist;
	}
	/*
	*	删除用户组
	*/
	function groupdel()
	{
		global $app;
		$dlist['msg'] = '';
		if(isset($_GET['gid']) && is_numeric($_GET['gid']))
		{
			$gid = $_GET['gid'];
			if($gid == '1')
				$dlist['msg'] = '不可删除';
			else
				$dlist['msg'] = $app->get_model('sys_userGroup')->groupDel($gid);
		}
		return $dlist;
	}
}