<!-- hej -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<h1>Detta är vårat zoo</h1>

<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

$dbh = new PDO('mysql:host=localhost;dbname=zoo;charset=UTF8;port=8889', 'ZooAdmin', 'animals');
$query = "SELECT * FROM zoo.animals";
foreach ($dbh->query($query) as $animals) {
echo $animals['name'] . "<br/>";
}
?>

<?php
echo "<select>";
foreach($dbh->query($query) as $animals){
    echo "<option value='$animals'>{$animals['category']}</option>";
};
?>
<?php
echo "<select>";
foreach($dbh->query($query) as $animals){
    echo "<option value='$animals'>{$animals['category']}</option>";
};
?>

</body>
</html>