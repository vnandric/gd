<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$naam = $_POST['naam'];
$bestand = $_FILES['bestand'];
$timestamp = time();
$ext = pathinfo($bestand['name'], PATHINFO_EXTENSION);
$thumb = "thumb_";

// Bestandsextensie controleren
$allowed = array('jpg', 'jpeg', 'gif', 'png');
if (!in_array($ext, $allowed)) {
	echo "Het bestand moet een afbeelding zijn (jpg, jpeg, gif of png)";
	exit;
}

// Bestandsgrootte controleren
if ($bestand['size'] > 3000000) {
	echo "Het bestand mag niet groter zijn dan 3MB";
	exit;
}

// Bestandsafmetingen controleren
$afbeelding = getimagesize($bestand['tmp_name']);
if ($afbeelding[0] > 1000 || $afbeelding[1] > 1000) {
	echo "De breedte en hoogte van de afbeelding moeten kleiner zijn dan 1000 pixels";
	exit;
}

// Map 'afbeeldingen' aanmaken als deze nog niet bestaat
if (!file_exists('afbeeldingen')) {
	mkdir('afbeeldingen');
}

// Map 'thumbs' aanmaken als deze nog niet bestaat
if (!file_exists('thumbs')) {
    mkdir('thumbs');
}

// Bestandsnaam bepalen voor mapje 'afbeeldingen'
$bestandsnaam = $naam . $timestamp . '.' . $ext;

// afbeelding opslaan in map 'afbeeldingen' en thumbnail in map 'thumbs'
if (move_uploaded_file($bestand['tmp_name'], 'afbeeldingen/' . $bestandsnaam)) {
    echo "Het bestand is opgeslagen als " . $bestandsnaam . "<br>";
} else {
    echo "Er is een fout opgetreden tijdens het opslaan van het bestand";
}

// make an thumbail and sen the image to the thumbs folder
$thumb = "thumb_";
$thumbnaam = $thumb . $bestandsnaam;
$thumb = imagecreatetruecolor(100, 100);
$source = imagecreatefromjpeg('afbeeldingen/' . $bestandsnaam);
imagecopyresized($thumb, $source, 0, 0, 0, 0, 50, 50, $afbeelding[0], $afbeelding[1]);
imagejpeg($thumb, 'thumbs/' . $thumbnaam);

// show all thumbnails
$dir = "thumbs/";
$files = scandir($dir);
foreach ($files as $file) {
    if ($file != "." && $file != "..") {
        echo "<img src='thumbs/$file' alt='thumbnail'>";
    }
}


?>
