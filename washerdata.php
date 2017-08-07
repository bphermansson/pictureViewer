<?php

// Data from washerroom sensor
// {"time":"73","temp":"17.00","humidity":"39.00","power":9}
if(false === ($washer = file_get_contents("http://192.168.1.117/"))){
	// Error
	$washer="Washer info error";
}
else {
        $washerstatus = json_decode($washer);
        $washertime = $washerstatus->time; 
        $washertemp = $washerstatus->temp; 
        $washerhumidity = $washerstatus->humidity; 
        $washerpower = $washerstatus->power; 
}

// Data from Home Assistant washer status

/*
http://192.168.1.108:8123/api/states/sensor.washer_pwrdn
{"attributes": {"friendly_name": "washer_pwrdn"}, "entity_id": "sensor.washer_pwrdn", "last_changed": "2017-03-11T20:01:19.814654+00:00", "last_updated": "2017-03-11T20:01:19.814654+00:00", "state": "True"}
*/
if(false === ($washerha = file_get_contents("http://192.168.1.108:8123/api/states/sensor.washer_pwrdn"))){
	// Error
	$washerstatus="Washer info error";
}
else {
    // Decode json
    $washerstatus = json_decode($washerha);
    $washeronoff = $washerstatus->state; 
    if ($washeronoff) { // True if washer is off
        $washerstate = "off";
    }
    else {
        $washerstate = "on";

    }
}

// Convert to json
$filedata = array(
	'washertime' => $washertime,
	'temp' => $washertemp,
	'humidity' => $washerhumidity,
	'power' => $washerpower,
	'state' => $washerstate,

);
$json = json_encode($filedata);
echo $json;
?>