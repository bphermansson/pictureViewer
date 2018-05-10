/* Washer room info */
		try {			
			console.log("Get washer room values");
			$.get( "washerdata.php", function( data ) {
			var mydata = $.parseJSON(data);
			var washertemp = mydata.temp;
			var washerhum = mydata.humidity;
			var washerpower = mydata.power;
                        var washerstate = mydata.state;

			// Round temp value
			washertemp = washertemp * 10;
			washertemp = (Math.round(washertemp))/10;
			//washertemp = washertemp-3	// Adjust value, meter reads to high
			console.log( "Data Loaded from Washer server: " + washertemp +"-" + washerhum +"-" + washerpower );

			//console.log("washerpowerint: " + washerpowerint);
			if (washerpower>10 && washerStatus==0) {    // Status = off and it uses power
				washerStatus=1;                     // Set status = 1
				console.log("Washer started");
			}

			if (washerpower>10 && washerStatus==1) {    // It uses power and status = 1
          washerOff=0;
          washerOn++;
          console.log("Reset washerOff");
			}
			if (washerpower<10 && washerStatus==1) {
  				washerOn++;  // Add to run counter
          washerOff++;
          console.log("Washer is idle. washerOff=" + washerOff);
			}
			if(washerOff>10) {
				console.log("Washer stopped");
				washerStatus = 0;
				washerOn=0;
				washerOff=0;
			}
			var washerText;
			var washerOnTime;
			if(washerStatus==1) {
        washerText="running"
        var washerOnSec = washerOn * 30; // 30 seconds between runs. This gets the on time in seconds.
        var date = new Date(null);
        date.setSeconds(washerOnSec); // specify value for SECONDS here
        washerOnTime = date.toISOString().substr(11, 5);
        washerOnTime = "Körtid: " + washerOnTime;
      }
      else {
        washerText="av";
        washerOnTime="";
      }

			$("#irow4").html("Tvättstuga:<br>Temp: " + washertemp + "C.<br>Fuktighet: " + washerhum + "%<br>" + washerpower + "W<br>Tv?ttmaskinen ?r "+washerText +"<br>"+washerOnTime);
			});
			}
			catch(err){
				alert("an error occured");
			}
