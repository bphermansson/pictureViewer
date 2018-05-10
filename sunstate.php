<?php
if(false === ($sunstate_data = file_get_contents("http://192.168.1.190:8123/api/states/sun.sun"))){
	// Error
	echo "Sun state data error";
}	
	$data = json_decode($sunstate_data);	
	echo $data->state; 
?>