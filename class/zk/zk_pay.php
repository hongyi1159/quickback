<?php
/**
 * @copyright  Copyright (c) 2016
 * @since      File available since Release 0.0.0
 * @version    Release: 0.0.1
 * @author     hong <hongyi1159@126.com>
 */

class zk_pay extends baseController
{
	//充值分析
	function payfx()
	{
		$this->rowname = array('支付标识', '日期', '任务组ID', '支付金额', '支付次数', '成功次数', '成功金额', '失败次数', );
		if(empty($this->view->btime)) $this->view->btime = date("Y-m-d", time()-1*3600*24);
		$this->getdbdata("SELECT paytp,CONVERT(varchar(10),logtime,120),gpid,payNum,COUNT(*),COUNT(case when recode<0 then 1 else NULL end),COUNT(case when recode<0 then 1 else NULL end)*payNum,COUNT(case when recode>0 then 1 else NULL end) FROM [games].[dbo].[PayLog] where 1=1 ", "logtime", "", " group by paytp,CONVERT(varchar(10),logtime,120),gpid,payNum order by paytp,CONVERT(varchar(10),logtime,120),payNum");
	}

	//充值日志
	function paylog()
	{
		$this->rowname = array('日志编号', '支付标识', '支付信息', '设备编号', '任务编号', '钱数量', '返回码', '时间');
		$this->view->paging["show"] = true;
		$this->view->paging["url"] = "paylog.php?";
		$this->view->paging['colname'] = "order by logtime desc";
		$this->getdbdata("SELECT * FROM [games].[dbo].[PayLog] where 1=1 ", "logtime");
	}

	//卡情况
	function cardinfo()
	{
		$this->view->filterBefore = "<a href='cardinfo.php?cd=1'>所有卡</a> <a href='cardinfo.php'>有效卡</a>";
		$this->rowname = array( '支付标识', '支付信息', '总数', '已用', '正在使用');
		if($_GET["cd"] == "1")
			$this->getdbdata("SELECT * FROM [games].[dbo].[PayList]");
		else
			$this->getdbdata("SELECT * FROM [games].[dbo].[PayList] where allm>usedm");
		$d = $this->getdata("SELECT SUM(allm),SUM(case when usedm >= allm then allm else usedm end),SUM(usem) FROM [games].[dbo].[PayList]");
		$this->view->filterBefore .= "<br/>总金额".$d[0][0]." 已使用".$d[0][1]." 还剩".($d[0][0]-$d[0][1])." 正在使用".$d[0][2];
	}
}