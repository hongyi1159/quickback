$(document).ready(
	function(){
		$("#select_area").get(0).innerHTML = pt;
		$("#select_area").autocomplete({
			source: alist,
			minLength: 0,
			select:function(event, ui){location.href = "?pt="+ui.item.value;}
		})
		$("#select_area").click(function(){
			$("#select_area").autocomplete("search","");
		});

		$.datepicker.setDefaults($.datepicker.regional['zh-CN']);
		if($("#btime").get(0))
		{
			if(typeof(jsdate) == "undefined")
				$("#btime").datepicker({dateFormat:'yy-mm-dd' });
			else
				$("#btime").datepicker({dateFormat:jsdate });
		}
		if($("#etime").get(0))
		{
			if(typeof(jsdate) == "undefined")
				$("#etime").datepicker({dateFormat:'yy-mm-dd' });
			else
				$("#etime").datepicker({dateFormat:jsdate });
		}

		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		$( "#ser_dialog" ).dialog( {
			autoOpen: false,
			height: 300,
			width: 450,
			modal: true,
			buttons :{"确认":function(){
				$('#ser').get(0).value = "";
				$('#ser_dialog>span>input').each(function(){
					if($(this).get(0).checked == true)
					{
						if($('#ser').get(0).value.length > 0)
						{
							$('#ser').get(0).value += ","+$(this).get(0).value;
						}
						else
						{
							$('#ser').get(0).value = $(this).get(0).value;
						}
					}
				});
				$( this ).dialog( "close" );
				}
			}
		} );

		//菜单显示
		var ufile = location.href;
		if(ufile.indexOf("?") > 0)
		{
			ufile = ufile.substr(0, ufile.indexOf("?"));
		}
		var alist = $(".leftTb a");
		for(var i=0;i<alist.length;i++)
		{
			if(alist[i].href == ufile)
			{
				alist[i].style.fontWeight = 'bold';
				alist[i].parentNode.style.display = 'block';
				break;
			}
		}
	}
);

//表格排序
var aAsc = [];
function sortTable(nr) 
{
	aAsc[nr] = aAsc[nr]=='asc'?'desc':'asc';
	$('#sortTb>tbody>tr[align="center"]').tsort('td:eq('+nr+')',{order:aAsc[nr],attr:'abbr'});
}

//运营操作类型变化
function itemtype(m,dlist,htmlid)
{
	var itype = $(htmlid).get(0);
	itype.options.length = 1;
	if(dlist[m.value])
	{
		for(var i = 0;i<dlist[m.value].length;i++)
		{
			if($.isArray(dlist[m.value][i]))
				itype.options.add(new Option(dlist[m.value][i][0]));
			else
				itype.options.add(new Option(dlist[m.value][i]));
		}
	}
}

//菜单显示隐藏
function menushow(mna)
{
	if($(mna).css("display") == "none")
	{
		$(mna).css("display", "block");
	}
	else
	{
		$(mna).css("display", "none");
	}
}