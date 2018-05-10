/* Load weather data from Smhi. Use a counter, dont retrieve data on every picture change */
			//console.log("smhicheck:"+smhicheck);
			if (smhicheck>smhiinterval || smhicheck==0) {
				try {
				console.log("Get Smhi data");
				$.get( "smhidata.php", function( data ) {
					console.log( "Data Loaded from Smhi: " + data );

					var mydata = $.parseJSON(data);
					windspeed=mydata.windspeed;
					winddir=mydata.winddir;
					rain=mydata.rain;
					wnowtext = mydata.wnowtext;
					moist = mydata.moist;

					if (winddir < 45 || winddir > 315) {
						winddirtext = "nordlig";
					}
					else if (winddir > 45 || winddir > 135) {
						winddirtext = "?stlig";
					}
					else if (winddir <= 135||winddir >= 225) {
						winddirtext = "sydlig";
					}
					else if (winddir < 225 || winddir > 315) {
						winddirtext = "v?stlig";
					}
					// Add data to bottom div
					bottomhtml = "Vind: " + windspeed + " m/s "+ winddirtext + ". Regn:  " + rain +". " + wnowtext;
					console.log("bottom: " + bottomhtml);
					// Add moist value to right panel
					//$("#irowMoist").html("Luftfuktighet: " + moist + "% ")

				});
				}
				catch(err){
					alert("an error occured");
				}
				smhicheck=0;

