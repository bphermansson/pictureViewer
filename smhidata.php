<?php
// Location: 58.394575, 12.751333
$speedurl = "http://opendata-download-metobs.smhi.se/api/version/latest/parameter/4/station/82260/period/latest-hour/data.json"; // url to parse
$dirurl = "http://opendata-download-metobs.smhi.se/api/version/latest/parameter/3/station/82260/period/latest-hour/data.json"; // url to parse
$rainurl="http://opendata-download-metobs.smhi.se/api/version/latest/parameter/7/station/82260/period/latest-hour/data.json";

// Weather forecast
// GET /api/category/{category}/version/{version}/geotype/point/lon/{longitude}/lat/{latitude}/data.json
// http://opendata-download-metfcst.smhi.se/api/category/pmp2g/version/2/geotype/point/lon/12/lat/58/data.json

/*
Aktuellt väder
http://opendata-download-metobs.smhi.se/api/version/latest/parameter/13/station/82260/period/latest-hour/data.json
Ger en kod i value
Koden förklaras på http://opendata-download-metobs.smhi.se/api/version/1.0/parameter/13/codes.json
*/

$wnowurl="http://opendata-download-metobs.smhi.se/api/version/latest/parameter/13/station/82260/period/latest-hour/data.json";

/*
Luftfuktighet:
http://opendata-download-metobs.smhi.se/api/version/latest/parameter/6/station/82260/period/latest-hour/data.json
*/
$moisturl="http://opendata-download-metobs.smhi.se/api/version/latest/parameter/6/station/82260/period/latest-hour/data.json";

//if(false === ($outdoortemp = file_get_contents("http://emoncms.org/feed/value.json?apikey=8133697b1b562f52689bd680b330cb4d&id=41362"))){
if(false === ($content = file_get_contents($speedurl))){
	$windspeed="NA";
}
else {
	$json = json_decode($content, true);
	foreach($json['value'] as $item) {
	    //print "Wind speed: ".$item['value']."<br>";
	    $windspeed=$item['value'];
	}
}
if(false === ($content = file_get_contents($rainurl))){
	$rain="NA";
}
else {
	$json = json_decode($content, true);
	foreach($json['value'] as $item) {
	    //print "Wind speed: ".$item['value']."<br>";
	    $rain=$item['value'];
	}
}
if(false === ($content = file_get_contents($dirurl))){
	$winddir="NA";
}
else {
	$json = json_decode($content, true);
	foreach($json['value'] as $item) {
	    //print "Direction: ".$item['value'];
	    $winddir = $item['value'];
	}
}

if(false === ($content = file_get_contents($wnowurl))){
	$wnow="NA";
}
else {
	$json = json_decode($content, true);
	foreach($json['value'] as $item) {
	    //print "Direction: ".$item['value'];
	    $wnow = $item['value'];
	}
	// Codes downloaded from http://opendata-download-metobs.smhi.se/api/version/1.0/parameter/13/codes.json to codes.json
	
	$file = 'codes.json';
	if (file_exists($file)) {
		//echo "Ok";
		$json = json_decode(file_get_contents($file),true);
		foreach($json as $row)
		{
			//echo $wnow;
			//echo ($json["entry"][$wnow]["value"]);
			$wnowtext = $json["entry"][$wnow]["value"];
		}
	}
}
if(false === ($content = file_get_contents($moisturl))){
	$moist="NA";
}
else {
	$json = json_decode($content, true);
	foreach($json['value'] as $item) {
	    //print "Direction: ".$item['value'];
	    $moist = $item['value'];
	}
}

/*
if ($winddir < 45 || $winddir > 315) {
	$winddirtext = "Nord";
}
else if ($winddir > 45 || $winddir > 135) {
	$winddirtext = "Öst";
}
else if ($winddir <= 135||$winddir >= 225) {
	$winddirtext = "Syd";
}
else if ($winddir < 225 || $winddir > 315) {
	$winddirtext = "Väst";
}
*/
//print $winddirtext;
//var_dump(json_decode($content));

// Collect data as json
$filedata = array(
	'windspeed' => $windspeed,
	'winddir' => $winddir,
	'rain' => $rain,
	'wnow' => $wnow,
	'wnowtext' => $wnowtext,
	'moist' => $moist,
	);
echo json_encode($filedata);

?>