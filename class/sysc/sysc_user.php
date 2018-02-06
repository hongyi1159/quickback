<?php
/**
 * @copyright  Copyright (c) 2010 
 * @link       
 * @since      File available since Release 0.0.0
 * @version    Release: 0.0.2
 * @author     hong <hongyi1159@126.com>
 */
class sysc_user
{
	/*
	*	用户列表
	*/
	function userlist()
	{
		global $app;
		$dlist = array();
		$u = $app->get_model('sys_user');
		$d = $u->userList(0,100);
		foreach($d as $v)
		{
			$dlist[] = array($v['id'],$v['username'],$v['truename'],($v['isLock'] == 0?'否':'是'),$v['lastlogin']);
		}
		return $dlist;
	}
	/*
	*	编辑用户
	*/
	function useredit()
	{
		global $app;
		$dlist = null;

		if($_POST)
		{
			if(!empty($_POST['passwd'])) $_POST['passwd'] = md5($_POST['passwd']);
			$app->get_model('sys_user')->userEdit($_POST);
		}

		if(isset($_GET['uid']) && is_numeric($_GET['uid']))
		{
			$uid = $_GET['uid'];
			$dlist = $app->get_model('sys_user')->getUserById($uid);
		}
		$dlist['glist'] = $app->get_model('sys_userGroup')->groupList();
		return $dlist;
	}
	/*
	*	添加用户
	*/
	function useradd()
	{
		global $app;
		$dlist['msg'] = "";

		if($_POST)
		{
			if(!empty($_POST['passwd'])) $_POST['passwd'] = md5($_POST['passwd']);
			$app->get_model('sys_user')->userAdd($_POST);
			$dlist['msg'] = "添加用户成功";
		}
		$dlist['glist'] = $app->get_model('sys_userGroup')->groupList();

		return $dlist;
	}
	/*
	*	删除用户
	*/
	function userdel()
	{
		global $app;
		$dlist['msg'] = "";

		if(isset($_GET['uid']) && is_numeric($_GET['uid']))
		{
			$uid = $_GET['uid'];
			$dlist = $app->get_model('sys_user')->userDel($uid);
			$dlist['msg'] = "删除用户成功";
		}
		return $dlist;
	}
}