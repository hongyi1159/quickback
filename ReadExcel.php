<?php
require_once 'Class/ExlClass/PHPExcel.php';
require_once 'Class/ExlClass/PHPExcel/IOFactory.php';
header("Content-Type:text/html; charset=utf-8");

$tb = array(
	"GameMatchInfo"=>array(
		"tb"=>"[QPTreasureDB].[dbo].[GameMatchInfo]",
		"col"=>34,
		"colstr"=>array(8=>true),
		"delwh"=>""
	),
	"GameMatchCellScore"=>array(
		"tb"=>"[QPTreasureDB].[dbo].[GameMatchCellScore]",
		"col"=>5,
		"colstr"=>array(),
		"delwh"=>""
	),
	"GameMatchPrize"=>array(
		"tb"=>"[QPTreasureDB].[dbo].[GameMatchPrize]",
		"col"=>6,
		"colstr"=>array(),
		"delwh"=>""
	),
	"GameMatchTime"=>array(
		"tb"=>"[QPTreasureDB].[dbo].[GameMatchTime]",
		"col"=>5,
		"colstr"=>array(),
		"delwh"=>""
	)
);
$tb2 = array(
	"GameExchangeGood"=>array(
		"tb"=>"[QPGameUserDB].[dbo].[GameExchangeGood]",
		"col"=>11,
		"colstr"=>array(1=>true,6=>true,7=>true),
		"delwh"=>""
	),
	"GameExchangeType"=>array(
		"tb"=>"[QPGameUserDB].[dbo].[GameExchangeType]",
		"col"=>4,
		"colstr"=>array(1=>true),
		"delwh"=>""
	),
	"GameExchangeChannelID"=>array(
		"tb"=>"[QPServerInfoDB].[dbo].[GameExchangeChannelID]",
		"col"=>2,
		"colstr"=>array(),
		"delwh"=>""
	)
);
$tb3 = array(
	"AndroidRoomPond"=>array(
		"tb"=>"[GameDB].[dbo].[AndroidRoomPond]",
		"col"=>6,
		"colstr"=>array(),
		"delwh"=>""
	)
);
$tb4 = array(
	"GameShopCate"=>array(
		"tb"=>"[QPGameUserDB].[dbo].[GameShopCate]",
		"col"=>15,
		"colstr"=>array(1=>true,2=>true,10=>true,11=>true),
		"delwh"=>""
	),
	"GameShopCatePay"=>array(
		"tb"=>"[QPGameUserDB].[dbo].[GameShopCatePay]",
		"col"=>3,
		"colstr"=>array(),
		"delwh"=>""
	),
	"GameShopCateGet"=>array(
		"tb"=>"[QPServerInfoDB].[dbo].[GameShopCateGet]",
		"col"=>7,
		"colstr"=>array(5=>true,6=>true),
		"delwh"=>""
	)
);
$tb5 = array(
	"GameRoomInfo"=>array(
		"tb"=>"[QPServerInfoDB].[dbo].[GameRoomInfo]",
		"col"=>33,
		"colstr"=>array(1=>true,2=>true,10=>true,11=>true,12=>true,13=>true,22=>true,23=>true,24=>true),
		"delwh"=>""
	)
);
//$tb6 = array(
//	"GameTask"=>array(
//		"tb"=>"[QPGameUserDB].[dbo].[GameTask]",
//		"col"=>16,
//		"colstr"=>array(3=>true,4=>true,12=>true,13=>true,14=>true)
//	)
//);
//$tb7 = array(
//	"GameTaskChannelID"=>array(
//		"tb"=>"[QPServerInfoDB].[dbo].[GameTaskChannelID]",
//		"col"=>2,
//		"colstr"=>array()
//	)
//);

$tb8 = array(
	"GameTask"=>array(
		"tb"=>"[QPServerInfoDB].[dbo].[GameTask]",
		"col"=>18,
		"colstr"=>array(6=>true,7=>true,14=>true,15=>true,16=>true),
		"delwh"=>""
	),
	"GameTaskChannelID"=>array(
		"tb"=>"[QPServerInfoDB].[dbo].[GameTaskChannelID]",
		"col"=>2,
		"colstr"=>array(),
		"delwh"=>""
	),
	"GameTaskPrize"=>array(
		"tb"=>"[QPServerInfoDB].[dbo].[GameTaskPrize]",
		"col"=>6,
		"colstr"=>array(),
		"delwh"=>""
	),
	"GameTaskRoom"=>array(
		"tb"=>"[QPServerInfoDB].[dbo].[GameTaskRoom]",
		"col"=>3,
		"colstr"=>array(),
		"delwh"=>""
	),
	"GameTaskRequest"=>array(
		"tb"=>"[QPServerInfoDB].[dbo].[GameTaskRequest]",
		"col"=>2,
		"colstr"=>array(1=>true),
		"delwh"=>""
	),
	"GameTaskType"=>array(
		"tb"=>"[QPServerInfoDB].[dbo].[GameTaskType]",
		"col"=>4,
		"colstr"=>array(3=>true),
		"delwh"=>""
	)
);

$tb9 = array(
	"GameServer"=>array(
		"tb"=>"[QPGameUserDB].[dbo].[GameServer]",
		"col"=>3,
		"colstr"=>array(),
		"delwh"=>""
	)
);

$tb10 = array(
	"GameTask"=>array(
		"tb"=>"[QPServerInfoDB].[dbo].[GameTask]",
		"col"=>18,
		"colstr"=>array(6=>true,7=>true,14=>true,15=>true,16=>true),
		"delwh"=>" where TaskID >= 7000 and TaskID < 8000"
	),
	"GameTaskChannelID"=>array(
		"tb"=>"[QPServerInfoDB].[dbo].[GameTaskChannelID]",
		"col"=>2,
		"colstr"=>array(),
		"delwh"=>" where TaskID >= 7000 and TaskID < 8000"
	),
	"GameTaskPrize"=>array(
		"tb"=>"[QPServerInfoDB].[dbo].[GameTaskPrize]",
		"col"=>6,
		"colstr"=>array(),
		"delwh"=>" where TaskID >= 7000 and TaskID < 8000"
	),
	"GameTaskRoom"=>array(
		"tb"=>"[QPServerInfoDB].[dbo].[GameTaskRoom]",
		"col"=>3,
		"colstr"=>array(),
		"delwh"=>" where TaskID >= 7000 and TaskID < 8000"
	)
);

$tb11 = array(
	"ConfigLanguage"=>array(
		"tb"=>"[QPServerInfoDB].[dbo].[ConfigLanguage]",
		"col"=>3,
		"colstr"=>array(0=>true,2=>true),
		"delwh"=>""
	)
);

$tb12 = array(
	"GameTask"=>array(
		"tb"=>"[QPServerInfoDB].[dbo].[GameTask]",
		"col"=>18,
		"colstr"=>array(6=>true,7=>true,14=>true,15=>true,16=>true),
		"delwh"=>" where TaskID >= 20000 and TaskID < 23000"
	),
	"GameTaskChannelID"=>array(
		"tb"=>"[QPServerInfoDB].[dbo].[GameTaskChannelID]",
		"col"=>2,
		"colstr"=>array(),
		"delwh"=>" where TaskID >= 20000 and TaskID < 23000"
	),
	"GameTaskPrize"=>array(
		"tb"=>"[QPServerInfoDB].[dbo].[GameTaskPrize]",
		"col"=>6,
		"colstr"=>array(),
		"delwh"=>" where TaskID >= 20000 and TaskID < 23000"
	),
	"GameTaskRoom"=>array(
		"tb"=>"[QPServerInfoDB].[dbo].[GameTaskRoom]",
		"col"=>3,
		"colstr"=>array(),
		"delwh"=>" where TaskID >= 20000 and TaskID < 23000"
	)
);

$tb13 = array(
	"db_Good"=>array(
		"tb"=>"QPGameUserDB.dbo.db_Good",
		"col"=>9,
		"colstr"=>array(1=>true),
		"delwh"=>""
	)
);

$dir = getcwd();
OutputStr($dir.'\比赛信息.xls', $tb, "db/Match.sql");
OutputStr($dir.'\兑换物品.xls', $tb2, "db/Good.sql");
OutputStr($dir.'\房间水库.xls', $tb3, "db/AndroidRoomPond.sql");
OutputStr($dir.'\道具.xls', $tb4, "db/ShopGood.sql");
OutputStr($dir.'\fj.xls', $tb5, "db/Room.sql");
//OutputStr($dir.'\任务.xls', $tb6, "db/Task.sql");
//OutputStr($dir.'\任务对应渠道.xls', $tb7, "db/GameTaskChannelID.sql");
OutputStr($dir.'\新任务.xls', $tb8, "db/Task.sql");
OutputStr($dir.'\GameServer.xls', $tb9, "db/GameServer.sql");
OutputStr($dir.'\牛牛任务.xls', $tb10, "db/nn_Task.sql");
OutputStr($dir.'\语言配置.xls', $tb11, "db/ConfigLanguage.sql");
OutputStr($dir.'\德州任务.xls', $tb12, "db/dz_Task.sql");
OutputStr($dir.'\夺宝物品.xls', $tb13, "db/db_Good.sql");

function OutputStr($exlfile, $config, $fl)
{
	if(!file_exists($exlfile))
	{
		echo "not have file ", $exlfile, "\n";
		return;
	}
	echo "deal file ", $exlfile, "\n";
	$inputFileType = PHPExcel_IOFactory::identify($exlfile);
	$objReader = PHPExcel_IOFactory::createReader($inputFileType);
	$excel = $objReader->load($exlfile);

	$col = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM');
	$sql = "";
	foreach($config as $k=>$v)
	{
		$ws = $excel->getSheetByName($k);
		$sql .= "delete ".$v["tb"].$v["delwh"]."\n";
		$rownum = count($ws->getRowDimensions());
		for($r=2;$r<=$rownum;$r++)
		{
			if($ws->getCell($col[0].$r)->getValue() === null) break;

			$sql .= "insert into ".$v["tb"]." values(";
			for($i=0;$i<$v['col'];$i++)
			{
				$value = $ws->getCell($col[$i].$r)->getValue();
				if($i == 0)
				{
					if(isset($v['colstr'][$i]))
					{
						$sql .= "N'".$value."'";
					}
					else
					{
						$sql .= $value;
					}
				}
				else if(isset($v['colstr'][$i]))
				{
					if($value)
						$sql .= ",N'".$value."'";
					else
						$sql .= ",NULL";
				}
				else
				{
					$sql .= ",".($value === null?'NULL':$value);
				}
			}
			$sql .= ")\n";
		}
		$sql .= "\n";
	}
	$fp = fopen($fl, "w");
	if($fp)
	{
		fwrite($fp, $sql); 
	}
}




