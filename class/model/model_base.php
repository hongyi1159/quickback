<?php
/**
 * @copyright  Copyright (c) 2010 php.cn (http://www.php.cn)
 * @link       http://www.php.cn
 * @since      File available since Release 0.8
 * @version    Release: 1.0.0
 * @author     hong <hongyi1159@126.com>
 */
if(!defined('IN_HONG')) {
	exit('Access Denied');
}

class mode_base
{
	var $db,$tb;

	function __construct($dbname,$tbname)
	{
		global $app;
		$this->db = $app->init_db($dbname);
		$this->tb = $this->db->tablepre.$tbname;
	}

	function rows($pg, $ps = 20)
	{
		if(!is_numeric($pg)) $pg = 0;
		if(!is_numeric($ps)) $ps = 20;

		$sql = "select * from ".$this->tb." limit ".$pg.','.$ps;
		return $this->db->query($sql);
	}
}
?>