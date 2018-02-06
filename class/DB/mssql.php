<?php
/**
 * @copyright  Copyright (c) 2010 七酷 (http://www.7cool.cn)
 * @link       http://www.7cool.cn
 * @since      File available since Release 0.0.2
 * @version    Release: 0.0.3
 * @author     hong <hongyi1159@126.com>
 * @change		0.0.1
 * @desc		用于linux下连接sqlserver
 */
class myMssql
{
	private $db;
	private $pre='';

	function __construct($h,$p)
	{
		static $dbl;
		if(isset($dbl[$h]) && isset($dbl[$h][$p['UID']]))
		{
			$this->db = $dbl[$h][$p['UID']];
			mssql_select_db($p['Database'], $this->db);
			$this->pre = $p['Database'];
		}
		else
		{
			$this->db = $dbl[$h][$p['UID']] = mssql_connect(str_replace(",",":",$h), $p['UID'], $p['PWD']);
			if(!$this->db) echo "can not $h ",mssql_get_last_message();
			mssql_select_db($p['Database'], $this->db);
			$this->pre = $p['Database'];
		}
	}

	function getRes($sql)
	{
		$re = null;
		if($this->db)
		{
			$re = mssql_query($sql, $this->db);
			if(!$re) {echo $this->pre,'-',$sql,mssql_get_last_message();}
		}
		return $re;
	}
	//获得列名和数据
	function getRows($sql)
	{
		$rowAll = array();
		$row = array();
		$res = $this->getRes($sql);
		if($res)
		{
			$numfield = mssql_num_fields($res);
			for($i=0;$i<$numfield;$i++)
			{
				$row[] = mssql_field_name($res,$i);
			}
			$rowAll[] = $row;
			while($row = mssql_fetch_array($res,MSSQL_NUM))
			{
				$rowAll[] = $row;
			}
			mssql_free_result($res);
		}
		return $rowAll;
	}
	//获得数据
	function getRowsData($sql)
	{
		$rowAll = array();
		$res = $this->getRes($sql);
		if($res)
		{
			while($row = mssql_fetch_array($res,MSSQL_NUM))
			{
				$rowAll[] = $row;
			}
			mssql_free_result($res);
		}
		return $rowAll;
	}
	//获得单个数据
	function getOneData($sql)
	{
		$d = "";
		$res = $this->getRes($sql);
		if($res)
		{
			while($row = mssql_fetch_array($res,MSSQL_NUM))
			{
				$d = $row[0];
			}
		}
		return $d;
	}

	//执行sql语句
	function execute($sql)
	{
		if($this->getRes($sql))
		{
			sqlsrv_free_stmt($stmt);
			return true;
		}
		else
		{
			echo "Error in executing statement.\n";
			die(mssql_get_last_message());
		}
	}
}