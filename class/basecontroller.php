<?php
/**
 * @copyright  Copyright (c) 2015
 * @since      File available since Release 0.0.0
 * @version    Release: 0.0.1
 * @author     hong <hongyi1159@126.com>
 */

 class baseController
 {
	var $app;								//全局对象
	var $data;								//显示的数据
	var $roomlist;							//配置的房间列表
	var $rowname;							//查询信息显示的字段名
	var $view;								//页面对象

	function __construct()
	{
		$this->app = hong_core::instance();
		$this->app->initTime();
		$this->data = &$this->app->view->data;
		//$this->roomlist = &$this->app->config['room'];
		$this->rowname = &$this->app->view->rowname;
		$this->view = &$this->app->view;
	}

	//获取显示数据
	function getdbdata($sql, $timeName='', $kindName='', $sqlend='', $chName='')
	{
		$msdb = $this->app->loadmsdb($this->app->viewonearea,"1",$this->app->gamelogdb[$this->app->viewonearea]["1"][0],$this->app->gamelogdb[$this->app->viewonearea]["1"][1]);
		$this->getSql($sql, $timeName, $kindName, $sqlend, $chName, $msdb);//echo $sql;
		$this->data = $msdb->getRowsData($sql);
		if($this->view->paging['show'])
		{
			$collen = count($this->view->rowname);
			foreach($this->data as $k=>$v)
			{
				if($this->data[$k][$collen]) unset($this->data[$k][$collen]);
			}
		}
	}
	
	//获取实时显示数据
	function getonlinedbdata($sql, $timeName='', $kindName='', $sqlend='', $chName='')
	{
		$msdb = $this->app->loadmsdb($this->app->viewonearea,"2",$this->app->gamelogdb[$this->app->viewonearea]["2"][0],$this->app->gamelogdb[$this->app->viewonearea]["2"][1]);
		$this->getSql($sql, $timeName, $kindName, $sqlend, $chName, $msdb);
		$this->data = $msdb->getRowsData($sql);
		if($this->view->paging['show'])
		{
			$collen = count($this->view->rowname);
			foreach($this->data as $k=>$v)
			{
				if($this->data[$k][$collen]) unset($this->data[$k][$collen]);
			}
		}
	}

	//获取数据
	function getdata($sql, $timeName='', $kindName='', $sqlend='', $chName='')
	{
		$this->getSql($sql, $timeName, $kindName, $sqlend, $chName);
		
		$msdb = $this->app->loadmsdb($this->app->viewonearea,"1",$this->app->gamelogdb[$this->app->viewonearea]["1"][0],$this->app->gamelogdb[$this->app->viewonearea]["1"][1]);
		return $msdb->getRowsData($sql);
	}
	
	//获取数据
	function getonlinedata($sql, $timeName='', $kindName='', $sqlend='', $chName='')
	{
		$this->getSql($sql, $timeName, $kindName, $sqlend, $chName);
		
		$msdb = $this->app->loadmsdb($this->app->viewonearea,"2",$this->app->gamelogdb[$this->app->viewonearea]["2"][0],$this->app->gamelogdb[$this->app->viewonearea]["2"][1]);
		return $msdb->getRowsData($sql);
	}

	function addTime(&$sql, $tname, $pg=false)
	{
		if(!empty($this->app->view->btime)){
			$sql .= " and ".$tname.">='".$this->app->view->btime."'";
			if($this->view->paging['show'] && $pg)
			{
				$this->view->paging['url'] .= '&btime='.$this->app->view->btime;
			}
		}
		if(!empty($this->app->view->etime)){
			$sql .= " and ".$tname."<'".$this->app->view->etime."'";
			if($this->view->paging['show'] && $pg)
			{
				$this->view->paging['url'] .= '&etime='.$this->app->view->etime;
			}
		}
	}
	
	//获取sql语句
	function getSql(&$sql, $timeName='', $kindName='', $sqlend='', $chName='', $msdb=null)
	{
		if($timeName)
		{
			$this->addTime($sql, $timeName, true);
		}
		if($kindName)
		{
			if(intval($this->app->view->viewser[0]) > 0)
			{	
				if($this->app->view->kindChannelID)
				{
					$sql .= " and ".$kindName."='".$this->app->config['qpkindgame'][$this->app->view->viewser[0]]."'";
				}
				else if($this->app->view->viewser[0] == 1620 && $chName)
				{
					$sql .= " and SUBSTRING(".$chName.",2,2)='06'";
				}
				else if($this->app->view->viewser[0] == 2620 && $chName)
				{
					$sql .= " and SUBSTRING(".$chName.",2,2)='10'";
				}
				else
				{
					$sql .= " and ".$kindName."=".intval($this->app->view->viewser[0]);
				}
			}
		}
		if(intval($this->app->view->viewser[0]) > 0 && $chName)
		{				
			if(count($_GET['chid']) > 0) 
			{
				$sql .= " and ".$chName." in('-1'";//$sql .= " and RIGHT(".$chName.", 3) in('-1'";
				foreach($_GET['chid'] as $v)
				{
					if(is_numeric($v))
					{
						if($v == '000' && $this->app->config['qpkindgame'][$this->app->view->viewser[0]] == '02') //斗地主统一更新只查android
						{
							$sql .= ",'1".$this->app->config['qpkindgame'][$this->app->view->viewser[0]].$v."'";
						}
						else if($v == '043' && $this->app->config['qpkindgame'][$this->app->view->viewser[0]] == '02') //斗地主打包渠道错误特殊处理
						{
							$sql .= ",'2".$this->app->config['qpkindgame'][$this->app->view->viewser[0]]."000','2".$this->app->config['qpkindgame'][$this->app->view->viewser[0]].$v."'";
							//$sql .= ",'000','".$v."'";
						}
						else
						{
							$sql .= ",'2".$this->app->config['qpkindgame'][$this->app->view->viewser[0]].$v."','1".$this->app->config['qpkindgame'][$this->app->view->viewser[0]].$v."'";//$sql .= ",'".$v."'";
						}
					}
				}
				$sql .= ")";
			}	
		}		
		if($msdb && $this->view->paging['show'])
		{
			if(isset($this->view->paging['sumcol']))
				$csql = "select ".$this->view->paging['sumcol']." from (".$sql.") G";
			else
				$csql = "select count(*) from (".$sql.") G";		
			$data = $msdb->getRowsData($csql);
			$this->view->paging['rd'] = $data[0][0];
			$this->view->paging['sumdata'] = $data[0];
			$this->view->paging['url'] .= '&p=';

			$pos = stripos($sql, "from");
			$sqlpre = substr($sql, 0, $pos);
			$sql = substr($sql, $pos);
			$sql = "select * from (".$sqlpre.',row_number() over('.$this->view->paging['colname'].') as rnum '.$sql.") H where rnum > ".(($this->view->pageindex-1)*$this->view->paging['ps'])." and rnum <= ".($this->view->pageindex*$this->view->paging['ps']);
			//echo $sql;
		}
		if($sqlend) $sql .= $sqlend;
		//echo $sql;
	}
	
	//获取渠道名字
	function getChannelName($chid)
	{
		if(isset($this->app->config['qdpt'][substr($chid, 0, 1)]) && isset($this->app->config['qdgame'][substr($chid, 1, 2)]) && isset($this->app->config['qdqd'][substr($chid, 3, 3)]))
		{
			$chid = $this->app->config['qdpt'][substr($chid, 0, 1)].'_'.$this->app->config['qdgame'][substr($chid, 1, 2)].'_'.$this->app->config['qdqd'][substr($chid, 3, 3)];
		}
		return $chid;
	}

	//获取redis
	function getRedis()
	{
		$rd = new Redis();
		$rd->connect($this->app->config['redisIP'], $this->app->config['redisPort']);
		return $rd;
	}
 }