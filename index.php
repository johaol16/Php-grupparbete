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

<!-- Filuppladning -->
<form enctype="multipart/form-data" action="index.php" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
    <input type="file" name="fileToUpload" id="ftu" />
    <input type="submit" value="Ladda upp fil" />
  </form>

<?php

ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
$dbh = new PDO('mysql:host=localhost;dbname=zoo;charset=UTF8;port=8889', 'ZooAdmin', 'animals');

?>

<!-- Filuppladdning -->
<?php
// Slå på all felrapportering. Bra under utveckling, dåligt i produktion.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Kör bara om $_FILES innehåller något 
if ($_FILES) {

    $uploadDir = "temp/";
    $uploadPath = $uploadDir . basename($_FILES['fileToUpload']['name']);

    if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadPath)) {
        echo "Filen är uppladdad";
    } else {
        echo "Något gick fel";
    }
}

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

<body>
  <form action="index.php" method="post">
    <select id="" name='animals'>
      <?php
          foreach ($result as $animal) {
              if ($animal['name'] == $animalSelect) {
                  echo'<option Selected value='.str_replace(' ', '-', $animal['name']).'>'.$animal['name'].'</option>';
              } else {
                  echo '<option value='.str_replace(' ', '-', $animal['name']).'>'.$animal['name'].'</option>';
              }
          }
          ?>
      <input type="submit" value="Search" name="sortByName">
    </select>
  </form>
    <div>
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


</body>
</html>