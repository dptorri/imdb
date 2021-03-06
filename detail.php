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
`imdb_movie`.`votes_nr` AS `movie_votes`,
`imdb_movie`.`year`,
`imdb_movie`.`rating` AS `movie_rating`,
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
<?php require 'navbar.php';
echo $navbar; ?>

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
                    <li><h2 style="margin:0px 0px 0px 0px;">Rating :<?php echo $value['movie_rating']; ?><i class="fa fa-thermometer-full" aria-hidden="true"></i></h2></li>
                    <li><h5 style="margin:0px 0px 0px 0px;">based on <?php echo number_format($value['movie_votes']).' votes'; ?><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></h5></li>
                    <li><img class="logos" src="img/imdb.png" alt="go to IMDB"> <a href=" <?php echo 'http://www.imdb.com/title/tt' . $name . '/?ref_=nv_sr_1'; ?>">more info...<?php //echo $value['rating'];?></a></li>
                    <li>Title :<?php $movie_name = $value['movie_name']; echo $value['movie_name']; ?></li>
                    <li>Year : <?php echo $value['year']; ?></li>
                    <li>Type :<?php echo $value['movie_type']; ?></li>
                    <li>Certification :<?php if($value['certification']==null){echo 'Not Rated';}echo $value['certification']; ?></li>
                    <li> Status :<?php if($imdb_movie['status']== null){echo 'completed';} echo $imdb_movie['status'];?></li>

                    <?php endforeach; ?>
                    <?php 
                    $query="
                    SELECT  `imdb_genre`.`name`
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
                   ORDER BY `imdb_movie_has_genre`.`priority` 
                    ";
               
                    $statement = db::query($query, [$name]);
                    $data = $statement->fetchAll();
                    
                    
                     echo '<li>Genre :';
                         if($data[0][0]!==null){
                            for($i=0;$i<count($data);$i++){
                                for($j=0;$j<count($data[$i]);$j++){
                                   
                                    if(isset($data[$i][$j])){echo '<a  href="/imdb/genres/'.$data[$i][$j].'.php">['.$data[$i][$j].']</a>';};
                                    
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
                    
                    <li><img class="logos" src="img/tomato.png" alt="go to RottenTomatoes"> <a href="https://www.rottentomatoes.com/m/the_wolf_of_wall_street_2013/"></a></li>
                    -->
                    <li><a href=<?php echo '"https://www.amazon.com/s/ref=nb_sb_noss?url=search-alias%3Dmovies-tv&field-keywords='.$movie_name.'"><img style="border:1px solid grey;width:60px;height:30px;"src="img/amazon.png" alt=""> <span>Shop in Amazon</span></img>';?></a></li>
                </ul>
                
            </div>
            <div class="movie-plot">
                    <p><?php include 'plot.php'; 
                    if(isset($plot[$name]))
                    {echo $plot[$name];} 
                    else {echo $plot[0];}?></p>
                </div>
                        
            </section>
        </div>  
       
        <div id="cast-list" class="cast-details">

            <section class="c-details">
            <div class="cast-list">

            <?php //HANDLES THE CAST DATA!!!!
                    $query="
                    SELECT  
                    `imdb_movie_has_person`.`priority`,
                    `imdb_movie_has_person`.`description`,
                    `imdb_person`.`fullname`,
                    `imdb_position`.`label`,
                    `imdb_position`.`id`,
                    `imdb_person`.`imdb_id` AS `person_id`
                    FROM `imdb_movie`
                    LEFT JOIN
                    `imdb_movie_has_person`
                    ON
                    `imdb_movie_has_person`.`imdb_movie_id`=`imdb_movie`.`imdb_id`
                    LEFT JOIN
                    `imdb_person`
                    ON 
                    `imdb_person`.`imdb_id`=`imdb_movie_has_person`.`imdb_person_id`
                    
                    LEFT JOIN
                    `imdb_position`
                    ON 
                    `imdb_position`.`id`=`imdb_movie_has_person`.`imdb_position_id`
                    WHERE `imdb_movie`.`imdb_id`=  ?
                    ORDER BY  `imdb_movie_has_person`.`priority` DESC 
                    LIMIT 5
                    ";
               
                    $statement = db::query($query, [$name]);
                    $data = $statement->fetchAll();
                    if($data[0]['person_id']==null){
                    
                        $data[0][0] = 'to be updated :)';
                        $data[0][1] = 'to be updated :)';
                        $data[0][2] = 'to be updated :)';
                        $data[0][3] = 'to be updated :)';
                        $data[0][4] = 'to be updated :)';
                        $data[0][5] = 'to be updated :)';
                        }
                    
                                        ?>

                    <table>
                        <tr>
                            <th>Cast</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td><a href="http://www.imdb.com/name/nm<?php echo $data[0]['person_id'];?>/?ref_=fn_al_nm_1"><?php echo $data[0]['fullname']; ?></a></td>
                            <td><?php echo $data[0]['description']; ?></td>
                        </tr>
                        <tr>
                            <td><a href="http://www.imdb.com/name/nm<?php echo $data[1]['person_id'];?>/?ref_=fn_al_nm_1"><?php echo $data[1]['fullname']; ?></a></td>
                            <td><?php echo $data[1]['description']; ?></td>
                        </tr>
                        <tr>
                            <td><a href="http://www.imdb.com/name/nm<?php echo $data[2]['person_id'];?>/?ref_=fn_al_nm_1"><?php echo $data[2]['fullname']; ?></a></td>
                            <td><?php echo $data[2]['description']; ?></td>
                        </tr>
                        <tr>
                            <td><a href="http://www.imdb.com/name/nm<?php echo $data[3]['person_id'];?>/?ref_=fn_al_nm_1"><?php echo $data[3]['fullname']; ?></a></td>
                            <td><?php echo $data[3]['description']; ?></td>
                        </tr>
                        <tr>
                                <td>see more...</td>
                                <td>got to page 1 2 3 4 5 ...</td>
                        </tr>
                    </table>
            </div>
            
            <div class="cast-stars">
            <a href="http://www.imdb.com/name/nm<?php echo $data[0]['person_id'];?>/?ref_=fn_al_nm_1"><img class="cast-pic" src="img/<?php echo $data[0]['person_id'];?>.jpg" alt="photo of <?php echo $data[0]['fullname']; ?>"></a>
            <a href="http://www.imdb.com/name/nm<?php echo $data[1]['person_id'];?>/?ref_=fn_al_nm_1"><img class="cast-pic" src="img/<?php echo $data[1]['person_id'];?>.jpg" alt="photo of <?php echo $data[1]['fullname']; ?>"></a>
            <a href="http://www.imdb.com/name/nm<?php echo $data[2]['person_id'];?>/?ref_=fn_al_nm_1"><img class="cast-pic" src="img/<?php echo $data[2]['person_id'];?>.jpg" alt="photo of <?php echo $data[2]['fullname']; ?>"></a>
            <a href="http://www.imdb.com/name/nm<?php echo $data[3]['person_id'];?>/?ref_=fn_al_nm_1"><img class="cast-pic" src="img/<?php echo $data[3]['person_id'];?>.jpg" alt="photo of <?php echo $data[3]['fullname']; ?>"></a>
            </div></section>
            <div id="trailer" class="trailer">
                    <table>
                            <tr>
                <th class="ttitle">Trailer</th>   </tr> </table>
                <div class="video">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/?listType=search&list=<?php echo $movie_name.' Official trailer'; ?>&autoplay=1" frameborder="0" allowfullscreen></iframe></div>
            </div>
            <div id="gallery" class="gallery">
                    <table>
                            <tr>
                <th class="ttitle">Gallery</th>   </tr> </table>
          
                  
    
</body>

</html>