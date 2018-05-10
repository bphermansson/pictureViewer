<?php
if(false === ($yr_data = file_get_contents("http://192.168.1.190:8123/api/states/sensor.weather_symbol"))){
	// Error
	echo "Yr.no data error";
}	
	$data = json_decode($yr_data);	
	echo $data->state; 
?>