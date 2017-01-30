<?php 

// TODO 
// Rotate image based on Exif data

// Where to find pictures to show?
$dir='bilder';

// All file names in an array
$files = scandir($dir);
// Number of files
$nooffiles = count($files);
//print_r($nooffiles." files in ".$dir."<br>");
// Get a random file
// index 0 and 1 are . and .., dont select these
// Set max random number to no of files in array
$rand = rand(2 , $nooffiles);
$filename = $files[$rand];
$ext = pathinfo($filename, PATHINFO_EXTENSION);
while ($ext!="jpg") {
	$rand = rand(2 , $nooffiles);
	$filename = $files[$rand];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
}

$path_filename = $dir."/".$filename;
//echo "Whole path: ".$path_filename."<br>";

// Get exif data
$exif = exif_read_data($path_filename, 0, true);
// Extract exif data
$exifdatetime=$exif['EXIF']['DateTimeOriginal'];
$pieces = explode(" ", $exifdatetime);
$exifdate = $pieces[0];
$exifdate = str_replace(':', '-', $exifdate);
$exiftime = $pieces[1];

$exifheight=$exif['COMPUTED']['Height'];
$exifwidth=$exif['COMPUTED']['Width'];
$ratio=$exifheight/$exifwidth;
$rotation = $exif['IFD0']['Orientation'];
	//echo $rotation;

// Find image rotation
    if (!empty($exif['Orientation'])) {
    //print_r $exif['Orientation'];
        switch ($exif['Orientation']) {
            case 3:
		//echo "3";
		break;
            case 6:
	        // -90 degrees
                break;
            case 8:
		// 90 degrees
                break;
        }
    }


// Show all values
/*
foreach ($exif as $key => $section) {
    foreach ($section as $name => $val) {
        //echo "$key.$name: $val<br />\n";
	echo("<script>console.log('PHP: $key.$name: $val');</script>");
    }
}
*/

$filedata = array(
	'path' => $dir,
        'filename' => $filename,
	'date' => $exifdate,
        'time' => $exiftime,
	'height' => $exifheight,
	'width' => $exifwidth,
	'ratio' => $ratio,
	'rotation' => $rotation, 
     );

echo json_encode($filedata);
?>