<?php

mkdir("afbeeldingen");

$target_dir = "afbeeldingen/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$naam = $_POST["naamFile"];

$array = explode(".", $_FILES["fileToUpload"]["name"]);
$ext = end($array);
$timestamp = time();

$naamBestand = $naam . $timestamp . "." . $ext;

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if ($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

$image_size = $_FILES["inputname"]["size"];
if ($image_size > 1000) {
	echo "size too large";
}


// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 3000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

//Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif") {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir."/".$naamBestand)) {
  echo " The file " . $naamBestand . " has been uploaded.<br>"; 

  // opening a directory
  $dir_handle = opendir("afbeeldingen/.");
  
  // reading the contents of the directory
  while (($file_name = readdir($dir_handle)) !== false) { 
    echo "<img src='afbeeldingen/" . $file_name . "'><br>";
  }
   
  // closing the directory
  losedir($dir_handle);

  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}