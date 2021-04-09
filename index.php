<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vårt Zoo</title>
    <link rel='stylesheet' type='text/css' href='style.css' />
    <link rel="preconnect" href="https://fonts.gstatic.com"> 
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
    

<h1>Zoo-formulär</h1>


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

    

   /*  if($pdoExec)
    {
        echo 'Data inserted'; 
    } else {
        echo 'Data failed to insert';
    } */
}
?>

<div id="wrapper">
<div id="form">
    <h2>Lägg till ett djur nedan</h2>
    <form action="index.php" method="post">
        <label>ID</label>
        <input class="textfalt" type="text" name="id" required placeholder="Skriv ett ID.."> 
        <label>Namn</label>
        <input class="textfalt" type="text" name="name" required placeholder="Skriv ett Namn..">
        <label>Kategori</label>
        <input class="textfalt" type="text" name="category" required placeholder="Skriv en Kategori..">
        <label>Födelsedatum</label>
        <input class="textfalt" type="text" name="birthday" required placeholder="Skriv ett Födelsedatum..">
        <input class="knapp" type="submit" name="insert" value="Lägg till">

        <?php
         if($pdoExec)
    {
        echo '<p style="color:green;" class="fail">Ett djur lades till</p>'; 
    } else {
        echo '<p class="fail">Inget djur har lagts till ännu</p>';
    }
?>
    </form>
    

</div>



<!-- Filuppladning -->
<div id="filuppladdning">
    <h2>Ladda upp en bild på ett djur</h2>
<form enctype="multipart/form-data" action="index.php" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
    <input type="file" name="fileToUpload" id="ftu" />
    <input class="knapp" type="submit" value="Ladda upp fil" />
  </form>

  <?php

if ($_FILES) {

    $uploadDir = "temp/";
    $uploadPath = $uploadDir . basename($_FILES['fileToUpload']['name']);

    if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadPath)) {
        echo '<p style="color:green;" class="felfil">Filen är uppladdad</p>';
        echo "<img src=".$uploadPath." height=200 width=300 />";
    } else {
        echo '<p style="color:red;" class="felfil"> Något gick fel</p>';
    }
}

?>
  </div>
  </div>




<?php

    $dbh = new PDO('mysql:host=localhost;dbname=zoo;port=8889;charset=utf8;', "ZooAdmin", "animals", );
    $query = "SELECT * FROM animals WHERE ':id' < 20";
    $statement = $dbh->prepare($query, array(PDO::FETCH_ASSOC));
    $statement->execute(array(':id' => 10));
    $result = $statement->fetchAll();

    $animalSelect = str_replace('-', ' ', $_POST['animals']);
    $queryUserInput = 'SELECT * FROM animals WHERE name = ?';
    $statementByName = $dbh->prepare($queryUserInput, array(PDO::FETCH_ASSOC));
    $statementByName->execute(array($animalSelect));
    $resultName = $statementByName->fetchAll();
?>
<div id="parant">
<div id="rullgardin">
    <h2>Se information om ett djur</h2>
  <form action="index.php" method="post">
      <div id="hej">
    <select id="gardin" name='animals'>
      <?php
          foreach ($result as $animal) {
              if ($animal['name'] == $animalSelect) {
                  echo'<option Selected value='.str_replace(' ', '-', $animal['name']).'>'.$animal['name'].'</option>';
              } else {
                  echo '<option value='.str_replace(' ', '-', $animal['name']).'>'.$animal['name'].'</option>';
              }
          }
          ?>
        
      <input class="knapp" type="submit" value="Sök" name="sortByName">

    </select>
    </div>
  </form>
    
        <?php
            foreach ($resultName as $animal) {
                echo '<span>'
                .'<span>'.$animal['name'] .'</span>'
                .'<span>'.$animal['category'] .'</span>'
                .'<span>'.$animal['birthday'] .'</span>'
                .'</span>';
            }
            ?>
  </div>
  </div>
  

 


</body>
</html>