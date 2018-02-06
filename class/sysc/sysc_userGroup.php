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
	*	�û����б�
	*/
	function grouplist()
	{
		global $app;

		$dlist = $app->get_model('sys_userGroup')->groupList();

		return $dlist;
	}
	/*
	*	�༭�û���
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
	*	����û���
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
	*	ɾ���û���
	*/
	function groupdel()
	{
		global $app;
		$dlist['msg'] = '';
		if(isset($_GET['gid']) && is_numeric($_GET['gid']))
		{
			$gid = $_GET['gid'];
			if($gid == '1')
				$dlist['msg'] = '����ɾ��';
			else
				$dlist['msg'] = $app->get_model('sys_userGroup')->groupDel($gid);
		}
		return $dlist;
	}
}