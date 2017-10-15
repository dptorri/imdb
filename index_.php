<?php
require_once 'db.php';
$query = "
    SELECT *
    FROM `imdb_movie` 
    WHERE `imdb_movie`.`name` LIKE ?
";
/*This handles two errors related with undefined index will assign the value of 'seach' to our php variable */
$namem = isset($_GET['search']) ? $_GET['search'] : null;
//empty()
$namem = !empty($_GET['search']) ? $_GET['search'] : null;

if(($_GET))
    {// global $namem; used when I had undefined index somehow not needed
        $namem = "%".$_GET['search']."%";
        //this helps to get names that start like Superma... in the input text 
    }
//calling the static property db from query I need to find out more about this
$statement = db::query($query, [$namem]);

//var_dump($namem);
//$statement is an object so we have to fetch the information
$data = $statement->fetchAll();

?>

<html>
<style>
</style>

<body><div class="container">
    <div class="search-box">
        <form action="index_.php" method="GET">
            <input type='text' name='search' placeholder="e.g. Die Hard..." />
            <input type='submit'  value='submit' />
        </form>
    </div> 
    <div class="search-result">   
<h1>Search results for: <i><?php echo $namem;?>...</i></h1>
        <ul>
        <?php foreach($data as $imdb_movie) : ?>
        <li> <a href="
        <?php echo 'detail.php?search='.$imdb_movie['imdb_id'];?>">
        <?php echo $imdb_movie['name'].' (' .$imdb_movie['year'] .')<br>'; ?>
        </a></li>
        <?php endforeach ?>
        </ul>
        </div>
    </div>
    <div id="trapezoid">
    <a href="http://home/imdb/detail.php?search=103064"><img class="skew" src="img/103064.jpg" alt=""></a>
    <a href="http://home/imdb/detail.php?search=110912"><img class="skew" src="img/110912.jpg" alt=""></a>
    <a href="http://home/imdb/detail.php?search=317219"><img class="skew" src="img/317219.jpg" alt=""></a>
    <a href="http://home/imdb/detail.php?search=383028"><img class="skew" src="img/383028.jpg" alt=""></a>
    <a href="http://home/imdb/detail.php?search=816692"><img class="skew" src="img/816692.jpg" alt=""></a>
    <a href="http://home/imdb/detail.php?search=993846"><img class="skew" src="img/993846.jpg" alt=""></a>
    <a href="http://home/imdb/detail.php?search=1291584"><img class="skew" src="img/1291584.jpg" alt=""></a>
    <a href="http://home/imdb/detail.php?search=1454029"><img class="skew" src="img/1454029.jpg" alt=""></a>
    <a href="http://home/imdb/detail.php?search=1663202"><img class="skew" src="img/1663202.jpg" alt=""></a>
    <a href="http://home/imdb/detail.php?search=2707408"><img class="skew" src="img/2707408.jpg" alt=""></a>
    <a href="http://home/imdb/detail.php?search=3107288"><img class="skew" src="img/3107288.jpg" alt=""></a>
    </div>
    <?php 
    //send the data from the address bar to the $query_string variable
    if($_SERVER['REQUEST_URI'])
    {
    $query_string = ($_SERVER['REQUEST_URI']);
    //parse it into an array key and string($url)
    $url=[];
    
    parse_str($query_string, $url); 
    //return the string of this key
    $name="";
    if($name){
    $name = $url["/imdb/index__php?search"];
    echo "Just echoing the url keyword : " . $name;}
    //missing if this is a valid $imdb_movie['imdb_id'] then populate the page!!!
    }
    ?>
    <title>
    </title>
    <style>
    body {background: url("img/index.jpg") no-repeat fixed center top #000;}
    .skew {transform: skew(-34deg,     14deg);}
    
img { width:200px; height:200px;}
a {background-color:white;}
    </style>
</body>
</html>
