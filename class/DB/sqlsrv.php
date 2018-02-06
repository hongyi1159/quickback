<?php
/**
 * @copyright  Copyright (c) 2010 
 * @link       
 * @since      File available since Release 0.0.2
 * @version    Release: 0.0.3
 * @author     hong <hongyi1159@126.com>
 * @change		0.0.3��ֱ��֧�ֵ�utf-8���� -110908
 */
class myMssql
{
	private $db;
	private $pre='';

	function __construct($h,$p)
	{
		static $dbl;
		$p['LoginTimeout'] = 5;
		$p['CharacterSet'] = 'UTF-8';
		if(isset($dbl[$h]) && isset($dbl[$h][$p['UID']]))
		{
			$this->db = $dbl[$h][$p['UID']];
			$this->getRes('use '.$p['Database'].";");
			$this->pre = $p['Database'];
		}
		else
		{
			$this->db = $dbl[$h][$p['UID']] = sqlsrv_connect($h, $p);
			if(!$this->db) echo "can not $h ",print_r(sqlsrv_errors(),true);
			$this->pre = $p['Database'];
		}
	}

	function getRes($sql)
	{
		$re = null;
		if($this->db)
		{
			$re = sqlsrv_query($this->db,$sql);
			if(!$re) {echo $this->pre,'-',$sql,@iconv('GBK','UTF-8',print_r(sqlsrv_errors(),true));}
		}
		return $re;
	}
	//�������������
	function getRows($sql)
	{
		$rowAll = array();
		$row = array();
		$res = $this->getRes($sql);
		if($res)
		{
			$numfield = sqlsrv_num_fields($res);
			$fields = sqlsrv_field_metadata($res);//print_r($fields);
			for($i=0;$i<$numfield;$i++)
			{
				$row[] = @iconv('GBK','UTF-8',$fields[$i]['Name']);
			}
			$rowAll[] = $row;
			while($row = sqlsrv_fetch_array($res,SQLSRV_FETCH_NUMERIC))
			{
				$rowAll[] = $row;
			}
			sqlsrv_free_stmt($res);
		}
		return $rowAll;
	}
	//�������
	function getRowsData($sql)
	{
		$rowAll = array();
		$res = $this->getRes($sql);
		if($res)
		{
			while($row = sqlsrv_fetch_array($res,SQLSRV_FETCH_NUMERIC))
			{
				$rowAll[] = $row;
			}
			sqlsrv_free_stmt($res);
		}
		return $rowAll;
	}
	//��õ�������
	function getOneData($sql)
	{
		$d = "";
		$res = $this->getRes($sql);
		if($res)
		{
			while($row = sqlsrv_fetch_array($res,SQLSRV_FETCH_NUMERIC))
			{
				$d = $row[0];
			}
		}
		return $d;
	}

	//ִ��sql���
	function execute($sql,$p)
	{
		$stmt = sqlsrv_prepare($this->db,$sql,$p);
		if($stmt)
		{
			if(sqlsrv_execute($stmt))
			{
				sqlsrv_free_stmt($stmt);
				return true;
			}
			else
			{
				echo "Error in executing statement.\n";
				die( print_r( sqlsrv_errors(), true));
			}
		}
		else
		{
			echo "Error in preparing statement.\n";
			die( print_r( sqlsrv_errors(), true));
		}
	}
	//ִ��sql���
	function escapeStr($str)
	{ 
		return str_replace("'","''",$str);
	}
}