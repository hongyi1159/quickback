var app = new Vue({
	el: '#app',
	data: {
		gn:false,
		gnfunl:[],
		gnday:[],
		gne:{},
		gmfunl:[], //游戏功能列表
		gmlist:[],
		gmfun:[], //游戏功能组列表
		gnlist:[]
	},
	components: { datepicker },
	methods:{
		gpedit: function(gn){
			app.gmfun = [];
			app.gnfunl = [];
			if(!gn)
			{
				gn = [app.gnlist[0][0]+1,'',0,0,'','DevList01','[[""]]',0];
				gn[2] = gn[0]*100;
			}
			app.gn = gn;
			app.gne.gmname = '';
			for(let i=0;i<app.gmlist.length;i++)
			{
				if(gn[7] == app.gmlist[i][0])
				{
					app.gne.gmname = app.gmlist[i][1];
					break;
				}
			}
			//获取任务功能组中功能列表
			app.funget();
			//获取任务每日执行
			$.ajax({
				url:"/view/aj.php?act=gr_fgday&gpid="+gn[0], 
				dataType:"json",
				success:function(data){
					app.gnday = data;
				}
			});
			//获取游戏功能
			app.gmget();
			//获取游戏功能组
			app.gnfunlget();
		},
		gnsave: function(){
			$.ajax({
				url:"/view/aj.php?act=gr_sgn&gpid="+app.gn[0]+"&names="+app.gn[1]+"&funlid="+app.gn[2]+"&isnew="+app.gn[3]+"&mackey="+app.gn[4]+"&devtb="+app.gn[5]+"&edata="+app.gn[6], 
				success:function(data){
					alert('保存成功');
				}
			});	
		},
		gnrm: function(i)
		{
			$.ajax({
				url:"/view/aj.php?act=gr_dgn&gpid="+app.gnlist[i][0], 
				success:function(data){
					app.gnlist.splice(i,1);
				}
			});	
		},
		gnfunlget: function(){
			if(app.gn[7] > 0)
			{
				$.ajax({
					url:"/view/aj.php?act=gr_fgfunl&gid="+app.gn[7], 
					dataType:"json",
					success:function(data){
						app.gmfun = data;
						app.gmfun.push([app.gn[7]*1000+app.gmfun[app.gmfun.length-1][0]%100+1]);
					}
				});					
			}
			else
			{
				app.gmfun = [];
			}
		},
		//任务功能
		funchange: function(i){ //功能组修改了显示保存按钮
			if(app.gnfunl[i][3] == 1) return;
			app.gnfunl[i][3] = 1;
			Vue.set(app.gnfunl, i, app.gnfunl[i]);
		},
		funrm: function(i){ //功能组中功能删除
			$.ajax({
				url:"/view/aj.php?act=gr_dfg&funlid="+app.gn[2]+"&sort="+app.gnfunl[i][1], 
				success:function(data){
					app.gnfunl.splice(i,1);
				}
			});	
		},
		funadd: function(){ //添加功能组
			app.gnfunl.push([app.gn[7],app.gnfunl.length+1,100,1]);
		},
		funsv: function(i){ //保存或修改功能组
			app.gnfunl[i].length = 3;
			$.ajax({
				url:"/view/aj.php?act=gr_sfg&funlid="+app.gn[2]+"&fid="+app.gnfunl[i][0]+"&sort="+app.gnfunl[i][1]+"&prob="+app.gnfunl[i][2], 
				success:function(data){
					Vue.set(app.gnfunl, i, app.gnfunl[i]);
				}
			});
		},
		funcp: function(){ //复制功能组
			$.ajax({
				url:"/view/aj.php?act=gr_cfg&funlid="+app.gn[2], 
				success:function(data){
					alert('复制成功');
				}
			});
		},
		funget: function(){
			let sel = document.getElementById("funlid");
			if(sel && sel.value != app.gn[2] && app.gmfun.length > 0) app.gn[2] = sel.value;
			if(!app.gn[2]) return;
			$.ajax({
				url:"/view/aj.php?act=gr_fglist&funlid="+app.gn[2], 
				dataType:"json",
				success:function(data){
					app.gnfunl = data;
				}
			});
		},
		//游戏功能
		fchange: function(i){
			if(app.gmfunl[i][5] == 1) return;
			app.gmfunl[i][5] = 1;
			Vue.set(app.gmfunl, i, app.gmfunl[i]);
		},
		frm: function(i){
			$.ajax({
				url:"/view/aj.php?act=gr_dfun&fid="+app.gmfunl[i][0], 
				success:function(data){
					app.gmfunl.splice(i,1)
				}
			});
		},
		fadd: function(){
			if(app.gmfunl.length > 0){
				let fst = app.gmfunl[0][2].substr(0, app.gmfunl[0][2].lastIndexOf("/")+1);
				app.gmfunl.push([app.gn[7]*100+(app.gmfunl[app.gmfunl.length-1][0]%100)+1,'',fst,0,30]);
			} else
				app.gmfunl.push([app.gn[7]*100,'','/cmd/',0,30]);
		},
		fsv: function(i){
			app.gmfunl[i].length = 5;
			$.ajax({
				url:"/view/aj.php?act=gr_sfun&fid="+app.gmfunl[i][0]+"&gid="+app.gn[7]+"&names="+app.gmfunl[i][1]+"&url="+app.gmfunl[i][2]+"&waittp="+app.gmfunl[i][3]+"&xtime="+app.gmfunl[i][4], 
				success:function(data){
					Vue.set(app.gmfunl, i, app.gmfunl[i]);
				}
			});
		},
		//任务日数据
		gndaychange: function(i){
			if(app.gnday[i][3] == 1) return;
			app.gnday[i][3] = 1;
			Vue.set(app.gnday, i, app.gnday[i]);
		},
		gndayrm: function(i){
			$.ajax({
				url:"/view/aj.php?act=gr_dfgday&gpid="+app.gn[0]+"&dt="+app.gnday[i][0], 
				success:function(data){
					app.gnday.splice(i,1);
				}
			});
		},
		gndayadd: function(){
			app.gnday.push(['2017-00-00',0,1]);
		},
		gndaysv: function(i){
			app.gnday[i].length = 3;
			$.ajax({
				url:"/view/aj.php?act=gr_sfgday&gpid="+app.gn[0]+"&dt="+app.gnday[i][0]+"&rnum="+app.gnday[i][1]+"&btype="+app.gnday[i][2], 
				success:function(data){
					Vue.set(app.gnday, i, app.gnday[i]);
				}
			});			
		},
		//游戏数据
		gmchange: function(i){
			if(app.gmlist[i][2] == 1) return;
			app.gmlist[i][2] = 1;
			Vue.set(app.gmlist, i, app.gmlist[i]);
		},
		gmrm: function(i){
			if(app.gmlist[i][0] == 0)
			{
				alert('特殊用途不能删除');
				return;
			}
			$.ajax({
				url:"/view/aj.php?act=gr_dgame&gid="+app.gmlist[i][0], 
				success:function(data){
					app.gmlist.splice(i,1);
				}
			});
		},
		gmadd: function(){
			app.gmlist.unshift([app.gmlist[0][0]+1,'']);
		},
		gmsv: function(i){
			app.gmlist[i].length = 2;
			$.ajax({
				url:"/view/aj.php?act=gr_sgame&gid="+app.gmlist[i][0]+"&gname="+app.gmlist[i][1], 
				success:function(data){
					Vue.set(app.gmlist, i, app.gmlist[i]);
				}
			});	
		},
		gmsel: function(gid){
			Vue.set(app.gn, 7, gid);
			app.gne.gmname = '';
			for(let i=0;i<app.gmlist.length;i++)
			{
				if(gid == app.gmlist[i][0])
				{
					app.gne.gmname = app.gmlist[i][1];
					break;
				}
			}
			app.gmget();
			app.gnfunlget();
		},
		gmget: function(){
			if(app.gn[7] > 0)
			{
				$.ajax({
					url:"/view/aj.php?act=gr_funlist&gid="+app.gn[7], 
					dataType:"json",
					success:function(data){
						app.gmfunl = data;
					}
				});					
			}
			else
			{
				app.gmfunl = [];
			}
		},
		dtchg: function(ev){
			ev.target.onFocus();
			console.log(ev.target.value);
		}
	},
	updated: function(){
		//$(".cbt").datepicker({dateFormat:'yy-mm-dd' });
	}
})

$(document).ready(function(){
	//获取任务列表
	$.ajax({
		url:"/view/aj.php?act=gr_gnlist", 
		dataType:"json",
		success:function(data){
			app.gnlist = data;
		}
	});
	//获取游戏列表
	$.ajax({
		url:"/view/aj.php?act=gr_gmlist", 
		dataType:"json",
		success:function(data){
			app.gmlist = data;
		}
	});
});

