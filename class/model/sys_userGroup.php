<?php
class sys_userGroup
{
	private $db;
	function __construct()
	{
		global $app;
		$this->db = $app->userdb;
	}

	//根据组id获得组权限
	function getPowersAreasById($gid)
	{//echo "select powerids,areas from usergroup where id = $gid";
		$row = $this->db->query("select powerids,areas from usergroup where id = $gid");
		return $row[0];
	}

	//根据组id获得用户组
	function getGroupById($gid)
	{
		$row = $this->db->query("select * from usergroup where id = $gid");
		return $row[0];
	}

	//获取用户组列表
	function groupList()
	{
		$row = $this->db->query("select id,gname from usergroup");
		$group = array();
		foreach($row as $v)
		{
			$group[$v['id']] = $v['gname'];
		}
		return $group;
	}

	//获取用户组列表
	function getGroupList($begin,$count)
	{
		$row = $this->db->query("select * from usergroup limit $begin,$count");
		return $row;
	}

	//获取用户组总数
	function groupCount()
	{
		$row = $this->db->query("select count(*) as c from usergroup");
		return $row[0]['c'];
	}

	//用户组编辑
	function groupEdit($g)
	{
		$this->db->execute("update usergroup set gname='".$g['gname']."',powerids='".$g['powerids']."',areas='".$g['areas']."' where id=".$g['id']);
	}
	//用户组添加
	function groupAdd($g)
	{
		$this->db->execute("insert into usergroup values(null,'".$g['powerids']."','".$g['areas']."','".$g['gname']."')");
	}
	//用户组删除
	function groupDel($id)
	{
		$this->db->query(sprintf("delete from usergroup where id=%d",$this->db->escapeStr($id)));
	}
}
?>