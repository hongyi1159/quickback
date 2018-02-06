<?php
define('ACTION','gamerun');
define('ISLOGIN',true);
include dirname(__FILE__)."/../class/hong_core.php";
$app = hong_core::instance();
$app->getPageData();
$app->view->colnum = 10;
include HROOT."include/vheader.php";
?>
<div style="float:left;margin-left:10px;" id="app">
	<div v-if="gn" style="text-align:left;margin-left:20px;line-height:26px;">
		任务明细<br/>
		所属游戏: {{gn[7]}}({{gne.gmname}})<br/>
		<div v-if="gn[7]==0" style="border:solid 1px #333;padding:5px;">
			<button v-on:click="gmadd()">添加新游戏</button><br />
			双击游戏行选择游戏<br/>
			可选择游戏: <br/>
			游戏ID 游戏名字 <br/>
			<div v-for="(op,ind) in gmlist" v-on:change="gmchange(ind)" v-on:dblclick="gmsel(op[0])">{{op[0]}} <input v-model="op[1]" /> <button v-if="op[2]" v-on:click="gmsv(ind)">保存</button> <a v-on:click="gmrm(ind)">X</a></div>
		</div>
		任务组ID: {{gn[0]}}<br/>
		任务名字: <input v-model="gn[1]" /><br/>
		注册天数: <input v-model="gn[3]" /> 0新增用户 1-100注册天数 101-200最近N-100天内活跃用户 200-250最近N-200天内注册用户 255按活跃时间循环用户 254当天没有活跃有第三方的用户<br/>
		绑定mac: <input v-model="gn[4]" /> 如 00:50:56:a1:04:20<br/>
		设 备 表: <input v-model="gn[5]" /><br/>
		扩展脚本: <input v-model="gn[6]" /> 用,分割脚本 现在支持脚本 pay获取qq卡信息 paymac指定mac配置的支付信息 phone使用手机号 phoneOther使用百万码手机号 phoneOther2使用E码手机号 runtime运行时间限制 params对指定功能传参数<br/>
		功能组ID: {{gn[2]}} <select id="funlid" v-on:change="funget()"><option v-for="f in gmfun" v-bind:value="f[0]">{{ f[0] }}</option></select> <button v-on:click="funcp()">复制功能组</button><br/>
		<button v-on:click="gnsave()">保存任务</button><br/>
		<hr/>
		功能列表: <button v-on:click="funadd()">添加</button><br/>
		<div style="margin-left:20px;">功能ID 排序号 执行概率</div>
		<div style="margin-left:20px;" v-for="(fu,ind) in gnfunl" v-on:change="funchange(ind)">
			<input style='width:30px;' v-model="fu[0]" /> <input style='width:30px;' v-model="fu[1]" /> <input style='width:30px;' v-model="fu[2]" /><button v-if="fu[3]" v-on:click="funsv(ind)">保存</button> <a v-on:click="funrm(ind)">X</a><br/>
		</div>
		<div style="margin-left:20px;">可用功能 <button v-on:click="fadd()">添加功能</button><br/>
			<div style="margin-left:20px;">功能ID 功能名字 功能脚本 等待类型 预计时间(秒)</div>
			<div style="margin-left:20px;" v-for="(f,ind) in gmfunl" v-on:change="fchange(ind)">
				<input style='width:30px;' v-model="f[0]" /> <input style='width:80px;' v-model="f[1]" /> <input style='width:150px;' v-model="f[2]" /> <input style='width:30px;' v-model="f[3]" /> <input style='width:30px;' v-model="f[4]" /> <button v-if="f[5]" v-on:click="fsv(ind)">保存</button> <a v-on:click="frm(ind)">X</a><br/>
			</div>
			<fieldset style="width:960px;margin-left:20px;">
				<legend>等待类型支持</legend>
				<?php foreach($app->view->data as $v) echo '<a>',$v[0],'</a>:',$v[1],' '; ?>
			  </fieldset>
		</div>
		<hr/>
		每日配置: <button v-on:click="gndayadd()">添加</button> <br/>
		<div style="margin-left:20px;">日期 需要用户 执行时间</div>
		<div style="margin-left:20px;" v-for="(dy,ind) in gnday" v-on:change="gndaychange(ind)">
			<datepicker language="ch" v-model="dy[0]" @input="gndaychange(ind)" class="picker"></datepicker> <input style='width:30px;' v-model="dy[1]" /> <input style='width:30px;' v-model="dy[2]" /> <button v-if="dy[3]" v-on:click="gndaysv(ind)">保存</button> <span v-on:click="gndayrm(ind)">X</span><br/>
		</div>
		<div style="color:red;">任务设置完以后要配置一下中控的/config/mactask.json文件</div>
	</div>
	<hr/>
	<br/><button v-on:click="gpedit()">添加游戏任务</button>
	<table class="dataTb">
	<tr class="title_5"><th>任务组ID</th><th>名字</th><th>功能组ID</th><th>注册天数</th><th>绑定mac地址</th><th>设备表</th><th>扩展脚本</th><th>操作</th></tr>
	<template v-for="(gn,ind) in gnlist">
      <tr v-on:click="gpedit(gn)"><td>{{ gn[0] }}</td><td>{{ gn[1] }}</td><td>{{ gn[2] }}</td><td>{{ gn[3] }}</td><td>{{ gn[4] }}</td><td>{{ gn[5] }}</td><td>{{ gn[6] }}</td><td><button v-on:click="gnrm(ind)">删除</button></td></tr>
    </template>
	</table>
</div>
<?php
include HROOT."include/vfooter.php"; 