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

class mysql
{
	var $tablepre;
	var $curlink;
	var $link = array();
	var $config = array();

	function __construct($config)
	{
		if(!empty($config)) {
			$this->set_config($config);
		}
	}

	function set_config($config) {
		$this->config = &$config;
	}
	
	function connect($serverid = "1")
	{
		if(empty($this->config) || empty($this->config[$serverid])) {
			//$this->halt('config_db_not_found');
		}

		$this->link[$serverid] = $this->_dbconnect(
			$this->config[$serverid]['dbhost'],
			$this->config[$serverid]['dbuser'],
			$this->config[$serverid]['dbpw'],
			$this->config[$serverid]['dbcharset'],
			$this->config[$serverid]['dbname'],
			$this->config[$serverid]['pconnect']
		);
		$this->curlink = $this->link[$serverid];
		$this->tablepre = $this->config[$serverid]['tablepre'];
	}

	function _dbconnect($dbhost, $dbuser, $dbpw, $dbcharset, $dbname, $pconnect) {
		$link = null;
		$func = empty($pconnect) ? 'mysql_connect' : 'mysql_pconnect';
		if(!$link = @$func($dbhost, $dbuser, $dbpw, 1)) {
			$this->halt('notconnect');
		} else {
			$this->curlink = $link;
			if($this->version() > '4.1') {
				$dbcharset = $dbcharset ? $dbcharset : $this->config[1]['dbcharset'];
				$serverset = $dbcharset ? 'character_set_connection='.$dbcharset.', character_set_results='.$dbcharset.', character_set_client=binary' : '';
				$serverset .= $this->version() > '5.0.1' ? ((empty($serverset) ? '' : ',').'sql_mode=\'\'') : '';
				$serverset && mysql_query("SET $serverset", $link);
			}
			$dbname && @mysql_select_db($dbname, $link);
		}
		return $link;
	}

	//获取数据
	function query($sql)
	{
		$row = array();
		$result = mysql_query($sql, $this->curlink);
		if($result)
		{
			if($result !== true)
			{
				while($r = mysql_fetch_row($result))
				{
					$row[] = $r;
				}
			}
			else
			{
				return $result;
			}
		}
		else
		{
			echo mysql_error($this->curlink).$sql;
		}
		return $row;
	}

	function version() {
		if(empty($this->version)) {
			$this->version = mysql_get_server_info($this->curlink);
		}
		return $this->version;
	}
}
?>
