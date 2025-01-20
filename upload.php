<?php

session_start();

$server_name = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "mydb"; 
$namx = $_SESSION["userzUID"];
$uz =  $_SESSION["userzE"];
$conn = mysqli_connect($server_name, $db_username, $db_password, $db_name);
//$sql = "SELECT pic FROM userz  WHERE userzEmail = '$uz' ;" ;
//$result = mysqli_query($conn, $sql);


$folder = mkdir("". $_SESSION["userzE"] ."/");
//$target_dir = $sql;
$target_dir = "". $_SESSION["userzE"] ."/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  
  
 
  header("location: profile.php?status=picChanged");
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
 if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
    $target_file = $target_dir . "file.jpg";
    //$sql2 = "UPDATE userz SET pic ='$check' WHERE userzEmail = '$uz' ;" ;
    //$result2 = mysqli_query($conn, $sql2);
    
    header("location: profile.php?status=picChanged");}

    
    

else {
  
  
    echo "File is not an image.";
    $uploadOk = 0;
    
  }}
  

  
 

// Check if file already exists
/*if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}*/



// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    
    echo "Sorry, there was an error uploading your file.";
  }
}

//header("location: profile.php?status=picChanged");
?>