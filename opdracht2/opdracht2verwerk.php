<?php
$naam = $_POST['naam'];
$bestand = $_FILES['bestand'];
$timestamp = time();
$ext = pathinfo($bestand['name'], PATHINFO_EXTENSION);

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

// Bestandsnaam bepalen
$bestandsnaam = $naam . $timestamp . '.' . $ext;

// Bestand opslaan
if (move_uploaded_file($bestand['tmp_name'], 'afbeeldingen/' . $bestandsnaam)) {
	echo "Het bestand is opgeslagen als " . $bestandsnaam;
} else {
	echo "Er is een fout opgetreden tijdens het opslaan van het bestand";
}
?>
