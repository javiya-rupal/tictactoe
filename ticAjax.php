<?php
require('conf.php');
session_start();
$clicked = ($_POST['clicked'])??'';
$symbol = ($_POST['symbol'])??'';
$bot = ($_POST['bot'])??'';
if($bot == 0) {
	//Human
	$sql = mysqli_query($conn, "UPDATE gameboard SET symbol = '".$symbol."' WHERE field='".$clicked."'") or die (mysqli_error());
	if($sql) {
		echo $clicked;
		//$filledPlaces = getFilledCombinations($conn, $symbol);
		//echo json_encode(['filledPlaces' => $filledPlaces]);
	}
}
else if($bot == 1) {
	//Bot
	function ai_think($conn) {
		$sql = mysqli_query($conn, "SELECT * FROM gameboard WHERE symbol = '' ORDER BY RAND() LIMIT 1") or die (mysqli_error());
		while($rows = mysqli_fetch_object($sql)){
			$availablePlace = $rows->field;
			//$rows->field returns 17
			//$availablePlaces[] = $rows['field'];
		}
		return $availablePlace;
	}
	$botPlace = ai_think($conn);
	/*print_r($availablePlaces);
	shuffle($availablePlaces);
	echo $availablePlaces[0];*/

	$sql = mysqli_query($conn, "UPDATE gameboard SET symbol = '".$symbol."' WHERE field='".$botPlace."'") or die (mysqli_error());
	if($sql){
		echo $botPlace;
		//$filledPlaces = getFilledCombinations($conn, $symbol);
		//echo json_encode(['botPlace' => $botPlace, 'filledPlaces' => $filledPlaces]);
	}
	// Get selected 

	//$sql = mysql_query("UPDATE gameboard SET symbol = '".$symbol."' WHERE field='".ai_think()."'") or die (mysql_error());
}

function getFilledCombinations($conn, $symbol) {
	$sql = mysqli_query($conn, "SELECT * FROM gameboard WHERE symbol = '".$symbol."'") or die (mysqli_error());
	while($rows = mysqli_fetch_object($sql)){
		$filledPlaces[] = $rows->field;
	}
	return $filledPlaces;
}
