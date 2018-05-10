<?php
if(false === ($outdoortemp = file_get_contents("http://192.168.1.190:8123/api/states/sensor.temp_out_weather_station"))){
	// Error
	echo "Outdoor temp error";
}	
	$data = json_decode($outdoortemp);	
	echo $data->state; 
?>