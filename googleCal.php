<?php
// Google Calendar access, as of https://developers.google.com/google-apps/calendar/quickstart/php
// https://github.com/google/google-api-php-client/issues/263#issuecomment-186557360

require_once __DIR__ . '/vendor/autoload.php';
define('APPLICATION_NAME', 'Google Calendar API Quickstart');
define('CREDENTIALS_PATH', 'calendar-php-quickstart.json');
define('CLIENT_SECRET_PATH', 'client_secret.json');
// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/calendar-php-quickstart.json
define('SCOPES', implode(' ', array(
  Google_Service_Calendar::CALENDAR_READONLY)
));
/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient() {
  $client = new Google_Client();
  $client->setApplicationName(APPLICATION_NAME);
  $client->setScopes(SCOPES);
  $client->setAuthConfig(CLIENT_SECRET_PATH);
  $client->setAccessType('offline');
  
//echo("Ok");

  // Load previously authorized credentials from a file.
  $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);
  //$credentialsPath = "/media/usbminne/calendar-php-quickstart.json";
  //echo $credentialsPath;
  if (file_exists($credentialsPath)) {
    //echo $credentialsPath;
    $accessToken = json_decode(file_get_contents($credentialsPath), true);
  } else {
    // Request authorization from the user.
    $authUrl = $client->createAuthUrl();
    printf("Open the following link in your browser:\n%s\n", $authUrl);
    print 'Enter verification code: ';
    $authCode = trim(fgets(STDIN));

    // Exchange authorization code for an access token.
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

    // Store the credentials to disk.
    if(!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, json_encode($accessToken));
    printf("Credentials saved to %s\n", $credentialsPath);
  }
  $client->setAccessToken($accessToken);

  // Refresh the token if it's expired.
  if ($client->isAccessTokenExpired()) {
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
  }
  return $client;
}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path) {
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
  }
  return str_replace('~', realpath($homeDirectory), $path);
}

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Calendar($client);

// List all calendars. Uncomment to see calendar names and id to use below.
/*
$calendarList = $service->calendarList->listCalendarList();
while(true) {
  foreach ($calendarList->getItems() as $calendarListEntry) {
    echo $calendarListEntry->getSummary();
    echo "<br>";
    echo $calendarListEntry->getId();
    echo "<br>";
  }
  $pageToken = $calendarList->getNextPageToken();
  if ($pageToken) {
    $optParams = array('pageToken' => $pageToken);
    $calendarList = $service->calendarList->listCalendarList($optParams);
  } else {
    break;
  }
}
*/
/*
THIS WORKS:
// Print the next 10 events on the user's calendar.
$calendarId = 'primary';
$optParams = array(
  'maxResults' => 10,
  'orderBy' => 'startTime',
  'singleEvents' => TRUE,
  'timeMin' => date('c'),
);
$results = $service->events->listEvents($calendarId, $optParams);

if (count($results->getItems()) == 0) {
  print "No upcoming events found.\n";
} else {
  print "Upcoming events:\n";
  foreach ($results->getItems() as $event) {
    $start = $event->start->dateTime;
    if (empty($start)) {
      $start = $event->start->date;
    }
    printf("%s (%s)\n", $event->getSummary(), $start);
  }
}
*/

// Check all calendars
// Set id for the calendars to show
$calArray = array('angel_h80@hotmail.com','hermansson.patrik@gmail.com','5rmmqeg98hkobeu2et6neifn7s@group.calendar.google.com','h2n06olo7qjs40r5mu6v0335t4@group.calendar.google.com');
$calNames = array('Helen','Patrik','Oskar','Sabina');

$optParams = array(
  'maxResults' => 8,
  'orderBy' => 'startTime',
  'singleEvents' => True,
  'timeMin' => date('c'),
);
$c=0;
error_reporting(0);	// Show no errors
//error_reporting(E_ALL); // Show all errors

$filedata[noofcals]=3;
$filedata[cals]=$calArray;
foreach ($calArray as $calendar) {
	//print($c."<br>");
	getEvents($calendar, $service,$optParams,$c,$calNames[$c]);
	//echo $calendar . "-". $filedata["event"]."<br>\n";
	//print_r($filedata);
	//echo ("<br>");
	$c++;
}
//print_r ($filedata);
// Sort all events in date order (According to timestamps)
asort($allevents);
//print_r("Encode");
echo json_encode($allevents);
//echo("<br><br>");
//echo json_encode($filedata);
exit;

/* ------------------*/

$results = $service->events->listEvents($calendarId, $optParams);

if (count($results->getItems()) == 0) {
  print "No upcoming events found.\n";
} else {
  //print "Upcoming events:\n";
  foreach ($results->getItems() as $event) {
    $start = $event->start->dateTime;
    if (empty($start)) {
      $start = $event->start->date;
    }
    //printf("%s (%s)\n", $event->getSummary(), $start);
    //printf("%s\n", $event->getSummary());
    // Collect data as json
    $filedata = array(
	'event' => $event->getSummary(),
	'start' => $start = $event->start->dateTime,
	);
     //echo json_encode($filedata);
  }
}

/* ------------------*/

function getEvents($calId, $service,$optParams,$c,$calName) {
	//print_r($calId."<br>");
	global $filedata;
	global $allevents;
	$ec=0;	// Events counter
	//print_r("Get data from: ".$calName."<br>");

	$filedata[$calId][name]=$calName;
	$results = $service->events->listEvents($calId, $optParams);
	//$ownerId = $service->calendars->get($calId);
	//$owner = $ownerId->getSummary();
	//print_r ($results."<br>");
	if (count($results->getItems()) == 0) {
	     //print "No upcoming events found.\n";
	     global $filedata;
             $filedata[$calId][event]="Tar det lugnt...";
	     $filedata[$calId][start]="0";
	} else {
		//print "Upcoming events:\n";
		//print_r ("Count: ".count($results->getItems())."<br>");
		$res = $results->getItems();
		//echo "Size: " . sizeof($res)."<br>";
		//print_r($res);
		//print_r("<br>");
		//foreach ($results->getItems() as $event) {
		foreach($res as $event) {
			//print_r("found item");
			$start = $event->start->dateTime;
			$startdate = $event->start->date;
			$end = $event->end->dateTime;
			$event=$event->getSummary();
			$rec=$event->recurringEventId;

			//echo $event."<br>";

			//$creator = $event->creator->displayName;

			if (empty($start)) {
				$start = $event->start->date;
			}
			if (strlen($start)>1) {
				/*
				echo($start."<br>");
				echo($end."<br>");
				echo ($event."<br>");
				*/
				// GET WEEKDAY!
				//$day=strftime("%A",strtotime($startdate));
				//echo $rec;
				//echo $start."<br>";

				// Convert starttime to timestamp to use as a unique identifier
				// Also add a counter, if there are several events with same starttime
				$timestampc = date("U",strtotime($start)).$ec;
				// Plain timestamp
				$timestamp = date("U",strtotime($start));

				//echo $timestamp."<br>";
				// Localized week day
				setlocale(LC_ALL, 'swedish');
				$day = strftime("%A", $timestamp);
				$day = utf8_encode($day);
				// First char uppercase
				$day = ucfirst($day);
				//echo $day;
				$allevents[$timestampc]["start"] = $start;
				$allevents[$timestampc]["end"] = $end;
				$allevents[$timestampc]["event"] = $event;
				$allevents[$timestampc]["day"] = $day;


			}
			//printf("%s (%s)\n", $event->getSummary(), $start);
			//printf("%s\n", $event->getSummary());
			    // Collect data as json
			    //$start1 = $start = $event->start->dateTime;
			    //echo $start1;
			    /*
			    $filedata = array(
				$calId => $calId,
				'event' => $event->getSummary(),
				'start' => $start = $event->start->dateTime,
				);
				*/
			     global $filedata;
			     //$filedata[calId]=$calId;
			     $filedata[$calId][event][$ec]=$event;
			     $filedata[$calId][start][$ec]=$start;

			     //print_r($ec."<br>");
			     $ec++;
			     //$filedata[$calId][creator]=$creator;
			     //$filedata[$calId][owner]=$owner;


			    // print_r ($filedata);
		     //echo json_encode($filedata);
		}
		return $filedata;
	}


}
