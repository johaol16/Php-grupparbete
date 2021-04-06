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
<!-- <form action="" method="post">
<label for="text">Sök här:</label><br>
<input type="text" name="search" placeholder="Sök här.."></input><br>
<input type="submit" name="button" value="Submit">  
<br>
</form> -->

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

<?php
if(isset($_POST['insert'])) 
{
    try{
        $pdoConnect = new PDO('mysql:host=localhost;dbname=zoo;charset=UTF8;port=8889', 'ZooAdmin', 'animals');
    } catch (PDOexception $exc) {
        echo $exc->getMessage();
        exit();
    }
    $id = $_POST ['id'];
    $name = $_POST ['name'];
    $category = $_POST['category'];
    $birthday = $_POST ['birthday'];

    $pdoQuery = "INSERT INTO animals(id, name, category, birthday) VALUES (:id,:name,:category,:birthday)";

    $pdoResult = $pdoConnect->prepare($pdoQuery);

    $pdoExec = $pdoResult->execute(array(":id"=>$id,":name"=>$name,":category"=>$category,":birthday"=>$birthday,));

    if($pdoExec)
    {
        echo 'Data inserted'; 
    } else {
        echo 'Data failed to insert';
    }
}
?>
<pre>
    <legend>Lägg till ett djur nedan</legend>
    <form action="index.php" method="post">
        <input type="text" name="id" required placeholder="id"> 
        <input type="text" name="name" required placeholder="name">
        <input type="text" name="category" required placeholder="category">
        <input type="text" name="birthday" required placeholder="birthday">
        <input type="submit" name="insert" value="Lägg till">
    </form>

</pre>





</body>
</html>