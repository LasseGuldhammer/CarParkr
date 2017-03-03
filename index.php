<!DOCTYPE html>
<html>
<head>
	<title>CarParkr - See live data</title>
	<link rel="stylesheet" type="text/css" href="reset.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php
include('class_request/class_request.php');
include('garageNames.php');
	
$request = new Request();	
$url = "http://www.odaa.dk/api/action/datastore_search?resource_id=2a82a145-0195-4081-a13c-b0e587e9b89c";

// get JSON data about a post
// - first get the data
$post = json_decode($request->getFile($url));
	
$dataList = array();
	
date_default_timezone_set("Europe/Copenhagen");	
	
// loop through all of the result records from the live data
foreach ($post->result->records as $record) {
	$recordCode = $record->garageCode;		
		foreach ($garageNames as $garage) {
			$garageName = $garage["garageName"];
			$garageCode = $garage["garageCode"];
			if ($recordCode === $garageCode) {
				$recordName = $garageName;
				$date = date_create($record->date);
				$timestamp = date_format($date,"Y-m-d H:i:s");
				$record->date = $timestamp;				
				$dataList[] = array("name"=>$recordName,"data"=>$record);
			}
		}
}
?>

<header>
	<img src="logo.png">
</header>

<main>

<!-- Article loop -->
<?php
	foreach ($dataList as $record) {
		$occupancy = round($record["data"]->vehicleCount / ($record["data"]->totalSpaces / 100));
		if ($occupancy > 75) {
			$level = "high";
		} elseif ($occupancy > 50) {
			$level = "med";
		} else {
			$level = "low";
		}
		?>
		<article class="card">
			<h2 class="title"><?php echo $record["name"];?></h2>
			<div class="bar">
				<div class="indicator <?php echo $level; ?>" style="width:<?php echo $occupancy;?>%"></div>
			</div>
			<dl class="stats">
				<dt><?php echo $record["data"]->vehicleCount;?></dt>
				<dd>Occupied</dd>
	   		 </dl>
			<dl class="stats">
				<dt><?php echo $record["data"]->totalSpaces;?></dt>
				<dd>Capacity</dd>
	    	</dl>
			<dl class="stats">
				<dt><?php echo ($record["data"]->totalSpaces - $record["data"]->vehicleCount);?></dt>
				<dd>Free</dd>
	    	</dl>
		</article>
	<?php
}
?>		
		
</main>
	
</html>