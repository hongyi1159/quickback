<?php
/**
 * @copyright  Copyright (c) 2010 
 * @link       
 * @since      File available since Release 0.0.0
 * @version    Release: 0.0.1
 * @author     hong <hongyi1159@126.com>
 */

if(!defined('IN_HONG')) {
	exit('Access Denied');
}

class mySqlite
{
	//private static var $db;

	private $db;

	function __construct($file)
	{
		$this->db = new Sqlite3($file);
	}
	
	//获取数据
	function query($sql,$param = null)
	{ 
		$stmt = $this->db->prepare($sql);
		if(count($param) > 0)
		{
			foreach($param as $k => $v)
			{
				$stmt->bindValue($k, $v);
			}
		}
		if(!$stmt) echo $sql;
		$result = $stmt->execute();
		while($r = $result->fetchArray(SQLITE3_ASSOC))
		{
			$row[] = $r;
		}
		return isset($row)?$row:array();
	}
	/*
	* 获取数据
	*/
	function queryOne($sql)
	{ 
		$result = $this->db->query($sql);
		$row = $result->fetchArray(SQLITE3_ASSOC);
		return $row;
	}
	/*
	* 过滤字符串
	*/
	function escapeStr($str)
	{ 
		return $this->db->escapeString($str);
	}

	//执行sql语句
	function execute($sql)
	{
		return $this->db->exec($sql);
	}
}
?>
