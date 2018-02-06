<?php
class sys_userGroup
{
	private $db;
	function __construct()
	{
		global $app;
		$this->db = $app->userdb;
	}

	//������id�����Ȩ��
	function getPowersAreasById($gid)
	{//echo "select powerids,areas from usergroup where id = $gid";
		$row = $this->db->query("select powerids,areas from usergroup where id = $gid");
		return $row[0];
	}

	//������id����û���
	function getGroupById($gid)
	{
		$row = $this->db->query("select * from usergroup where id = $gid");
		return $row[0];
	}

	//��ȡ�û����б�
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

	//��ȡ�û����б�
	function getGroupList($begin,$count)
	{
		$row = $this->db->query("select * from usergroup limit $begin,$count");
		return $row;
	}

	//��ȡ�û�������
	function groupCount()
	{
		$row = $this->db->query("select count(*) as c from usergroup");
		return $row[0]['c'];
	}

	//�û���༭
	function groupEdit($g)
	{
		$this->db->execute("update usergroup set gname='".$g['gname']."',powerids='".$g['powerids']."',areas='".$g['areas']."' where id=".$g['id']);
	}
	//�û������
	function groupAdd($g)
	{
		$this->db->execute("insert into usergroup values(null,'".$g['powerids']."','".$g['areas']."','".$g['gname']."')");
	}
	//�û���ɾ��
	function groupDel($id)
	{
		$this->db->query(sprintf("delete from usergroup where id=%d",$this->db->escapeStr($id)));
	}
}
?>