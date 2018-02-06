<?php
define('ACTION','center');
define('ISLOGIN',true);
include dirname(__FILE__)."/../class/hong_core.php";
$app = hong_core::instance();
$app->getPageData();
$app->view->filterBefore = "请输入命令: <input id='msg' value='' /> <input type='button' value='执行' onclick=\"window.open('http://192.168.0.201:94/msgrecv?s=99&msg='+document.getElementById('msg').value);\" /><br/>
360配置更新：<input id='pz' value='' /> <input type='button' value='执行' onclick=\"window.open('http://192.168.0.201:94/msgrecv?s=99&msg=sendclear cmdjs\\\\360\\\\'+document.getElementById('pz').value+'.json');\" /><br/>
reload \config\vpn.json 重新加载中控文件(中控上的文件要先更新)<br/>
sendclear cmd/global/openvpn  更新脚本<br/>
client /funs/5.js 更新客户端js<br/>
exec cmd/global/screanshot [mac地址] 执行客户端shell<br/>
show client web 显示客户端的信息<br/>
show taskdata web 显示任务信息";
include HROOT."include/nheader.php";
include HROOT."include/nfooter.php"; 
?>