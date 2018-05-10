
/* Emoncms */
			// Call php script to get data from Emoncms.org
		try {
			console.log("Get Emoncms values");
			$.get( "emoncms.php", function( data ) {
				console.log( "Data Loaded from Emoncms: " + data );
				var mydata = $.parseJSON(data);
				//var outdoortemp = mydata.outdoortemp;
				pressure = mydata.pressure;
				//var washertemp = mydata.washertemp;
				//var washerhum = mydata.washerhum;
				var timenow = mydata.timenow;

				// Show fetched data
				//$("#info").html("Klockan ?r:<br>" + timenow + " <br>Temperatur: "+ outdoortemp);
				$("#irow1").html(timenow );
				//$("#irow2").html("Ute: "+ outdoortemp + "C");
				//$("#irow4").html("Tv?ttstuga: " + washertemp + "C, " + washerhum + "%");
				//$("#irow3").html("Lufttryck: "+pressure + "hPa");
                                //$("#irow3").html(pressure + "hPa");

				// Resize info div size
				//window.getComputedStyle(document.getElementById('your-element')).width;
			});
			}
			catch(err){
				alert("an error occured");
			}
