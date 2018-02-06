<?php
/**
 * @copyright  Copyright (c) 2016
 * @since      File available since Release 0.0.0
 * @version    Release: 0.0.1
 * @author     hong <hongyi1159@126.com>
 */

class zk_phone extends baseController
{
	//设置手机
	function setphone()
	{

	}
	
	//获取任务列表
	function phone_save()
	{
		$this->getdbdata("update [games].[dbo].[iccidPhone] set phone='".str_replace("'", "''", $_GET['phone'])."',x=".intval($_GET['x']).",y=".intval($_GET['y'])." where iccid='".str_replace("'","''",$_GET['iccid'])."' 
		if(@@ROWCOUNT = 0)
		begin
			insert into [games].[dbo].[iccidPhone] values('".str_replace("'","''",$_GET['iccid'])."','".str_replace("'", "''", $_GET['phone'])."',".intval($_GET['x']).",".intval($_GET['y']).");
		end");
	}
	
}