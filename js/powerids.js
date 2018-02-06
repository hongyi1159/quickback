function addoption(fromid,toid,inid)
{
	var plist = Array();
	if($('#'+inid).get(0).value.length > 0) plist = $('#'+inid).get(0).value.split(',');
	var fp = $('#'+fromid).get(0).options;
	for(var i=0;i<fp.length;i++)
	{
		if(fp[i].selected == true)
		{
			var j=0
			for(;j<plist.length;j++)
				if(plist[j] == fp[i].value) break;
			if(j == plist.length)
			{
				$('#'+toid).get(0).options.add(new Option(fp[i].text,fp[i].value));
				plist.push(fp[i].value);
			}
		}
	}
	$('#'+inid).get(0).value = plist.join(',');
}

function deloption(fromid,toid,inid)
{
	var plist = Array();
	if($('#'+inid).get(0).value.length > 0) plist = $('#'+inid).get(0).value.split(',');
	var fp = $('#'+fromid).get(0).options;
	for(var i=0;i<fp.length;i++)
	{
		if(fp[i].selected == true)
		{
			var j=0
			var plist2 = [] 
			for(;j<plist.length;j++)
			{
				if(plist[j] != fp[i].value)
				{
					plist2.push(plist[j]);
				}
			}
			plist = plist2;
		}
	}
	$('#'+inid).get(0).value = plist.join(',');
	fp.length =0;
	if(inid == 'powerids')
	{
		var tp = $('#'+toid).get(0).options;
		for(var i=0;i<plist.length;i++)
		{
			for(var j=0;j<tp.length;j++)
			{
				if(plist[i] == tp[j].value)
				{
					fp.add(new Option(tp[j].text,plist[i]));
					break;
				}
			}
		}
	}
	else
	{
		for(var i=0;i<plist.length;i++)
			fp.add(new Option(plist[i],plist[i]));
	}
}

$(document).ready(function(){
	var plist = $('#powerids').get(0).value.split(',');
	var p = $('#pids2').get(0).options;
	var tp = $('#pids1').get(0).options;
	for(var i=0;i<plist.length;i++)
	{
		for(var j=0;j<tp.length;j++)
		{
			if(plist[i] == tp[j].value)
			{
				p.add(new Option(tp[j].text,plist[i]));
				break;
			}
		}
	}

	var alist = $('#areas').get(0).value.split(',');
	var p = $('#area2').get(0).options;
	for(var i=0;i<alist.length;i++)
		p.add(new Option(alist[i],alist[i]));
});