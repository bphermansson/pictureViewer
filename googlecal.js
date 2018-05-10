// Get data from Google Calendar */
				console.log("Get calendar data");
				$("#irow5").html("Wait...");
			try {
				$.get( "googleCal.php", function( data ) {
				console.log( "Data Loaded from Google Calendar: " + data );
				var mydata = $.parseJSON(data);
				var inforowdata="";
				var urgentdata="";

				Object.keys(mydata).forEach(function(key,index) {
				// Runs one time per event found
					//console.log(key);
					//console.log(mydata[key]);
					$event=mydata[key];
					//console.log($event["start"]);
					//console.log($event["end"]);
					//console.log($event["event"]);

					var starttime = new Date($event["start"]);
					var endtime = new Date($event["end"]);
					var event = $event["event"];
					var weekday = $event["day"];
					var timerightnow = new Date(Date.now());
					var tsnow = timerightnow.getTime();
					console.log("tsnow: " + tsnow);
					// Get and adjust values
					var timestamp = starttime.getTime();
					starthour = ("0" + (starttime.getHours())).slice(-2); // Leading zero
					startmin = ("0" + (starttime.getMinutes())).slice(-2); // Leading zero
					startHM = starthour + ":" + startmin;
					startMonth = starttime.getMonth()+1;	// getMonth gives number from 0-11
					startMonth = ("0" + (startMonth)).slice(-2); // Leading zero
					startDay = ("0" + (starttime.getDate())).slice(-2); // Leading zero
					startdate = starttime.getFullYear()+"-"+startMonth+"-"+startDay;
					endhour = ("0" + (endtime.getHours())).slice(-2); // Leading zero
					endmin = ("0" + (endtime.getMinutes())).slice(-2); // Leading zero
					endHM = endhour + ":" + endmin;
					// Add data to right panel
					inforowdata = inforowdata + weekday + "<br>" +
					"<span style='font-size: 12px'>" +
					startdate + " " + startHM + "-" + endHM +
					"</span>" +
					"<br>" + event + "<br>-------------------<br>";
					// Add data to urgent panel
					if (urgentdata.length == 0) {
						// timestamp = event start time in millis
						// tsnow = time now in millis
						// timestamp = event start time in millis
						// tsnow = time now in millis
						// time to event:
						var tleft = timestamp - tsnow;
						console.log(tsnow + " " + timestamp + " " + thours + "tleft: " + tleft);

						// 24h = 86400000mS
						// Check if there is less than 24 hours less to the event
						var thours = parseInt((tleft/(1000*60*60))%24);  // Hours left to the event

						if (tleft < 86400000) {	// It's less than 24 hours left
							urgentdata = "Om " + thours + " timmar: " + event;
							$("#urgent").show();
						}
						else {
							urgentdata = "";
							$("#urgent").hide();
						}
					}


				});
				
				console.log("Inforowdata: ");
				console.log(inforowdata);
				// Infodivs to the right
				$("#irow5").html(inforowdata);
				//urgent
				$("#urgent").html(urgentdata);
				});
			}
			catch(err){
				alert("an error occured");
			}
