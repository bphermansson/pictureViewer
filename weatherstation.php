<?php 
// Get data from Home Assistant / Weather station
$hassip = "192.168.1.142";

if(false === ($wdatain = file_get_contents("http://".$hassip.":8123/api/states/sensor.vind_medel"))){
	// Error
	$windspeed="Outdoor wind error";
}
else {
        // echo $wdatain."<br>";
	// Extract wind speed
	$wdata = json_decode($wdatain);
        $windspeed = $wdata->state; 
        $updated = $wdata->last_updated;
} 
if(false === ($wdatain = file_get_contents("http://".$hassip.":8123/api/states/sensor.vind_momentan"))){
	// Error
	$windspeed="Outdoor wind mom error";
}
else {
        // echo $wdatain."<br>";
	// Extract wind speed
	$wdata = json_decode($wdatain);
        $windspeedm = $wdata->state; 
        $updated = $wdata->last_updated;
} 	
// 
if(false === ($wdatain = file_get_contents("http://".$hassip.":8123/api/states/sensor.luftfukt_uthus"))){
	// Error
	$moist="Moist error";
}
else {
        // echo $wdatain."<br>";
	$wdata = json_decode($wdatain);
        $moist = $wdata->state; 
        $updated = $wdata->last_updated;
} 
	
// sensor.temp_ute_uthus
// sensor.vindm_batt
// sensor.windir

if(false === ($wdatain = file_get_contents("http://".$hassip.":8123/api/states/sensor.temp_ute_uthus"))){
	// Error
	$temp="Temp error";
}
else {
        // echo $wdatain."<br>";
	$wdata = json_decode($wdatain);
        $temp = $wdata->state; 
        $updated = $wdata->last_updated;
}

if(false === ($wdatain = file_get_contents("http://".$hassip.":8123/api/states/sensor.vindm_batt"))){
	// Error
	$batt="Battery error";
}
else {
        // echo $wdatain."<br>";
	$wdata = json_decode($wdatain);
        $batt = $wdata->state; 
        $updated = $wdata->last_updated;
}
if(false === ($wdatain = file_get_contents("http://".$hassip.":8123/api/states/sensor.windir"))){
	// Error
	$winddir="Winddir error";
}
else {
        // echo $wdatain."<br>";
	$wdata = json_decode($wdatain);
        $winddir = $wdata->state; 
        $updated = $wdata->last_updated;
}


// Current time
$timenow = date('H:i');

$filedata = array(
        'temp' => $temp,
	'batt' => $batt,
        'winddir' => $winddir,
	'windspeed' => $windspeed,
        'windspeedm' => $windspeedm,
	'moist' => $moist,
	'timenow' => $timenow,

);
echo json_encode($filedata);
?>