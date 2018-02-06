<?php
/**
 * @copyright  Copyright (c) 2010 
 * @link       
 * @since      File available since Release 0.0.0
 * @version    Release: 0.0.1
 * @author     hong <hongyi1159@126.com>
 */
class sys_power
{
	private $db;
	function __construct($setdb)
	{
		if(isset($setdb))
			$this->db = $setdb;
		else
			exit("必须设置数据库");
	}
	//获取顶级的power
	function getPowerPByIds($ids)
	{
		$row = $this->db->query("select * from power where id in($ids) and pid=0 and isshow=1");
		return $row;
	}
	//根据ids获得power
	function getPowerByIds($ids)
	{
		$row = $this->db->query("select * from power where id in($ids)");
		return $row;
	}
	//获取所有顶级power
	function getPowerPAll()
	{
		$row = $this->db->query("select * from power where pid=0 and isshow=1");
		return $row;
	}
	//获取controller
	function getControllerById($id)
	{
		$row = $this->db->query("select * from power where id=$id");
		return $row[0];
	}
	//获取controller
	function getControllerByAction($act)
	{
		$row = $this->db->query("select * from power where action='$act'");
		return $row[0];
	}
	//根据父权限获取子权限
	function getPowerByPidIds($pid,$ids)
	{
		$row = $this->db->query("select * from power where id in($ids) and pid=$pid and isshow=1");
		return $row;
	}
	//根据父权限获取子权限
	function getPowerByPid($pid)
	{
		$row = $this->db->query("select * from power where pid=$pid and isshow=1");
		return $row;
	}
	//全部权限列表
	function getPowerAll()
	{
		$row = $this->db->query("select * from power");
		return $row;
	}
}
?>