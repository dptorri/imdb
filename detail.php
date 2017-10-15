<?php
require_once 'db.php';

//send the data from the address bar to the $query_string variable
$query_string = ($_SERVER['REQUEST_URI']);

//parse it into an array key and string($url)

parse_str($query_string, $url); 

//return the string of this key

$name = $url['/imdb/detail_php?search'];


$query = "
SELECT 
`imdb_movie`.`imdb_id`,
`imdb_movie`.`year`,
`imdb_movie`.`rating`,
`imdb_movie`.`name` AS `movie_name`,
`imdb_movie_type`.`name` AS `movie_type`,
`imdb_certification`.`label` AS `certification`,
`imdb_movie_status`.`label` AS `status`
FROM `imdb_movie`
LEFT JOIN 
`imdb_movie_type`
ON `imdb_movie_type`.`id`=`imdb_movie`.`imdb_movie_type_id`
LEFT JOIN 
`imdb_certification`
ON `imdb_certification`.`id`=`imdb_movie`.`imdb_certification_id`
LEFT JOIN 
`imdb_movie_status`
ON `imdb_movie_status`.`id`=`imdb_movie`.`imdb_movie_status_id`
WHERE `imdb_movie`.`imdb_id`= ?";
$statement = db::query($query, [$name]);
$data = $statement->fetchAll();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie Matic Plus</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container-column">
        <ul class="sidenav">
            <li><a class="active" href="index_.php">Home</a></li>
            <li><a href="#cast-list ">Cast</a></li>
            <li><a href="#trailer">Trailer</a></li>
            <li><a href="#gallery">Gallery</a></li>
          </ul>
        <!-- ends nav-bar -->
        <div class="movie-details">
            <section class="m-details">
                <div class="movie-poster">
                    <img class="poster" src="<?php echo "img/" . $name . ".jpg"; ?>" alt="Poster">
                    <div id="socialbar" class="a2a_kit a2a_kit_size_32 a2a_floating_style a2a_vertical_style" style="right:0px; top:150px;">
                        <a class="a2a_button_facebook"></a>
                        <a class="a2a_button_twitter"></a>
                        <a class="a2a_button_google_plus"></a>
                        <a class="a2a_button_pinterest"></a>
                        <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                    </div>
                    
                    <script async src="https://static.addtoany.com/menu/page.js"></script>
                   </div>
                   <div class="movie-score">
                <ul>
                    <?php foreach($data as $imdb_movie => $value) : ?>
                    <li>Title :<?php echo $value['movie_name']; ?></li>
                    <li>Year : <?php echo $value['year']; ?></li>
                    <li>Type :<?php echo $value['movie_type']; ?></li>
                    <li>Certification :<?php if($value['certification']==null){echo 'Not Rated';}echo $value['certification']; ?></li>
                    <li> Status :<?php if($imdb_movie['status']== null){echo 'completed';} echo $imdb_movie['status'];?></li>
                    <?php endforeach; ?>
                    <?php 
                    $query="
                    SELECT
                    
                    `imdb_genre`.`name`
                    
                    FROM `imdb_movie`
                    LEFT JOIN
                    `imdb_movie_has_genre`
                    ON
                    `imdb_movie_has_genre`.`imdb_movie_id`=`imdb_movie`.`imdb_id`
                    
                    LEFT JOIN
                    `imdb_genre`
                    ON 
                    `imdb_genre`.`id`=`imdb_movie_has_genre`.`imdb_genre_id`
                   WHERE `imdb_movie`.`imdb_id`=  ?
                    ";
               
                    $statement = db::query($query, [$name]);
                    $data = $statement->fetchAll();
                    
                    
                     echo '<li>Genre :';
                         if($data[0][0]!==null){
                            for($i=0;$i<count($data);$i++){
                                for($j=0;$j<count($data[$i]);$j++){
                                    if(isset($data[$i][$j])){echo '['.$data[$i][$j].']';};
                                    
                                }
                            }
                        } else {echo '[unclassified]';}
                         echo '</li>';
                         ?>
                        <!--
                    <li>Language :<?php //echo $imdb_movie['movie_type']; ?></li>
                    <li>Country origin :<?php// echo $value['country_origin']; ?></li>
                    <li>Director :<?php// echo $imdb_movie['movie_type']; ?></li>
                    
                    <li><img class="logos" src="img/metacritic.png" alt="go to metacritic"> <a href="http://www.metacritic.com/g00/movie/the-wolf-of-wall-street?i10c.encReferrer="></li>
                    <li><img class="logos" src="img/imdb.png" alt="go to IMDB"> <a href=" <?php echo 'http://www.imdb.com/title/tt' . $name . '/?ref_=nv_sr_1'; ?>">Rating IMDB <?php //echo $value['rating'];?></a></li>
                    <li><img class="logos" src="img/tomato.png" alt="go to RottenTomatoes"> <a href="https://www.rottentomatoes.com/m/the_wolf_of_wall_street_2013/"></a></li>
                    
                </ul>
            </div>
            <div class="movie-plot">
                    <p>Here a movie plot please!</p>
                </div>
            
            </section>
        </div>
       
        <div id="cast-list" class="cast-details">

            <section class="c-details">
            <div class="cast-list">
                    <table>
                        <tr>
                            <th>Cast</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td><a href="http://www.imdb.com/name/nm0000138/?ref_=fn_al_nm_1">Leonardo DiCaprio</a></td>
                            <td>Jordan Belfort</td>
                        </tr>
                        <tr>
                            <td><a href="http://www.imdb.com/name/nm1706767/?ref_=tt_cl_t2">Jonah Hill</a></td>
                            <td>Donnie Azoff</td>
                        </tr>
                        <tr>
                            <td> <a href="http://www.imdb.com/name/nm3053338/?ref_=tt_cl_t3">Margot Robbie</a></td>
                            <td>Naomi Lapaglia</td>
                        </tr>
                        <tr>
                            <td><a href="http://www.imdb.com/name/nm0000190/?ref_=tt_cl_t4">Matthew McConaughey</a></td>
                            <td>Mark Hanna</td>
                        </tr>
                        <tr>
                                <td>see more...</td>
                                <td>got to page 1 2 3 4 5 ...</td>
                        </tr>
                    </table>
            </div>
            <div class="cast-stars">
                <a href="http://www.imdb.com/name/nm0000138/?ref_=fn_al_nm_1"><img class="cast-pic" src="img/a_1.jpg" alt="photo of Leonardo DiCaprio"></a>
                <a href="http://www.imdb.com/name/nm1706767/?ref_=tt_cl_t2"><img class="cast-pic" src="img/a_2.jpg" alt="photo of Jonah Hill"></a>
                <a href="http://www.imdb.com/name/nm3053338/?ref_=tt_cl_t3"><img class="cast-pic" src="img/a_3.jpg" alt="photo of Margot Robbie"></a>
                <a href="http://www.imdb.com/name/nm0000190/?ref_=tt_cl_t4"><img class="cast-pic" src="img/a_4.jpg" alt="photo of Matthew McConaughey"></a>
            </div></section>
            <div id="trailer" class="trailer">
                    <table>
                            <tr>
                <th class="ttitle">Trailer</th>   </tr> </table>
                <div class="video">
                        <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/pabEtIERlic?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe></div>
            </div>
            <div id="gallery" class="gallery">
                    <table>
                            <tr>
                <th class="ttitle">Gallery</th>   </tr> </table>
                    <div id="myCarousel" class="carousel slide" data-ride="carousel" style="margin-top:3px;margin-left: auto;margin-right: auto;max-width:600px;">
                     
                      <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                        <li data-target="#myCarousel" data-slide-to="3"></li>
                        <li data-target="#myCarousel" data-slide-to="4"></li>
                      </ol>
                  
                        <div class="carousel-inner">
                        <div class="item active">
                          <img src="https://images-na.ssl-images-amazon.com/images/M/MV5BMjA4NjQ5MDI2MV5BMl5BanBnXkFtZTgwNjg0MzQ4MDE@._V1_SX1500_CR0,0,1500,999_AL_.jpg" alt="Margot Robbie" style="max-width:600px;">
                        </div>
                  
                        <div class="item">
                          <img src="https://images-na.ssl-images-amazon.com/images/M/MV5BMjA5ODI4NTEwNl5BMl5BanBnXkFtZTgwNzg0MzQ4MDE@._V1_SX1500_CR0,0,1500,999_AL_.jpg" alt="FBI Agents" style="max-width:600px;">
                        </div>
                      
                        <div class="item">
                          <img src="https://images-na.ssl-images-amazon.com/images/M/MV5BMTY5NzU3OTg4NV5BMl5BanBnXkFtZTgwMTc0MzQ4MDE@._V1_SX1500_CR0,0,1500,999_AL_.jpg" alt="Teddy Bear" style="max-width:600px;">
                        </div>

                        <div class="item">
                                <img src="https://images-na.ssl-images-amazon.com/images/M/MV5BMTQ3OTc1OTQ0NV5BMl5BanBnXkFtZTgwNzUyOTg2MDE@._V1_SX1500_CR0,0,1500,999_AL_.jpg" alt="Smuggling Money" style="max-width:600px;">
                              </div>
                              <div class="item">
                                    <img src="https://images-na.ssl-images-amazon.com/images/M/MV5BNTMyMzE4NzA4N15BMl5BanBnXkFtZTgwNzY3NTIxMDE@._V1_SX1500_CR0,0,1500,999_AL_.jpg" alt="Pool Party" style="max-width:600px;">
                                  </div>


                      </div>

                      
                  
                 
                      <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                      </a> -->
                    </div>
                  </div>
                 
        </div>
    </div>
    
</body>

</html>