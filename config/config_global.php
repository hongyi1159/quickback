<?php
//---------------------- 配置当前游戏 -------------------------------//
$g_config['gamelist'] = array('view');

// ----------------------------  CONFIG FileDB  ----------------------------- //
$g_config['sqlitedir'] = "data/";

// ----------------------------  CONFIG others  ----------------------------- //
$g_config['allowproxy'] = 0;
$g_config['debug'] = 1; //0不显示1直接显示错误2错误显示在文件里
$g_config['webpath'] = '/';

//------------------------日期格式--------------------------------//
$g_config['phpdate'] = 'Y-m-d H:i:s'; //'Y-m-d H:i:s'
$g_config['jsdate'] = 'yy-mm-dd 00:00:00';//'yy-mm-dd 00:00:00'

//redis配置
$g_config['redisIP'] = '192.168.18.220';
$g_config['redisPort'] = '6379';

//-------------------------等待类型--------------------------------//
$g_config['waitarr'] = array('0'=>'未等待', '-1'=>'等激活手机号', '-2'=>'等接收短信', '-3'=>'等验证图片', '-4'=>'等待收款微信账号', '-5'=>'等待收款支付包账号', '-6'=>'微信等待好友添加', '-7'=>'支付手机号激活', '-8'=>'注册百度账号', '-100'=>'支付宝号激活', '-101'=>'注册qq发送短信', '-102'=>'主号微信等待下一次转账', '-103'=>'主号支付宝等待下一次转账', '-104'=>'主号微信等待加好友', '-105'=>'等待加载要添加的微信好友', '-106'=>'等待QQ验证码图片识别', '-107'=>'等待淘宝验证码图片识别', '-200'=>'qq点卡支付');

