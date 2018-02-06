<?php
/**
 * @copyright  Copyright (c) 2010 
 * @link       
 * @since      File available since Release 0.0.2
 * @version    Release: 0.1.0
 * @author     hong <hongyi1159@126.com>
 */
define('IN_HONG', true);
date_default_timezone_set("Asia/Shanghai");

class hong_core
{

	var $dblist = array();
	var $modlist = array();
	var $userdb;
	var $powerdb;
	private $_pro = array();

	static function &instance()
	{
		static $obj;
		if(empty($obj)) {
			//为了兼容以前的老代码（用new 定义hong_core对象的）
			global $app;
			if(is_object($app))
				$obj = $app;
			else
				$app = $obj = new hong_core();
			if(defined('ISLOGIN'))
			{
				if(!$obj->isLogin())
					$obj->redirect('login.php');
			}
		}
		return $obj;
	}

	function __construct()
	{
		$this->_init_env();
		$this->_init_db();
	}

	function _init_env()
	{
		set_time_limit(120);
		define('HROOT', substr(dirname(__FILE__),0,-5));

		include HROOT."./config/config_global.php";

		global $g_var;
		$this->_pro['config'] = $g_var['config'] = $g_config;
		$g_var['ip'] = $this->_get_client_ip();
		$g_var['starttime'] = microtime(true);

		if($g_var['config']['debug'] == 1)
			error_reporting(E_ALL);
		else
			include HROOT."class/error.php";;

		//设置当前游戏
		if(isset($_COOKIE['game']) && in_array($_COOKIE['game'],$this->config['gamelist']))
			define('GAME',$_COOKIE['game']);
		else
			define('GAME',$this->config['gamelist'][0]);
	}

	function _init_db()
	{
		if(!isset($this->userdb))
		{
			$this->loadFileDBClass();
			$this->userdb = new mySqlite(HROOT.$this->config['sqlitedir'].'mydb.php');
			if(file_exists(HROOT.$this->config['sqlitedir'].'config_'.GAME.'.php'))
				$this->powerdb = new mySqlite(HROOT.$this->config['sqlitedir'].'config_'.GAME.'.php');
			else
				$this->powerdb = $this->userdb;
		}
		return $this->userdb;
	}

	function &get_model($mname,$param = null)
	{
		if(empty($this->modlist))
			include HROOT."./class/model/model_base.php";
		if(!isset($this->modlist[$mname]))
		{
			if(file_exists(HROOT."./class/model/".$mname.'.php'))
			{
				include HROOT."./class/model/".$mname.".php";
				$this->modlist[$mname] = new $mname($param);
			}
			else
			{
				exit("model load error");
			}
		}
		return $this->modlist[$mname];
	}

	/* 
	* 获取文件数据库对象
	*/
	function &get_fileDB($f,$k = null)
	{
		global $g_var;
		if(!isset($k)) $k = md5($f);
		if(!isset($g_var['filedb'][$k]))
		{
			$this->loadFileDBClass();
			$g_var['filedb'][$k] = new mySqlite(HROOT.$f);
		}
		return $g_var['filedb'][$k];
	}

	/*
	*	获取文件数据库类
	*/
	function loadFileDBClass()
	{
		if(!class_exists('mySqlite'))
		{
			global $g_var;
			if((isset($g_var['config']['sqlite2']) && $g_var['config']['sqlite2']) || !class_exists('Sqlite3')) //
				include HROOT."./class/DB/sqlite2.php";
			else
				include HROOT."./class/DB/sqlite.php";
		}
	}

	function _get_client_ip() 
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		global $g_var;
		if($g_var['config']['allowproxy'])
		{
			if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
				foreach ($matches[0] AS $xip) {
					if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
						$ip = $xip;
						break;
					}
				}
			}
		}
		return $ip;
	}

	function redirect($p = "")
	{
		global $g_var;
		header("Location:".$g_var['config']['webpath'].$p);
		exit();
	}

	//检查是否登陆
	function isLogin()
	{
		return $this->userStatus->checkLogin();
	}
	/*
	* 获得平台菜单数组
	*/
	function getMenu()
	{
		global $g_var;
		$m = $this->get_model("sys_power");
		$pids = $this->userStatus->getPowers();
		$menu = array();
		$menustr = "<div class='leftTb'><div class='title_1'>信息统计</div>";
		if($this->view->parentpage)
		{
			if($pids == 'all')
				$menu = $m->getPowerByPid($this->view->parentpage['id']);
			else
				$menu = $m->getPowerByPidIds($this->view->parentpage['id'],$pids);
		}
		foreach($menu as $v)
		{
			if($v['pid'] == $this->view->parentpage['id'])
			{
				if(!empty($v['action']))
				{
					if(strpos($v['action'],'_')>0)
					{
						$arr = explode('_',$v['action']);
						$menustr .= "<a href='./".$arr[1].".php'>".$v['title']."</a>";
					}
					else
						$menustr .= "<a href='./".$v['action'].".php'>".$v['title']."</a>";
				}
				else
				{
					$menustr .= "<a onclick=\"menushow('#p".$v['id']."')\">".$v['title']."</a><div style='display:none;' id='p".$v['id']."'>";
					$tmp = array();
					if($pids == 'all')
						$tmp = $m->getPowerByPid($v['id']);
					else
						$tmp = $m->getPowerByPidIds($v['id'],$pids);
					foreach($tmp as $tv)
					{
						if(strpos($tv['action'],'_')>0)
						{
							$arr = explode('_',$tv['action']);
							$menustr .= "<a style='background:none;padding-left:20px' href='./".$arr[1].".php'>".$tv['title']."</a>";
						}
						else
						{
							$menustr .= "<a style='background:none;padding-left:20px' href='./".$tv['action'].".php'>".$tv['title']."</a>";
						}
					}
					$menustr .= "</div>";
				}
			}
		}
		$menustr .= "</div>";
		return $menustr;
	}
	/*
	* 获得顶部菜单数组
	*/
	function topMenu()
	{
		$m = $this->get_model("sys_power",$this->powerdb);
		$pids = $this->userStatus->getPowers();
		$menu = array();
		if($pids == 'all')
			$menu = $m->getPowerPAll();
		else
			$menu = $m->getPowerPByIds($pids);
		return $menu;
	}

	/*
	*	获取当前页面数据
	*/
	function getPageData()
	{
		$pow = $this->get_model("sys_power",$this->powerdb);
		$c = null;
		if(defined('ACTION')) $c = $pow->getControllerByAction(ACTION);
		$u = $this->userStatus;
		if(!$u->checkPower($c['id']) || $c == null)
		{
			$this->userStatus->loginOut();
			$this->redirect("msg.php?m=没有权限");
		}
		$controller = $this->loadController($c['pages']);
		$act = ACTION;
		if(method_exists($controller,ACTION))
		{
			if(isset($_GET['outexl']))
			{
				$this->view->paging['ps'] = 10000;
			}
			$data = $controller->$act();
			if(isset($_GET['outexl']))
			{
				set_time_limit(0);
				//输出excel
				require_once HROOT.'Class/ExlClass/PHPExcel.php';
				require_once HROOT.'Class/ExlClass/PHPExcel/IOFactory.php';
				$objExl = new PHPExcel();
				$col = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
				for($j = 0;$j < count($this->view->rowname);$j++)
				{
					$objExl->setActiveSheetIndex(0)->setCellValue($col[$j].'1', $this->view->rowname[$j]);
				}
				$i = 0;
				foreach($this->view->data as $rv)
				{
					for($j = 0;$j < count($rv);$j++)
					{
						if($rv[$j] instanceof DateTime)
						{
							$objExl->setActiveSheetIndex(0)->setCellValue($col[$j].($i+2), $rv[$j]->format('Y-m-d H:i:s.u'));
						}
						else
						{
							$objExl->setActiveSheetIndex(0)->setCellValue($col[$j].($i+2), $rv[$j]);
						}
					}
					$i++;
				}
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="log.xls"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($objExl, 'Excel5');
				$objWriter->save('php://output');
				exit;
			}
			else if(isset($_GET['outjson']) && isset($this->config['outJSON']) && $this->config['outJSON'])
			{
				echo json_encode($this->view->data);
				if($this->userStatus->outjson) $this->userStatus->loginOut();
				exit();
			}
			else
				return $data;
		}
		else
			return null;
	}
	/*
	* 加载控制页面
	*/
	function &loadController($name)
	{
		global $g_var;
		include HROOT."./class/basecontroller.php";
		if(!isset($g_var['c'][$name]))
		{
			$tmp = explode('_',$name);
			if(file_exists(HROOT."./class/".$tmp[0]."/".$name.".php"))
			{
				include HROOT."./class/".$tmp[0]."/".$name.".php";
				$g_var['c'][$name] = new $name();
			}
			else
			{
				echo "not find class file ".$name;
			}
		}
		return $g_var['c'][$name];
	}
	/*
	*	加载查询数据数据库
	*/
	function &loadmsdb($p,$v,$ip,$pass)
	{
		global $g_var;
		if(!isset($g_var['msdb']))
		{
			if(PHP_OS == 'WINNT')
				include HROOT."./class/DB/sqlsrv.php";
			else
				include HROOT."./class/DB/mssql.php";
			$g_var['msdb'] = array();
		}
		if(!isset($g_var['msdb'][$p])) $g_var['msdb'][$p] = array();

		if(!isset($g_var['msdb'][$p][$v]))
		{
			$g_var['msdb'][$p][$v] = new myMssql($ip,$pass);
		}

		return $g_var['msdb'][$p][$v];
	}
	/*
	*	获取页面加载时间
	*/
	function getRuntime()
	{
		global $g_var;
		return microtime(true)-$g_var['starttime'];
	}
	/*
	*	获取时间取get中的值--时间格式错误返回当前时间
	*/
	function getTime($d,$isnow = true,$isstr=false)
	{
		$time = 0;
		if(isset($_GET[$d]))
		{
			$time = strtotime($_GET[$d]);
		}
		else
		{
			if($isnow) $time = time();
		}
		if($isstr)
		{
			if(isset($this->config['phpdate']))
				$time = date($this->config['phpdate'],$time);
			else
				$time = date('Y-m-d',$time);
		}
		return $time;
	}
	/*
	*	初始化开始结束时间
	*/
	function initTime($defaultNow = false)
	{
		$this->view->btime = $this->getTime('btime',$defaultNow);
		$this->view->etime = $this->getTime('etime',false);

		if($this->view->btime > 0 && $this->view->etime > 0 && $this->view->etime < $this->view->btime)
		{
			$tmp = $this->view->etime;
			$this->view->etime = $this->view->btime;
			$this->view->btime = $tmp;
		}
		if($this->view->btime > 0)
		{
			if(!isset($_GET['btime']) && $defaultNow)
				$this->view->btime = date('Y-m-d',$this->view->btime);
			else if(isset($this->config['phpdate']))
				$this->view->btime = date($this->config['phpdate'],$this->view->btime);
			else
				$this->view->btime = date('Y-m-d',$this->view->btime);
		}
		else
			$this->view->btime = '';
		if($this->view->etime > 0)
		{
			if(isset($this->config['phpdate']))
				$this->view->etime = date($this->config['phpdate'],$this->view->etime);
			else
				$this->view->etime = date('Y-m-d',$this->view->etime);
		}
		else
			$this->view->etime = '';
	}
	/*
	*	更新文件
	*/
	function upfile($f,$str)
	{
		$fh = fopen($f,'w');
		if($fh)
		{
			fwrite($fh,$str);
			fclose($fh);
		}
	}
	/*
	* 获取对应主题的css文件
	*/
	function getCssfile()
	{
		global $g_var;
		if(file_exists(HROOT."css/".GAME."css.css"))
		{
			return $g_var['config']['webpath']."css/".GAME."css.css";
		}
		else
		{
			return $g_var['config']['webpath']."css/css.css";
		}
	}

	/*
	*	获取get参数 字符串
	*/
	function parseStr($n,$r = null)
	{
		if(isset($_GET[$n]))
		{
			return str_replace("'","''",$_GET[$n]);
		}
		if(isset($_POST[$n]))
		{
			return str_replace("'","''",$_POST[$n]);
		}
		else
		{
			return $r;
		}
	}

	/*
	* 获取变量
	*/
	function __get($n)
	{	
		if(isset($this->_pro[$n]))
			return $this->_pro[$n];
		else
		{
			if($n == 'userStatus')
			{
				global $g_var;
				session_set_cookie_params(0,$g_var['config']['webpath']);
				session_start();
				include HROOT."./class/userStatus.php";
				return $this->_pro['userStatus'] = new userStatus();
			}
			else if($n == 'gamelogdb')
			{
				include HROOT."config/dblist.php";//include HROOT."config/dblist_".GAME.".php";
				return $this->_pro['gamelogdb'] = $g_config['db'];
			}
			else if($n == 'arealist') //所有平台列表
			{
				return $this->_pro['arealist'] = $this->userStatus->arealist;
			}
			else if($n == 'curarea') //可查看的当前平台
			{
				if(isset($_GET['pt']) && ($_GET['pt'] == '所有' || in_array($_GET['pt'],$this->userStatus->arealist)))
				{
					$_SESSION["area"] = $_GET['pt'];
					return $this->_pro['curarea'] = $_GET['pt'];
				}
				else if(isset($_SESSION["area"]) && ($_SESSION["area"] == '所有' || in_array($_SESSION["area"],$this->userStatus->arealist)))
					return $this->_pro['curarea'] = $_SESSION["area"];
				else
					return $this->_pro['curarea'] = '所有';
			}
			else if($n == 'viewarea') //当前查看的平台
			{
				if($this->curarea == '所有')
					return $this->_pro['viewarea'] = $this->userStatus->arealist;
				else
					return $this->_pro['viewarea'] = array($this->curarea);
			}
			else if($n == 'viewonearea') //可查看的单的平台
			{
				$this->_pro['curarea'] = $this->viewarea[0];
				return $this->_pro['viewonearea'] = $this->viewarea[0];
			}
			else if($n == 'view')
			{
				include HROOT."class/view.php";
				return $this->_pro['view'] = new view();
			}
			else
				return null;
		}
	}
}
?>