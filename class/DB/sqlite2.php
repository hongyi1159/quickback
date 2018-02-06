<?php
/**
 * @copyright  Copyright (c) 2010 七酷 (http://www.7cool.cn)
 * @link       http://www.7cool.cn
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
		if(!function_exists('sqlite_open'))
		{
			echo 'not support sqlite db';
		}
		if(!$this->db = sqlite_open($file,0666,$errmsg))
			echo $errmsg;
	}
	
	//获取数据
	function query($sql)
	{ 
		$result = sqlite_query($this->db,$sql);
		$row = sqlite_fetch_all($result,SQLITE_ASSOC);
		return $row;
	}

	/*
	* 获取数据
	*/
	function queryOne($sql)
	{ 
		$result = sqlite_query($this->db,$sql);
		$row = sqlite_fetch_array($result,SQLITE_ASSOC);
		return $row;
	}

	/*
	* 过滤字符串
	*/
	function escapeStr($str)
	{ 
		return sqlite_escape_string($str);
	}

	//执行sql语句
	function execute($sql)
	{
		return sqlite_exec($this->db,$sql);
	}
}
?>
