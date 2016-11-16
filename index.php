<?php

// Debug mode
ini_set("display_errors", 1);
error_reporting(E_ALL);

include_once __DIR__ . '/api.php';

/**
 * Config
 */
$stockList = array(
	'2891' => '中信',
	'6202' => '盛群',
	'2890' => '永豐金',
	'6154' => '順發',
	'9917' => '中保',
	'2376' => '技嘉',
	'3338' => '泰碩',
	'9945' => '潤泰新',
	'6271' => '同欣電',
	'2325' => '矽品',
	'2379' => '瑞昱',
	'2377' => '微星',
	'2501' => '國建',
	'2892' => '第一金',
	'2317' => '鴻海',
	);

// Key List
$stockKeyList = array_keys($stockList);

// Get current first key
$defaultStockID = key($stockList);

// Default Stock ID
$stockID = isset($_GET['stock_id']) ? $_GET['stock_id'] : $defaultStockID;

$nextID = 0;

// Get HTML from API
$result = API::fetchIncomeStatement($stockID);

?>

<!DOCTYPE html>
<html>
<head>
	<title>TWSE mops</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
	<div>
		<select onchange="location.href='?stock_id='+this.value">
			<?php foreach ($stockList as $key => $value): ?>
			<option value="<?=$key?>" <?=$key==$stockID ?'selected':''?>><?=$key.'-'.$value?></option>
			<?php 
				if ($key==$stockID) {
					$position = array_search($key, $stockKeyList);
					$nextID = $stockKeyList[$position+1];
				} 
			?>
			<?php endforeach ?>	
		</select>

		<?php if ($nextID): ?>
			<button type="button" onclick="location.href='?stock_id=<?=$nextID?>';">Next</button>
		<?php endif ?>
	</div>

	<div>
		<?=$result?>
	</div>
</body>
</html>


