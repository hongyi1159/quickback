<?php
/**
 * @copyright  Copyright (c) 2016
 * @since      File available since Release 0.0.0
 * @version    Release: 0.0.1
 * @author     hong <hongyi1159@126.com>
 */

class zk_gamerun extends baseController
{
	//���õ���Ϸ��ҳ
	function gamerun()
	{
		$this->getdbdata("SELECT * FROM [games].[dbo].[FunWait]");
	}
	
	//��ȡ�����б�
	function gr_gnlist()
	{
		$this->getdbdata("SELECT [gpid],A.[names],A.[funlid],[isNew],[mackey],[devtb],[edata],MAX(case when B.sort=1 then C.gid else 0 end) gid FROM [games].[dbo].[FGNames] A left join games.dbo.FunGroup B on A.funlid=B.funlid left join games.dbo.FunList C on B.fid=C.fid group by [gpid],A.[names],A.[funlid],[isNew],[mackey],[devtb],[edata] order by gpid desc");
	}
	
	//��ȡ��Ϸ�б�
	function gr_gmlist()
	{
		$this->getdbdata("SELECT [gid],[gname] FROM [games].[dbo].[GameList] order by gid desc");
	}
	
	//��ȡָ���������еĹ����б�
	function gr_fglist()
	{
		$this->getdbdata("SELECT [fid],[sort],[prob] FROM [games].[dbo].[FunGroup] where funlid=".intval($_GET['funlid'])." order by [sort]");
	}
	
	//��ȡָ����Ϸ������
	function gr_fgfunl()
	{
		$this->getdbdata("SELECT A.funlid FROM [games].[dbo].[FunGroup] A inner join [games].[dbo].[FunList] B on A.fid=B.fid and A.sort=1 where gid=".intval($_GET['gid'])." order by A.funlid");
	}
	
	//��ȡָ����Ϸ�еĹ����б�
	function gr_funlist()
	{
		$this->getdbdata("SELECT [fid],names,url,waittp,xtime FROM [games].[dbo].[FunList] where gid=".intval($_GET['gid'])." order by fid");
	}
	
	//��ȡִ������ÿ��ִ��
	function gr_fgday()
	{
		$this->getdbdata("SELECT CONVERT(varchar(10),[dt],120),[rNum],[btype] FROM [games].[dbo].[TaskDay] where gpid=".intval($_GET['gpid'])." order by dt");
	}
	
	//������Ϸ
	function gr_sgame()
	{
		$this->getdbdata("update [games].[dbo].[GameList] set gname='".str_replace("'", "''", $_GET['gname'])."' where gid=".intval($_GET['gid'])." 
		if(@@ROWCOUNT = 0)
		begin
			insert into [games].[dbo].[GameList] values(".intval($_GET['gid']).",'".str_replace("'", "''", $_GET['gname'])."',NULL);
		end");
	}
	
	//ɾ����Ϸ
	function gr_dgame()
	{
		$this->getdbdata("delete [games].[dbo].[GameList] where gid=".intval($_GET['gid']));
	}
	
	//��������
	function gr_sgn()
	{
		$this->getdbdata("update [games].[dbo].[FGNames] set names='".str_replace("'", "''", $_GET['names'])."',funlid=".intval($_GET['funlid']).",isNew=".intval($_GET['isnew']).",mackey='".str_replace("'", "''", $_GET['mackey'])."',devtb='".str_replace("'", "''", $_GET['devtb'])."',edata='".str_replace("'", "''", $_GET['edata'])."' where gpid=".intval($_GET['gpid'])." 
		if(@@ROWCOUNT = 0)
		begin
			insert into [games].[dbo].[FGNames] values(".intval($_GET['gpid']).",'".str_replace("'", "''", $_GET['names'])."',".intval($_GET['funlid']).",".intval($_GET['isnew']).",'".str_replace("'", "''", $_GET['mackey'])."','".str_replace("'", "''", $_GET['devtb'])."','".str_replace("'", "''", $_GET['edata'])."');
		end");
	}
	
	//ɾ������
	function gr_dgn()
	{
		$this->getdbdata("delete [games].[dbo].[FGNames] where gpid=".intval($_GET['gpid']));
	}
	
	//���湦����
	function gr_sfg()
	{
		$this->getdbdata("update [games].[dbo].[FunGroup] set fid='".intval($_GET['fid'])."',prob='".intval($_GET['prob'])."' where funlid=".intval($_GET['funlid'])." and sort=".intval($_GET['sort'])." 
		if(@@ROWCOUNT = 0)
		begin
			insert into [games].[dbo].[FunGroup] values(".intval($_GET['funlid']).",".intval($_GET['fid']).",".intval($_GET['sort']).",".intval($_GET['prob']).");
		end");
	}
	
	//ɾ��������
	function gr_dfg()
	{
		$this->getdbdata("delete [games].[dbo].[FunGroup] where funlid=".intval($_GET['funlid'])." and sort=".intval($_GET['sort']));
	}
	
	//���ƹ�����
	function gr_cfg()
	{
		$this->getdbdata("insert into [games].[dbo].[FunGroup] select ".(intval($_GET['funlid'])+1).",fid,sort,prob from [games].[dbo].[FunGroup] where funlid=".intval($_GET['funlid']));
	}
	
	//���湦��
	function gr_sfun()
	{
		$this->getdbdata("update [games].[dbo].[FunList] set names='".str_replace("'", "''", $_GET['names'])."',url='".str_replace("'", "''", $_GET['url'])."',waittp=".intval($_GET['waittp']).",xtime=".intval($_GET['xtime'])." where fid=".intval($_GET['fid'])." 
		if(@@ROWCOUNT = 0)
		begin
			insert into [games].[dbo].[FunList] values(".intval($_GET['fid']).",".intval($_GET['gid']).",'".str_replace("'", "''", $_GET['names'])."','','".str_replace("'", "''", $_GET['url'])."',".intval($_GET['waittp']).",".intval($_GET['xtime']).");
		end");
	}
	
	//ɾ������
	function gr_dfun()
	{
		$this->getdbdata("delete [games].[dbo].[FunList] where fid=".intval($_GET['fid']));
	}
	
	//��������ÿ��ִ�����
	function gr_sfgday()
	{
		$this->getdbdata("update [games].[dbo].[TaskDay] set rNum=".intval($_GET['rnum']).",btype=".intval($_GET['btype'])." where gpid=".intval($_GET['gpid'])." and dt='".str_replace("'", "''", $_GET['dt'])."'  
		if(@@ROWCOUNT = 0)
		begin
			insert into [games].[dbo].[TaskDay] values('".str_replace("'", "''", $_GET['dt'])."',".intval($_GET['gpid']).",".intval($_GET['rnum']).",".intval($_GET['btype']).");
		end");
	}
	
	//ɾ������ÿ��ִ�����
	function gr_dfgday()
	{
		$this->getdbdata("delete [games].[dbo].[TaskDay] where gpid=".intval($_GET['gpid'])." and dt='".str_replace("'", "''", $_GET['dt'])."'");
	}
}