/**
*Incredible Mobie Database - [MySQL and PHP ]
*
*Notes on the query: There are 2 main difficulties to provide the merge of the tables: 
*    Table: imdb_movie        
*       columns: imdb_id, imdb_movie_type_id, mdb_movie_status_id, name, year, rating   
*    Table: imdb_movie_status columns: id, label, parent_type_id, name
*    Table: imdb_movie_type   columns: id, label, name
*    1)Because the names of the colums are equal, SQL requires you to declare them like this -> more info: *https://snook.ca/archives/sql/selecting_datab
*    2) We are joining more than two tables so we need to use a INNER JOIN and a LEFT OUTER JOIN
*   the id that we compare are the columns from the imdb_movie table to the added tables id's
* the $query variable could get more pass more elements besides name, they should be declared with more ?
* and with commas inside the array
*/
#the long query version

$query= "
SELECT 
m.name                  AS movie_name,
m.imdb_movie_status_id  AS movie_status_id,
m.imdb_movie_type_id    AS movie_type_id,
m.year                  AS movie_year,
m.rating                AS movie_rating
t.id                    AS type_id, 
s.id                    AS status_id,
t.label                 AS type_label,
s.label                 AS status_label,
g.id                    AS genre_id,
g.label                 AS genre_label,
g.namespace             AS genre_name,
FROM
imdb_movie m

LEFT JOIN
imdb_movie_status s     ON s.id=m.imdb_movie_status_id
imdb_movie_type t       ON t.id=m.imdb_movie_type_id
imdb_movie_has_genre hg ON hg.imdb_movie_id=m.imdb_id
imdb_genre g            ON g.id=hg.imdb_genre_id

WHERE imdb_id = ?";
