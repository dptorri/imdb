<?php
include 'navbar.php';
$genre_description ='';
switch ($genre[0]) {
            case 'Thriller':
            $genre_description = "i equals 0";
                break;
            case 'Drama':
                $genre_description = '<p> i equals 1</p>';
                break;
            case 2:
            $genre_description = "i equals 2";
                break;
        }
        ?>