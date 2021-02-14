<?php

include('classes.php');

// Read image sizes from DB
require_once('db_connect.php');
$sizes = [];
$result = $mysqli->query("SELECT * FROM img_sizes");
while($row = $result->fetch_assoc()) {
	$sizes[$row["name"]] = $row["size"];
}


// Validate input request
$errors=[];

if (empty($_GET['name'])) {
	$errors[] = 'No image name in request.';
}

if (!in_array($_GET['name'], ImageList::from_folder("gallery/")) and !in_array($_GET['name'], ImageList::from_folder("cache/"))) {
	$errors[] = 'Image not found in folder.';
}

if (empty($_GET['size'])) {
	$errors[] = 'No image size in request.';
}

if (!isset($sizes[$_GET['size']])) {
	$errors[] = 'Unknown image size in request.';
}

if (count($errors)>0) {
	die('Errors!<br><li>'.implode("<li>",$errors));
}


// Create image
if (in_array($_GET['name'], ImageList::from_folder("cache/".$_GET['size']."/")))
{
	$image = new Image("cache/".$_GET['size']."/", $_GET['name']);
}
else
{
	$image = new Image("gallery/", $_GET['name']);
	$image->resize($sizes[$_GET['size']]);
	$image->save("cache/".$_GET['size']."/");
}

header("Content-type: " .image_type_to_mime_type(IMAGETYPE_JPEG));
imagejpeg($image->show());

