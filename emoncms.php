<?php 
// Get outdoor temp

//if(false === ($data = @file_get_contents('http://example.org'))){
//  #error
//}
//$outdoortemp = file_get_contents("http://emoncms.org/feed/value.json?apikey=8133697b1b562f52689bd680b330cb4d&id=41362");

if(false === ($outdoortemp = file_get_contents("http://emoncms.org/feed/value.json?apikey=8133697b1b562f52689bd680b330cb4d&id=41362"))){
	// Error
	$outdoortemp="Outdoor temp error";
}
else {
	// Remove citation marks
	$outdoortemp = str_replace('"', '', $outdoortemp);
}

if(false === ($pressure = file_get_contents("http://emoncms.org/feed/value.json?apikey=8133697b1b562f52689bd680b330cb4d&id=41365"))){
	$pressure="Pressure error";
}
else {
	$pressure = str_replace('"', '', $pressure);
}

if(false === ($washertemp = file_get_contents("http://emoncms.org/feed/value.json?apikey=8133697b1b562f52689bd680b330cb4d&id=153900"))){
	$washertemp="Washer temp error";
}
else {
	$washertemp = str_replace('"', '', $washertemp);
}
if(false === ($washerhum = file_get_contents("http://emoncms.org/feed/value.json?apikey=8133697b1b562f52689bd680b330cb4d&id=153899"))){
	$washerhum="Washer humidity error";
}
else {
	$washerhum = str_replace('"', '', $washerhum);
}	
	
	
// Current time
$timenow = date('H:i');

$filedata = array(
	'outdoortemp' => $outdoortemp,
	'pressure' => $pressure,
	'washertemp' => $washertemp,
	'washerhum' => $washerhum,
	'timenow' => $timenow,

);
echo json_encode($filedata);
?>