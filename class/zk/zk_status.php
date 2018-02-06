<?php
/**
 * @copyright  Copyright (c) 2016
 * @since      File available since Release 0.0.0
 * @version    Release: 0.0.1
 * @author     hong <hongyi1159@126.com>
 */

class zk_status extends baseController
{
	//设备状态列表
	function devlist()
	{
		$this->view->iscansort = true;
		$this->rowname = array('MAC地址', '状态', '功能组', '功能ID', '最后连接时间', '断线时间', '更新时间', '设备ID', 'IP', '当前等待', '执行秒数');
		$this->getdbdata("SELECT *,DATEDIFF(S,utime,GETDATE()) FROM [games].[dbo].[DevStatus] order by utime");
		$cdev = 0; $fdev = 0;
		foreach($this->view->data as $k=>$v)
		{
			$this->view->data[$k][9] = $v[9]."_".$this->app->config['waitarr'][$v[9]];
			if($this->view->data[$k][9] == $this->app->config['waitarr']['-3'])
			{
				$this->view->data[$k][9] .= "<img src='http://192.168.0.200:81/".str_replace(':','',$v[0]).".png' /> <input id='codevalue' type='text' style='width:40px' /> <a onclick=\"window.open('http://192.168.0.201:94/msgrecv?s=3&mackey=".$v[0]."&msg='+$('#codevalue').val())\">发送</a>";
			}
			if($v[1])
			{
				++$cdev;
				if($v[2] == 0 && $v[3] == 0) ++$fdev;
				if($v[10] > 3600) $this->view->data[$k][10] = "<span style='color:red;'>".$v[10]."</span>";
			}
			else
				$this->view->data[$k][1] = "<span style='color:red;'>".$v[1]."</span>";
		}
		if($fdev / $cdev > 0.5) $fdev = "<span style='color:red;'>".$fdev."</span>";
		$this->view->filterBefore = "总设备数量".count($this->view->data)." 连接着设备数".$cdev." 空闲设备数".$fdev." <a href='devoffline.php'>断线日志</a>";
	}

	//设备断线明细
	function devoffline()
	{
		$this->rowname = array('日志ID', 'mac地址', '时间', '任务ID', '功能ID');
		$this->view->paging["show"] = true;
		$this->view->paging["url"] = "devoffline.php?";
		$this->view->paging['colname'] = "order by logtime desc";
		$this->getdbdata("SELECT * FROM [games].[dbo].[DevOffline] ", "", "", " order by logtime desc");
	}

	//设备新增数量
	function gameconfig()
	{
		$this->rowname = array('游戏ID', '游戏名字', '日期', '新增数量', '活跃数量');
		if(empty($this->view->btime)) $this->view->btime = date("Y-m-d", time()-7*3600*24);
		$this->getdbdata("SELECT A.gameid,B.gname,CONVERT(varchar(10),ctime,120),COUNT(*),'' FROM [games].[dbo].[GameConfig] A inner join games.dbo.GameList B on A.gameid=B.gid ", "ctime", "", "group by A.gameid,B.gname,CONVERT(varchar(10),ctime,120) order by  A.gameid,B.gname,CONVERT(varchar(10),ctime,120)");
	}

	//最新执行日志列表
	function configlog()
	{
		$this->rowname = array('日志ID', 'mac地址', '任务id', '设备id', '功能id', '返回错误码', '完成时间', '执行时间', '操作');
		$this->view->paging["show"] = true;
		$this->view->paging["url"] = "configlog.php?";
		$this->view->paging['colname'] = "order by logtime desc";
		$this->getdbdata("SELECT [rid],[mac],A.[gameid],[dcid],[fid],CONVERT(varchar(16), [recode])+'_'+ISNULL(B.msgName,'') recode,[logtime],[leftsec] FROM [games].[dbo].[DevConfigLog] A left join games.dbo.MsgCodeConfig B on A.recode = B.msgCode ", "", "", " order by logtime desc");
		foreach($this->view->data as $k=>$v)
		{
			$this->view->data[$k][8] = "<a href='devinfo.php?dcid=".$v[3]."' target='_blank'>设备信息</a>";
		}
	}

	//执行错误分析
	function configfx()
	{
		$this->rowname = array('任务ID', '错误码', '数量');
		if(empty($this->view->btime) && empty($this->view->etime))
			$this->getdbdata("SELECT gameid,CONVERT(varchar(16), [recode])+'_'+ISNULL(B.msgName,'') recode,COUNT(*) FROM [games].[dbo].[DevConfigLog] A left join games.dbo.MsgCodeConfig B on A.recode = B.msgCode where DATEDIFF(S,logtime,GETDATE())<3600 group by gameid,CONVERT(varchar(16), [recode])+'_'+ISNULL(B.msgName,'')  order by gameid,CONVERT(varchar(16), [recode])+'_'+ISNULL(B.msgName,'')");
		else
			$this->getdbdata("SELECT gameid,CONVERT(varchar(16), [recode])+'_'+ISNULL(B.msgName,'') recode,COUNT(*) FROM [games].[dbo].[DevConfigLog] A left join games.dbo.MsgCodeConfig B on A.recode = B.msgCode where 1=1", "logtime", "", " group by gameid,CONVERT(varchar(16), [recode])+'_'+ISNULL(B.msgName,'')  order by gameid,CONVERT(varchar(16), [recode])+'_'+ISNULL(B.msgName,'')");
		$err = array();
		foreach($this->view->data as $v)
		{
			if(!isset($err[$v[1]])) $err[$v[1]] = 0;
			$err[$v[1]] += $v[2];
		}
		$this->view->filterAfter = "<br/>默认显示最近一小时的数据<br/>";
		foreach($err as $k=>$v)
		{
			if($k > 0 && $v > 20)
				$this->view->filterAfter .= $k.":<span style='color:#ff0000'>".$v."</span> ";
			else
				$this->view->filterAfter .= $k.":".$v." ";
		}
	}

	//设备明细
	function devinfo()
	{
		$this->rowname = array('设备ID','父设备','IMEI','IMEI2','IMSI','mac地址','运营商','网络类型','AndroidID','手机号码','vpn','其它账号','其它配置');
		if(intval($_GET["dcid"]) > 0)
		{
			$this->getdbdata("SELECT A.*,B.ocfg FROM [games].[dbo].[DevPhone] A inner join games.dbo.DevBase B on A.pid=B.pid where rid=".intval($_GET["dcid"]));
		}
		else
		{
			$this->view->paging["show"] = true;
			$this->view->paging["url"] = "devinfo.php?";
			$this->view->paging['colname'] = "order by rid";
			$this->getdbdata("SELECT A.*,B.ocfg FROM [games].[dbo].[DevPhone] A inner join games.dbo.DevBase B on A.pid=B.pid ", "", "", " order by rid");
		}
	}

	//执行时间
	function runtime()
	{
		$this->rowname = array('功能', "次数", '平均时间', '最大时间', '最小时间', '预计时间', '错误次数', '0次数', '错误继续次数');
		$this->app->initTime(true);
		$this->getdbdata("SELECT CONVERT(varchar(10),A.fid)+'_'+B.names,COUNT(*),AVG(leftsec),MAX(leftsec),MIN(leftsec),xtime,COUNT(case when recode > 0 and recode < 2000 then 1 else NULL end),COUNT(case when recode = 0 then 1 else NULL end),COUNT(case when recode > 2000 then 1 else NULL end) FROM [games].[dbo].[DevConfigLog] A inner join games.dbo.FunList B on A.fid=B.fid where 1=1 ", "logtime", "", " group by CONVERT(varchar(10),A.fid)+'_'+B.names,xtime");
		$d = $this->getdata("SELECT gameid,SUM(favg) from (SELECT [gameid],fid,AVG([leftsec]) favg FROM [games].[dbo].[DevConfigLog] where 1=1", "logtime", "", " group by gameid,fid) A group by gameid");
		$this->view->filterAfter = "<br/>任务平均需要时间(秒)<br/>";
		foreach($d as $v)
		{
			$this->view->filterAfter .= $v[0].":".$v[1]." ";
		}
	}

	//游戏报表
	function gameday()
	{
		$this->rowname = array('日期', "游戏名字", "新增", '活跃');
		$this->app->initTime(true);
		$this->getdbdata("SELECT CONVERT(varchar(10),logtime,120),B.gname,0,COUNT(*) FROM [games].[dbo].[DevConfigLog] A inner join games.dbo.GameList B on A.fid = B.ufid and recode = 0 where 1=1 ", "logtime", "", " group by CONVERT(varchar(10),logtime,120),B.gname");
		$d = $this->getdata("SELECT CONVERT(varchar(10),X.lt,120),gname,COUNT(*) from (SELECT B.gname,[dcid],MIN(logtime) lt FROM [games].[dbo].[DevConfigLog] A inner join games.dbo.GameList B on A.fid = B.ufid and recode = 0 group by B.gname,dcid) X where 1=1 ", "lt", "", " group by CONVERT(varchar(10),X.lt,120),gname");
		foreach($this->view->data as $k=>$v)
		{
			foreach($d as $v2)
			{
				if($v[0] == $v2[0] && $v[1] == $v2[1])
				{
					$this->view->data[$k][2] = $v2[2];
					break;
				}
			}
		}
		sort($this->view->data);
	}

	//vpn分析
	function vpnfx()
	{
		$this->rowname = array('设备/vpn', '错误次数');
		$this->app->initTime(true);
		$sql = "SELECT [mac],COUNT(*) FROM [games].[dbo].[DevConfigLog] where recode = 1018";
		$this->getSql($sql, "logtime", "", " group by mac");
		$sql .= " union all SELECT vpn,COUNT(*) FROM [games].[dbo].[DevConfigLog] A inner join games.dbo.DevConfig B on A.dcid = B.rid where recode = 1018 ";
		$this->getdbdata($sql, "logtime", "", " group by vpn");
	}
}