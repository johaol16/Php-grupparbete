<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vårt Zoo</title>
</head>
<body>
    

<h1>mm detta är vårat zoo</h1>


<!-- File Upload -->
<form action="upload.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>


<!-- Textfält med knapp-->
<label for="text">Skriv här</label><br>
<textarea name="text" id="" cols="30" rows="10"><?php echo $text;?></textarea><br>
<input type="submit" name="submit" value="Submit">  
<br>

<?php

$text = "";

ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);



$dbh = new PDO('mysql:host=localhost;dbname=zoo;charset=UTF8;port=8889', 'ZooAdmin', 'animals');

$query = "SELECT * FROM zoo.animals";
foreach ($dbh->query($query) as $animals) {
echo $animals['name'] . "<br/>";
}


/* Textfält */
echo $text;


?>

</body>
</html>