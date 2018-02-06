<?php
/**
 * @copyright  Copyright (c) 2010 �߿� (http://www.7cool.cn)
 * @link       http://www.7cool.cn
 * @since      File available since Release 0.0.0
 * @version    Release: 0.0.1
 * @author     hong <hongyi1159@126.com>
 */
class sys_user
{
	private $db;
	function __construct()
	{
		$this->db = hong_core::instance()->userdb;
	}
	//�����û�������û�
	function getUserByName($uname)
	{
		$row = $this->db->queryOne(sprintf("select * from users where username='%s'",$this->db->escapeStr($uname)));
		return $row;
	}
	//�����û�id����û�
	function getUserById($id)
	{
		$row = $this->db->queryOne(sprintf("select * from users where id=%d",$this->db->escapeStr($id)));
		return $row;
	}
	//�û���¼��¼
	function loginLog($uid,$oldip,$logintime)
	{
		$this->db->execute("update users set ip='$_SERVER[REMOTE_ADDR]',lastip='$oldip',logintime=datetime('now','localtime'),lastlogin='$logintime' where id=$uid");
	}
	//��ȡ�û��б�
	function userList($begin,$count)
	{
		$row = $this->db->query("select * from users limit $begin,$count");
		return $row;
	}
	//��ȡ�û�����
	function userCount()
	{
		$row = $this->db->query("select count(*) as c from users");
		return $row[0]['c'];
	}
	//�༭�û�
	function userEdit($u)
	{
		if(empty($u["passwd"]))
			$this->db->execute(sprintf("update users set username='%s',truename='%s',isLock=%d,groupid=%d where id=%d",$this->db->escapeStr($u['username']),$this->db->escapeStr($u['truename']),$this->db->escapeStr($u['isLock']),$this->db->escapeStr($u['groupid']),$this->db->escapeStr($u['id'])));
		else
			$this->db->execute(sprintf("update users set username='%s',truename='%s',passwd='%s',isLock=%d,groupid=%d where id=%d",$this->db->escapeStr($u['username']),$this->db->escapeStr($u['truename']),$this->db->escapeStr($u['passwd']),$this->db->escapeStr($u['isLock']),$this->db->escapeStr($u['groupid']),$this->db->escapeStr($u['id'])));
	}
	//����û�--������
	function userAdd($u)
	{
		/*
		$this->db->query("insert into users values(null,?,?,?,?,?,'127.0.0.1','127.0.0.1',datetime('now','localtime'),datetime('now','localtime'),datetime('now','localtime'))",array("1"=>$u['username'],"2"=>$u['truename'],"3"=>$u['passwd'],"4"=>$u['isLock'],"5"=>$u['groupid']));*/
		$this->db->execute(sprintf("insert into users values(null,'%s','%s','%s','%s','%d','127.0.0.1','127.0.0.1',datetime('now','localtime'),datetime('now','localtime'),datetime('now','localtime'))",$this->db->escapeStr($u['username']),$this->db->escapeStr($u['truename']),$this->db->escapeStr($u['passwd']),$this->db->escapeStr($u['isLock']),$this->db->escapeStr($u['groupid'])));
	}
	//ɾ���û�
	function userDel($id)
	{
		$this->db->execute(sprintf("delete from users where id=%d",$this->db->escapeStr($id)));
	}

	/**
	* �޸�ָ���û�����
	*/
	function chpass($p,$uid)
	{
		$this->db->execute(sprintf("update users set passwd='%s' where id=%d",$this->db->escapeStr(md5($p)),$this->db->escapeStr($uid)));
	}
}
?>