<?php
/**
 * @copyright  Copyright (c) 2010 hong
 * @link       
 * @since      File available since Release 0.0.0
 * @version    Release: 0.0.1
 * @author     hong <hongyi1159@126.com>
 */
class sysc_power
{

	function __construct()
	{
		global $app;
		$this->db = $app->powerdb;
	}
	/*
	*	用户列表
	*/
	function powerlist()
	{
		$dlist = array();
		$row = $this->db->query("select * from power");
		foreach($row as $v)
		{
			$dlist[] = array($v['id'],$v['pages'],$v['pid'],$v['action'],($v['isshow'] == 0?'否':'是'),$v['title']);
		}
		return $dlist;
	}
	/*
	*	添加权限
	*/
	function poweradd()
	{
		$data = "";
		if($_POST)
		{
			$sql = sprintf("insert into power values(null,'%s',%d,'%s',%d,'%s')",$this->db->escapeStr($_POST['pages']),$this->db->escapeStr($_POST['pid']),$this->db->escapeStr($_POST['action']),$this->db->escapeStr($_POST['isshow']),$this->db->escapeStr($_POST['title']));
			$this->db->execute($sql);
			$data = "添加权限成功";
		}
		return $data;
	}
	/*
	*	修改权限
	*/
	function poweredit()
	{
		$data = array();
		if(isset($_GET['pid']) && is_numeric($_GET['pid']))
		{
			if($_POST)
			{
				$sql = sprintf("update power set pages='%s',pid=%d,action='%s',isshow=%d,title='%s' where id=".$_GET['pid'],$this->db->escapeStr($_POST['pages']),$this->db->escapeStr($_POST['pid']),$this->db->escapeStr($_POST['action']),$this->db->escapeStr($_POST['isshow']),$this->db->escapeStr($_POST['title']));
				$this->db->execute($sql);
			}
			$data = $this->db->queryOne("select * from power where id=".$_GET['pid']);
		}
		return $data;
	}
	/*
	*	删除权限
	*/
	function powerdel()
	{
		$data = array();
		if(isset($_GET['pid']) && is_numeric($_GET['pid']))
		{
			$sql = sprintf("delete from power where id=".$_GET['pid']);
			if($this->db->execute($sql))
				$data['msg'] = '删除权限成功';
		}
		return $data;
	}
}