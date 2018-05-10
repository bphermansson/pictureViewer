/* Weather station */
		try {
			console.log("Get weather station values");
				$.get( "weatherstation.php", function( data ) {
				console.log( "Data Loaded from weatherstation: " + data );
                                var mydata = $.parseJSON(data);
				var windspeed = mydata.windspeed;
				var moist = mydata.moist;
				var winddir = mydata.winddir;
				var outdoortemp = mydata.temp;

				// Convert temp
				outdoortemp = outdoortemp * 10;
				outdoortemp = Math.round(outdoortemp)/10;

				// Convert winddir
				if (winddir >= 338 || winddir < 25) {
					winddirtext = "N";
				}
				else if (winddir >= 25 || winddir < 68) {
					winddirtext = "NE";
				}
				else if (winddir >= 68 || winddir < 112) {
					winddirtext = "E";
				}
				else if (winddir >= 112 || winddir < 158) {
					winddirtext = "SE";
				}
				else if (winddir >= 158 || winddir < 202) {
					winddirtext = "S";
				}
				else if (winddir >= 202 || winddir < 248) {
					winddirtext = "SW";
				}
				else if (winddir >= 248||winddir < 292) {
					winddirtext = "W";
				}
				else if (winddir >= 292 || winddir < 338) {
					winddirtext = "NW";
				}
				else {
					winddirtext = "Err";
				}
				$("#irow2").html("Ute: "+ outdoortemp + "C");
				$("#irowWind").html(windspeed + "m/s, " + winddirtext);
				$("#irowMoist").html(moist + "% ");
				$("#irow3").html(pressure + "hPa " + moist + "%") ;
				});
			}
			catch(err){
				alert("an error occured");
			}
