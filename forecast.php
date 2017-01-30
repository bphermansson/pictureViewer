<?php
/* The weather type is presented as a number from 1-15. 
They are explained at http://opendata.smhi.se/apidocs/metfcst/parameters.html#parameter-wsymb
*/
$wtypes = array(
"Not used",
"Clear sky",
"Nearly clear sky",
"Variable cloudiness",
"Halfclear sky",
"Cloudy sky",
"Mulet",
"Fog",
"Rain showers",
"Thunderstorm",
"Light sleet",
"Snow showers",
"Rain",
"Thunder",
"Sleet",
"Snowfall");
//var_dump($wtypes);

// Get forecast for a geo position. 
$forecasturl="http://opendata-download-metfcst.smhi.se/api/category/pmp2g/version/2/geotype/point/lon/12/lat/58/data.json";

// Get current time
$timestamp=time();
//echo "Time now: " . $timestamp . "-" . date("Y-m-d\TH:i:s\Z", $timestamp)."<br>";

// 1 hour ahead
// Add 3600 seconds to current timestamp and convert to a date like "2017-01-26T10"
// We can then get the date/time from the forecast data and get values for x hours in the future.
$onehourfuture = $timestamp + 3600;
//echo "Time then: " . date("Y-m-d\TH:i:s\Z", $onehourfuture)."<br>";
$onehourfutureHour = date("Y-m-d\TH", $onehourfuture);
//echo "Time then: " . $onehourfutureHour."<br>";
// 4 hours ahead
$fourhourfuture = $timestamp + (3600*4);
//echo "Time then: " . date("Y-m-d\TH:i:s\Z", $onehourfuture)."<br>";
$fourhourfutureHour = date("Y-m-d\TH", $fourhourfuture);
//echo "Time then: " . $fourhourfutureHour."<br>";

$nighthour = date("Y-m-d\T02", time() + 86400 ); // 02:00 tomorrow night. Add 86400 secs (24 hours) and set time to 02. 
//echo $nighthour."<br>";
$morninghour = date("Y-m-d\T08", time() + 86400 ); // 08:00 tomorrow morning. Add 86400 secs (24 hours) and set time to 08. 

$forecasttimes = array($onehourfutureHour, $fourhourfutureHour, $nighthour, $morninghour);
//print_r($forecasttimes);

// Fetch forecast data
if(false === ($content = file_get_contents($forecasturl))){
	$forecast="NA";
}
else {
	$json = json_decode($content, true);
	//print_r($json["timeSeries"]);
	
	foreach($json["timeSeries"] as $item) {
	    //print "Forecast: ".$item['value']."<br>";
	    	//print_r($item["parameters"]);
		//print_r($item);
		//echo "<br>";
		//print_r ($item["msl"]);
		//echo "<br>";
		foreach($item as $key => $value) {
			if ($key=="validTime") {
				//echo $value . "<br />";
				$ts = strtotime($value);	// Timestamp for this value
				$valueOnlyHour = date("Y-m-d\TH", $ts);
				$ctime = date("H", $ts);
				//echo $valueOnlyHour. "<br />";
			}
			foreach($forecasttimes as $hour) {
				if ($hour == $valueOnlyHour) {
					//echo $hour . "<br />";
					// Hour of forecast
					$w[$hour]['ctime']=$ctime;
									
				// The forecast time equals a time in the future
				foreach($value as $sitem) {

					// Get weather symbol id
					if ($sitem["name"] == "Wsymb") {
						$w[$hour]['wtype'] = $wtypes[$sitem["values"]["0"]];
						
						//echo $wtype."C<br>";
					}
					// Expected temperature
					else if ($sitem["name"] == "t") {
						$w[$hour]['t'] = $sitem["values"]["0"];
						//echo $t."C<br>";
					}
					else if ($sitem["name"] == "ws") {
						$w[$hour]['ws'] = $sitem["values"]["0"];
						//echo $ws." m/s<br>";
					}
					else if ($sitem["name"] == "wd") {
						$w[$hour]['wd'] = $sitem["values"]["0"];
						//echo $wd." degrees<br>";
					}
				}
				}
			}
			
			if ($onehourfutureHour == $valueOnlyHour) {

			}
		}
	}
}
// Collect data as json
echo json_encode($w);
?>