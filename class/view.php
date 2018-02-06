<?php
/**
 * @copyright  Copyright (c) 2010 七酷 (http://www.7cool.cn)
 * @link       http://www.7cool.cn
 * @since      File available since Release 0.0.1
 * @version    Release: 0.0.1
 * @author     hong <hongyi1159@126.com>
 */

class view
{
	private $_pro;

	function __construct()
	{
		$this->data = array();
		$this->sum = array();
		$this->rowname = array();
		$this->iscansort = false;
		$this->filterBefore = '';
		$this->filterAfter = '';
		if(defined('ACTION'))
		{
			$app = hong_core::instance();
			$m = $app->get_model("sys_power",$app->powerdb);
			$this->parentpage = $this->page = $m->getControllerByAction(ACTION);
			$i = 0;//限制菜单的深度
			while($this->parentpage['pid'] != 0)
			{
				$this->parentpage = $m->getControllerById($this->parentpage['pid']);
				$i++;
				if($i > 5){var_dump($this->page);exit();}
			}
		}
		//初始化筛选列
		$this->filterV = array(
			'allSer'=>false,//是否显示服务器选择列表中所有选择项
			'selectSer'=>false,//单项选择服务列表
			'checkSer'=>false,//多项选择服务类别
			'checkChid'=>false,//多项选择渠道ID
			'btime'=>false,//开始时间
			'etime'=>false,//结束时间
			'submit'=>false, //提交按钮
			'outexl'=>false //提交按钮
		);
		//分页
		$this->paging = array('show'=>false,'p'=>1,'rd'=>0,'ps'=>100,'url'=>'','colname'=>'');
	}

	/*
	*	显示页面选择条件
	*/
	function showFilter()
	{
		echo $this->filterBefore;
		//多项选择渠道ID
		if($this->filterV['checkChid'])
		{
			$app = hong_core::instance();
			$i = 0;
			foreach($app->config['qdqd'] as $k=>$v)
			{ 
				echo " <input id='",$k,"' type='checkbox' name='chid[]' value='",$k,"' ",(isset($_GET['chid']) && in_array($k,$_GET['chid'])?"checked":""),"/><label for='",$k,"' style='display:inline-block;width:100px;'>",$v,"</label>";
				$i++;
				if($i % 10 == 0) echo "<br/>";
			}
			echo "<br/>";
		}
		//判断是否需要显示选择服务器
		if($this->filterV['selectSer'])
		{
			echo '游戏列表:<select name="ser">';
			if($this->filterV['allSer']) echo '<option value="all">所有</option>';
			foreach($this->serlist as $k=>$v)
			{ 
				echo "<option value='",$k,"' ",(count($this->viewser) == 1 && in_array($k,$this->viewser)?"selected":""),">",$v,"</option>";
			}
			echo "</select> ";
		}
		else if($this->filterV['checkSer'])
		{
			foreach($this->serlist as $v)
			{ 
				echo " <input type='checkbox' name='ser[]' value='",$v,"' ",(in_array($v,$this->viewser)?"checked":""),"/>S",$v;
			}
			echo "<br/>";
		}
		//开始时间
		if($this->filterV['btime'])
			echo "日期: <input type='text' value='",$this->btime,"' name='btime' id='btime' /> ";
		//结束时间
		if($this->filterV['etime'])
		{
			if($this->filterV['btime']) echo "- ";
			echo "<input type='text' value='",$this->etime,"' name='etime' id='etime' /> ";
		}
		if($this->filterV['submit'])
			echo '<input type="submit" value="查询" />';
		if($this->filterV['outexl'])
			echo '<input type="submit" value="导出excel" name="outexl" />';
		echo $this->filterAfter;
	}

	/*
	*	获取显示页码的html代码
	*/
	function pageView()
	{
		$pv = "<div class='pagelist'>记录数:".$this->paging['rd']." ";
		$pa = ceil($this->paging['rd'] / $this->paging['ps']);
		if($this->paging['p'] > $pa) $this->paging['p'] = $pa;
		$b = 1;
		$e = $pa;
		if($pa > 50)
		{
			if($this->paging['p'] > 10)
			{
				$pv .= "<a href='".$this->paging['url']."1'><<</a>";
				$b = $this->paging['p'] - 10 + 1;
			}
			if($pa > $this->paging['p'] + 10) $e = $this->paging['p'] + 10;
		}
		for($i = $b;$i <= $e;$i++)
			$pv .= "<a href='".$this->paging['url'].$i."'".($i == $this->paging['p']?" class='s'":'').">".$i."</a>";
		if($e != $pa)
			$pv .= "<a href='".$this->paging['url'].$pa."'>>></a>";
		$pv .= "</div>";
		return $pv;
	}

	/*
	*	显示页面数据
	*/
	function showpagedata()
	{
		//显示标题行
		echo "<tr class='title_5'>";
		$colnum = 0;
		foreach($this->rowname as $v) 
		{
			if($this->iscansort)
				echo "<th onclick='sortTable(",$colnum,")'>",$v,"</th>";
			else
				echo "<th>",$v,"</th>";
			$colnum++;
		}
		echo "</tr>";
		//显示翻页
		if($this->paging['show'])
		{
			echo "<tr><td colspan='",$colnum,"'>";
			echo $this->pageView();
			echo "</td></tr>";
		}
		//显示数据行
		$rnum = 0;
		foreach($this->data as $v)
		{
			if($rnum % 2 == 0)
				echo "<tr align='center'>";
			else
				echo "<tr class='row1' align='center'>";
			foreach($v as $v2)
			{
				if($v2 instanceof DateTime)
					echo "<td>",$v2->format('Y-m-d H:i:s.u'),"</td>";
				else if($this->iscansort)
					echo "<td abbr=\"",$v2,"\">",$v2,"</td>";
				else
					echo "<td>",$v2,"</td>";
			}
			echo "</tr>";
			$rnum++;
		}
		//显示汇总行
		if($this->sum) echo "<tr class='title_4'>";
		foreach($this->sum as $v)
			echo "<td>",$v,"</td>";
		if($this->sum) echo "</tr>";
		//显示翻页
		//var_dump($this->paging);
		if($this->paging['show'])
		{
			echo "<tr><td colspan='",count($this->rowname),"'>";
			echo $this->pageView();
			echo "</td></tr>";
		}
	}

	//获取属性
	function __get($n)
	{
		if(isset($this->_pro[$n]))
		{
			return $this->_pro[$n];
		}
		else
		{
			switch($n)
			{
				case "serlistall":
					$app = hong_core::instance();
					//if($app->curarea != '所有')
					//	return $this->_pro[$n] = array_keys($app->gamelogdb[$app->curarea]);
					//else
					//	return $this->_pro[$n] = array();
					$this->_pro[$n] = $app->config['qpgames'];
					break;
				case "serlist":
					$app = hong_core::instance();
					//$tmp = array();
					//if($app->curarea != '所有')
					//{
						//foreach($app->gamelogdb[$app->curarea] as $k=>$v)
						//{
						//	if(!(isset($v[2]) && $v[2] == '1')) $tmp[] = $k;
						//}
					//}
					return $this->_pro[$n] = $app->config['qpgames'];
					break;
				case "viewser":
					if(isset($_GET['ser']))
					{
						if(is_array($_GET['ser']))
							$this->_pro[$n] = $_GET['ser'];
						else
							$this->_pro[$n] = array($_GET['ser']);
						if($this->_pro[$n][0] == 'all')
						{
							$this->_pro[$n] = array();
							foreach($this->serlistall as $v)
								$this->_pro[$n][] = $v;
						}
					}
					else
						$this->_pro[$n] = array();
					return $this->_pro[$n];
					break;
				case "pageindex":
					if(isset($_GET['p']))
					{
						$this->paging['p'] = intval($_GET['p']);
						if($this->paging['p'] < 1) $this->paging['p'] = 1;
					}
					return $this->paging['p'];
				default:
					return null;
			}
		}
	}
}