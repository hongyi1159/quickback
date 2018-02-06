# quickback
快速的的后台框架

里面用到两种数据库的，用户名密码权限配置用的sqlite3数据库

后台数据用的是sqlserver数据库

用户名密码存在/data/mydb.php中
权限配置在/data/config_?.php中 因为要支持不同的平台所以会有多个配置的文件 
这里权限配置跟用户名密码分开是方便添加功能直接覆盖权限文件就可以了

最简单的写一个页面
第一步先要添加权限 开启网站访问访问 /sysc/powerlist.php 就可以设置权限了
权限类名 就是文件名也是类名 如 t_test
父权限 这个是用来显示在那个标题的下面的
权限方法 就是访问的具体功能 如 add

如果config/config_global.php中配置的 $g_config['gamelist'] = array('test');

更目录下创建一个test文件夹
添加文件add.php内容如下
<?php
define('ACTION','add');
define('ISLOGIN',true);
include dirname(__FILE__)."/../class/hong_core.php";
$app = hong_core::instance();
$app->getPageData();
include HROOT."include/nheader.php";
include HROOT."include/nfooter.php"; 

再在class目录下添加test文件夹
添加文件t_test内容如下
<?php
/**
 * @copyright  Copyright (c) 2016
 * @since      File available since Release 0.0.0
 * @version    Release: 0.0.1
 * @author     hong <hongyi1159@126.com>
 */

class t_test extends baseController
{
	function add()
	{
		//显示的表格标题
		$this->rowname = array('功能编号', '功能名字', '游戏编号', '游戏名称', '脚本文件', '等待类型', '预计时间', '操作');
		$this->getdbdata("SELECT * from gamelist");
	}
}

这样一个简单的功能就好了