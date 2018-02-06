<?php
/**
 * @copyright  Copyright (c) 2016
 * @since      File available since Release 0.0.0
 * @version    Release: 0.0.1
 * @author     hong <hongyi1159@126.com>
 */

class zk_funs extends baseController
{
	//功能列表
	function funslist()
	{
		$this->view->filterBefore = "<a href='funsadd.php'>添加功能</a>";
		$this->rowname = array('功能编号', '功能名字', '游戏编号', '游戏名称', '脚本文件', '等待类型', '预计时间', '操作');
		$this->getdbdata("SELECT [fid],[names],A.[gid],B.gname,[url],[waittp],xtime FROM [games].[dbo].[FunList] A inner join games.dbo.GameList B on A.gid = B.gid order by fid desc");
		foreach($this->view->data as $k=>$v)
		{
			$this->view->data[$k][7] = "<a href='funsadd.php?fid=".$v[0]."'>修改</a>";// <a href='gamedel.php?gid=".$v[0]."'>删除</a>";
			if($v[5] == 1) $this->view->data[$k][5] = '等待手机号激活';
			else if($v[5] == 2) $this->view->data[$k][5] = '等待短信';
		}
	}

	//添加修改功能
	function funsadd()
	{
		$this->view->fid = intval($_GET["fid"]);
		$this->view->gmid = intval($_GET["gmid"]);
		$this->view->names = str_replace("'","''",$_GET["names"]);
		$this->view->url = str_replace("'","''",$_GET["url"]);
		$this->view->waittp = intval($_GET["waittp"]);
		$this->view->xtime = intval($_GET["xtime"]);
		if($this->view->fid > 0)
		{
			if(isset($_GET["names"]))
			{
				$this->getdata("update [games].[dbo].[FunList] set [names]='".$this->view->names."',gid=".$this->view->gmid.",url='".$this->view->url."',waittp=".abs($this->view->waittp).",xtime=".$this->view->xtime." where fid=".$this->view->fid."
				if(@@ROWCOUNT = 0) insert into [games].[dbo].[FunList] values(".$this->view->fid.",".$this->view->gmid.",'".$this->view->names."','','".$this->view->url."',".abs($this->view->waittp).",".$this->view->xtime.")");
				$this->app->redirect("view/funslist.php");
			}
			else
			{
				$d = $this->getdata("SELECT * FROM [games].[dbo].[FunList] where fid=".$this->view->fid);
				$this->view->gmid = $d[0][1];
				$this->view->names = $d[0][2];
				$this->view->url = $d[0][4];
				$this->view->waittp = -$d[0][5];
				$this->view->xtime = $d[0][6];
			}
		}
	}

	//删除功能
	function gamedel()
	{
		$this->view->fid = intval($_GET["fid"]);
		if($this->view->fid > 0)
		{
			$this->getdata("DELETE [games].[dbo].[FunList] where fid=".$this->view->fid);
			$this->app->redirect("view/funslist.php");
		}
	}

	//任务列表
	function funglist()
	{
		//$this->view->filterAfter = "<br/><a href='fungadd.php'>添加任务</a> <a href='funlids.php'>功能组列表</a> <a href='glist.php'>任务表</a>";
		$this->app->initTime(true);
		$this->rowname = array('任务编号', '任务名字', '功能', '要求数量', '当前数量', '排序号', '注册时间', '执行概率', '执行延迟(单位10秒)', '扩展', '指定设备', '设备表');
		$this->getdbdata("SELECT A.[gpid],A.[names],Convert(varchar(20),B.[fid])+'_'+C.names,D.[rNum],ISNULL(E.[cNum],0),B.[sort],A.[isNew],B.[prob],D.[btype],A.edata,A.mackey,A.[devtb] FROM [games].[dbo].[FGNames] A 
inner join games.dbo.FunGroup B on A.funlid = B.funlid inner join [games].[dbo].[FunList] C on B.fid=C.fid 
inner join games.dbo.TaskDay D on A.gpid = D.gpid and DATEDIFF(DAY,D.dt,'".$this->view->btime."')=0 
left join games.dbo.FGDayRun E on A.gpid = E.gpid and B.fid = E.fid and D.dt = E.dt
order by A.gpid,sort");
		$ov = null;
		foreach($this->view->data as $k=>$v)
		{
			if($ov && $ov[0] == $v[0])
			{
				if($ov[4] > 0 && $v[4] > 0 && $v[4] / $ov[4] < 0.7) $this->view->data[$k][4] = "<span style='color:red;'>".$v[4]."</span>";
			}
			$ov = $v;
		}
	}

	//功能组列表
	function funlids()
	{
		$this->rowname = array('功能组ID', '功能ID', '排序号', '执行概率', '操作');
		$this->view->filterAfter = "<a href='fungfadd.php'>添加功能到功能组</a>";
		$this->getdbdata("SELECT * from games.dbo.FunGroup order by funlid desc,sort");
		foreach($this->view->data as $k=>$v)
		{
			$this->view->data[$k][4] = "<a href='fungfadd.php?funlid=".$v[0]."&sorts=".$v[2]."'>修改</a>";
		}
	}

	//任务表
	function glist()
	{
		$this->rowname = array('任务编号', '任务名字', '功能组','注册时间','指定设备','设备表', '操作');
		$this->getdbdata("SELECT * from games.dbo.FGNames");
		foreach($this->view->data as $k=>$v)
		{
			$this->view->data[$k][6] = "<a href='fungadd.php?gid=".$v[0]."'>修改</a>";
		}
	}

	//任务添加
	function fungadd()
	{
		$this->view->gid = intval($_GET["gid"]);
		$this->view->names = str_replace("'","''",$_GET["names"]);
		$this->view->funlid = intval($_GET["funlid"]);
		$this->view->isNew = intval($_GET["isNew"]);
		$this->view->mackey = str_replace("'","''",$_GET["mackey"]);
		$this->view->devtb = str_replace("'","''",$_GET["devtb"]);
		if($this->view->gid > 0)
		{
			if(isset($_GET["names"]))
			{
				$this->getdata("update [games].[dbo].[FGNames] set [names]='".$this->view->names."',funlid=".$this->view->funlid.",isNew=".$this->view->isNew.",[mackey]='".$this->view->mackey."',[devtb]='".$this->view->devtb."' where gpid=".$this->view->gid."
				if(@@ROWCOUNT = 0) insert into [games].[dbo].[FGNames] values(".$this->view->gid.",'".$this->view->names."',".$this->view->funlid.",".$this->view->isNew.",'".$this->view->mackey."','".$this->view->devtb."')");
				$this->app->redirect("view/glist.php");
			}
			else
			{
				$d = $this->getdata("SELECT * FROM [games].[dbo].[FGNames] where gpid=".$this->view->gid);
				$this->view->names = $d[0][1];
				$this->view->funlid = $d[0][2];
				$this->view->isNew = $d[0][3];
				$this->view->mackey = $d[0][4];
				$this->view->devtb = $d[0][5];
			}
		}
	}

	//功能组添加功能
	function fungfadd()
	{
		$this->view->funlid = intval($_GET["funlid"]);
		$this->view->fid = intval($_GET["fid"]);
		$this->view->sorts = intval($_GET["sorts"]);
		$this->view->prob = intval($_GET["prob"]);
		if($this->view->funlid > 0 && $this->view->sorts > 0)
		{
			if($this->view->fid > 0)
			{
				$this->getdata("update [games].[dbo].[FunGroup] set fid=".$this->view->fid.",prob=".$this->view->prob." where funlid=".$this->view->funlid." and sort=".$this->view->sorts."
				if(@@ROWCOUNT = 0) insert into [games].[dbo].[FunGroup] values(".$this->view->funlid.",".$this->view->fid.",".$this->view->sorts.",".$this->view->prob.")");
				$this->app->redirect("view/funlids.php");
			}
			else
			{
				$d = $this->getdata("SELECT * FROM [games].[dbo].[FunGroup] where funlid=".$this->view->funlid." and sort=".$this->view->sorts);
				$this->view->fid = $d[0][1];
				$this->view->prob = $d[0][3];
			}
		}
	}

	//每日任务列表
	function daytask()
	{
		$this->view->filterAfter = " <a href='dayadd.php'>添加任务</a>";
		$this->rowname = array('日期', '任务编号', '任务名字', '要求数量', '执行间隔', '操作');
		$this->app->initTime(true);
		$this->getdbdata("SELECT [dt],A.[gpid],B.names,[rNum],[btype] FROM [games].[dbo].[TaskDay] A inner join games.dbo.FGNames B on A.gpid = B.gpid", "[dt]", "", " order by dt, gpid");
		foreach($this->view->data as $k=>$v)
		{
			$this->view->data[$k][5] = "<a href='dayadd.php?btime=".$v[0]->format("Y-m-d")."&gpid=".$v[1]."'>修改</a>";
		}
	}

	//每日任务添加
	function dayadd()
	{
		$this->view->gpid = intval($_GET["gpid"]);
		$this->view->rNum = intval($_GET["rNum"]);
		$this->view->btype = intval($_GET["btype"]);
		if(!empty($this->view->btime) && $this->view->gpid > 0)
		{
			if($this->view->rNum > 0)
			{
				$this->getdata("update [games].[dbo].[TaskDay] set rNum=".$this->view->rNum.", btype=".$this->view->btype." where dt='".$this->view->btime."' and gpid=".$this->view->gpid."
				if(@@ROWCOUNT = 0) insert into [games].[dbo].[TaskDay] values('".$this->view->btime."',".$this->view->gpid.",".$this->view->rNum.",".$this->view->btype.")");
				$this->app->redirect("view/daytask.php");
			}
			else
			{
				$d = $this->getdata("SELECT * FROM [games].[dbo].[TaskDay] where gpid=".$this->view->gpid." and dt='".$this->view->btime."'"); //var_dump($d);
				$this->view->gpid = $d[0][1];
				$this->view->rNum = $d[0][2];
				$this->view->btype = $d[0][3];
			}
		}
	}
}