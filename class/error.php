<?php
/*
	错误处理
*/

/*
*	初始始化错误处理
*/
function errInit()
{
	error_reporting(E_ALL);
	set_error_handler('myerrhander');
}

function myerrhander($errno, $errstr, $errfile, $errline)
{
	$app = hong_core::instance();
	file_put_contents(HROOT.$app->config['sqlitedir'].'errlog.txt',date('Y-m-d H:i:s')."\t".$errno."\t".$errfile."\t".$errline."\t".$errstr."\n", FILE_APPEND|LOCK_EX);
}

errInit();