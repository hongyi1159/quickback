var app = new Vue({
	el: '#app',
	data: {
		x:1,
		y:1,
		z:0,
		iccid:"",
		phone:""
	},
	methods:{
		save: function(gn){
			if(app.iccid.length > 10 && app.phone.length != 11)
			{
				alert("iccid或手机号码错误");
				return;
			}
			$.ajax({
				url:"/view/aj.php?act=phone_save&iccid="+app.iccid+"&phone="+app.phone+"&x="+app.x+"&y="+app.y, 
				success:function(data){
					alert('保存成功');
					app.y++;
					if(app.y > 32) {
						app.y = 1;
						app.x++;
					}
					app.phone = "";
					app.iccid = "";
					app.ph();
				}
			});
		},
		ph: function(){
			$.ajax({
				url:"http://192.168.0.128:8080/api/phone/number?x="+app.x+"&y="+app.y+"&m=40", 
				success:function(data){
					app.iccid = data.substr(data.indexOf("ICCID:")+6);
				}
			});	
		},
		setz: function(){ //设置当前卡批次
			$.ajax({
				url:"http://192.168.0.128:8080/api/phone/load?z="+app.z, 
				success:function(data){
					alert('卡池中批次设置成功');
				}
			});
			$.ajax({
				url:"http://192.168.0.201:94/msgrecv?s=97&z="+app.z, 
				success:function(data){
					alert('中控中批次设置成功');
				}
			});
		}
	},
	updated: function(){
		//$(".cbt").datepicker({dateFormat:'yy-mm-dd' });
	}
})

$(document).ready(function(){

});

