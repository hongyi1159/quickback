<?php
/**
 * @copyright  Copyright (c) 2016
 * @since      File available since Release 0.0.0
 * @version    Release: 0.0.1
 * @author     hong <hongyi1159@126.com>
 */

class zk_game extends baseController
{
	//游戏列表
	function gamelist()
	{
		$this->view->filterBefore = "<a href='gameadd.php'>添加游戏</a>";
		$this->rowname = array('游戏编号', '游戏名称', '操作');
		$this->getdbdata("SELECT [gid],[gname] FROM [games].[dbo].[GameList]");
		foreach($this->view->data as $k=>$v)
		{
			$this->view->data[$k][2] = "<a href='gameadd.php?gid=".$v[0]."'>修改</a>";// <a href='gamedel.php?gid=".$v[0]."'>删除</a>";
		}
	}

	//添加修改游戏
	function gameadd()
	{
		$this->view->gid = intval($_GET["gid"]);
		$this->view->gname = $_GET["gname"];
		$this->view->ufid = intval($_GET["ufid"]);
		if($this->view->gid > 0)
		{
			if(isset($this->view->gname))
			{
				$this->getdata("update [games].[dbo].[GameList] set [gname]='".str_replace("'","''",$this->view->gname)."',ufid=".$this->view->ufid." where gid=".$this->view->gid."
				if(@@ROWCOUNT = 0) insert into [games].[dbo].[GameList] values(".$this->view->gid.",'".str_replace("'","''",$this->view->gname)."',".$this->view->ufid.")");
				$this->app->redirect("view/gamelist.php");
			}
			else
			{
				$d = $this->getdata("SELECT [gname] FROM [games].[dbo].[GameList] where gid=".$this->view->gid);
				$this->view->gname = $d[0][0];
			}
		}
	}

	//删除游戏
	function gamedel()
	{
		$this->view->gid = intval($_GET["gid"]);
		if($this->view->gid > 0)
		{
			$this->getdata("DELETE [games].[dbo].[GameList] where gid=".$this->view->gid);
			$this->app->redirect("view/gamelist.php");
		}
	}

	//执行中控命令
	function center()
	{

	}
}