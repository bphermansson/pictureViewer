// Weather forecast */
function weather() {
console.log("Get forecast data");
			//try {
				$.get( "forecast.php", function( data ) {
					//console.log( "Forecast loaded: " + data );
					var mydata = $.parseJSON(data);
					console.log( "Forecast loaded: " + mydata );
					// Loop through array
					bottom2html = "--- ";
					Object.keys(mydata).forEach(function(key,index) {
						//console.log(key);
						var ctime = mydata[key]["ctime"];
						var t = mydata[key]["t"];
						var wd = mydata[key]["wd"];
						var ws = mydata[key]["ws"];
						var wtype = mydata[key]["wtype"];
						// Add data to second bottom div
						bottom2html = bottom2html + "kl: " + ctime + ".00: " + t + "C, " + wtype + " --- ";
					});
				});
			//}
			//catch(err){
			//	alert("an error occured");
			//}
}