<?php
//to test the db.php connection file

//require db library
require_once 'db.php';

$pdo = db::pdo();/*
var_dump($pdo);*/

$query = "
    SELECT *
    FROM `country` 
    WHERE `country`.`Continent` = ?
";
/*
$query = "
    SELECT *
    FROM `country` 
    WHERE `country`.`Continent` = ?
";
$statement = db::query($query); this will just output the query
above should display no errors and the PDOStatement
*/

$statement = db::query($query, ['Europe']);

var_dump($statement);
//$statement is an object so we have to fetch the information
$data = $statement->fetchAll();
/*the for each way!!!
foreach($data as $country)
{
    echo $country['Name'].'<br>';
}*/
?>

<html>
<style>
    body{
        display:flex;
    }
.box
{
 
 width:180px;
 
 }

</style>
<body>
<h1>European Countries</h1>
<ul>
    <?php foreach($data as $country) : ?>
    <li><?php echo '<div class="box">'.$country['Name']. 

    '<br> Population : ' .
     round($country['Population']/1000000,2) .

     'M<br><br></div>'; ?></li>
    <?php endforeach ?>
</ul>
</body>
</html>
