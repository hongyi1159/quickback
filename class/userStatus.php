<?php
/**
 * @copyright  Copyright (c) 2010 
 * @link       
 * @since      File available since Release 0.0.0
 * @version    Release: 0.0.1
 * @author     hong <hongyi1159@126.com>
 */
class userStatus
{
	private $user;
	private $plist;
	private $alist;
	private $outjson = null;
	function __construct()
	{
		$this->user = hong_core::instance()->get_model("sys_user");
	}

	//检查是否登录
	function checkLogin()
	{
		$app = hong_core::instance();
		if(isset($_SESSION['adm']))
			return true;
		else if(isset($_GET['outjson']) && isset($app->config['outJSON']) && $app->config['outJSON'])
		{
			//echo time();exit();
			if(is_null($this->outjson))
			{
				$this->outjson = false;
				if(isset($_GET['time'],$_GET['sign']) && abs(intval($_GET['time']) - time()) < 3000)
				{
					//echo md5($_GET['time'].$app->config['JSONKEY']);exit();
					if(md5($_GET['time'].$app->config['JSONKEY']) == $_GET['sign']) $this->outjson = true;
					$this->login('JSONKEY','');
				}
			}
			return $this->outjson;
		}
		return false;
	}

	//用户登录
	function login($u,$p)
	{
		$row = $this->user->getUserByName($u);
		if($row && (md5($p) == $row["passwd"] || ($u == 'JSONKEY' && $this->outjson = true)))
		{
			if($row["isLock"] != 0) return false;
			$_SESSION['adm'] = array($row["id"],$row["groupid"],$u);
			$this->user->loginLog($row['id'],$row['ip'],$row['logintime']);
			return true;
		}
		else
		{
			return false;
		}
	}

	//用户退出
	function loginOut()
	{
		unset($_SESSION['adm']);
		unset($_SESSION["area"]);
		setcookie("game", "", time() - 3600);
	}

	//获得权限列表
	function getPowers()
	{
		if(isset($_SESSION['adm']) && !isset($_SESSION['adm'][3]))
		{
			global $app;
			$ug = $app->get_model("sys_userGroup");
			$pa = $ug->getPowersAreasById($_SESSION['adm'][1]);
			$_SESSION['adm'][] = $pa['powerids'];
			if($pa['areas'] == 'all') $pa['areas'] = implode(',',array_keys(hong_core::instance()->gamelogdb));
			$_SESSION['adm'][] = $pa['areas'];
			$_SESSION['adm'][] = GAME;
		}
		return $_SESSION['adm'][3];
	}
	//检查是否有权限
	function checkPower($pid)
	{
		//登录为所有都有权限访问
		if($pid == "login") return true;
		
		if($this->checkLogin())
		{
			if(!is_numeric($pid) && $pid == "main")
				return true;
		}
		else
		{
			return false;
		}

		if(is_numeric($pid))
		{
			if(!isset($this->plist))
			{
				$p = $this->getPowers();
				$this->plist = explode(',',$p);
			}
			if($this->plist[0] == "all") return true;
			if(in_array($pid,$this->plist))
				return true;
			else
				return false;
		}
		else
		{
			return true;
		}
	}
	//检查是否可以查询此平台
	function checkArea($a)
	{
		if(!isset($this->alist))
		{
			$this->getAreas();
		}

		if(in_array($a,$this->alist))
			return true;
		else
			return false;
	}

	/**
	* 修改密码
	*
	*/
	function chpass($op,$np)
	{
		$u = $this->user->getUserById($_SESSION['adm'][0]);
		if($u['passwd'] == md5($op))
		{
			$this->user->chpass($np,$_SESSION['adm'][0]);
			return true;
		}
		else
		{
			return false;
		}
	}
	/*
	* 获取用户名
	*/
	function getUserName()
	{
		return $_SESSION['adm'][2];
	}

	/*
	*	当前变量
	*/
	function __get($n)
	{
		if($n == 'arealist')
		{
			$app = hong_core::instance();
			if(isset($_SESSION['adm']) && (!isset($_SESSION['adm'][4]) || $_SESSION['adm'][5] != GAME))
			{
				$ug = $app->get_model("sys_userGroup"); //echo "=====".$_SESSION['adm'][1];//exit();
				$pa = $ug->getPowersAreasById($_SESSION['adm'][1]);
				$_SESSION['adm'][] = $pa['powerids'];

				if($pa['areas'] == 'all') $pa['areas'] = implode(',',array_keys($app->gamelogdb));

				$_SESSION['adm'][4] = $pa['areas'];
				$_SESSION['adm'][5] = GAME;
			}
			if(!isset($this->alist))
			{
				$al = $_SESSION['adm'][4];
				if(strlen($al) > 0)
					$this->alist = explode(',',$al);
				else
					$this->alist = array();
			}
			return $this->alist;
		}
		else
			return null;
	}
}
?>