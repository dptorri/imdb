<?php 
        $query_string = ($_SERVER['REQUEST_URI']);
        $genre = explode("/imdb/genres/",$query_string);
        $genre = implode($genre);
        $genre = str_split($genre,strlen($genre)-4);
        $top_poster = ['24216','29843','40897','43265','56172'];

        //echo $genre[0];
        switch ($genre[0]) {
            case 'Adventure':
            $genre_description = "<p>Adventure films are a genre of film. They typically use their action scenes to display and explore exotic locations in an energetic way</p>";
            $top_poster = ['24216','29843','40897','43265','56172'];
                break;
            case 'Action':
            $genre_description = "<p>Action is a genre in which the protagonist or protagonists end up in a series of challenges that typically include violence, extended fighting, physical feats, and frantic chases. Action films tend to feature a resourceful hero struggling against incredible odds, which include life-threatening situations, a villain, or a pursuit which generally concludes in victory for the hero (though a small number of films in this genre have ended in victory for the villain instead).</p>";
            $top_poster = ['95016','82971','103064','104684','82694'];
                break;
            case 'Thriller':
            $genre_description = "<p>Thriller is a broad genre of literature, film and television, having numerous, often overlapping subgenres. Thrillers are characterized and defined by the moods they elicit, giving viewers heightened feelings of suspense, excitement, surprise, anticipation and anxiety. Successful examples of thrillers are the films of Alfred Hitchcock.</p>";
            $top_poster = ['102926','114369','47396','114814','52357'];
                break;
            case 'Biography':
                $genre_description = '<p>A biographical film, or biopic, is a film that dramatizes the life of a non-fictional or historically-based person or people. Such films show the life of a historical person and the central character\'s real name is used. They differ from films "based on a true story" or "historical drama films" in that they attempt to comprehensively tell a single person\'s life story or at least the most historically important years of their lives.</p>';
                $top_poster = ['108052','268978','81398','86879','358273'];
                

                break;
            case 'Crime':
            $genre_description = '<p>Crime cinema, in the broadest sense, is a cinematic genre inspired by and analogous to the crime fiction literary genre. Films of this genre generally involve various aspects of crime and its detection. Stylistically, the genre may overlap and combine with many other genres, such as drama or gangster film, but also include comedy, and, in turn, is divided into many sub-genres, such as mystery, suspence or noir.</p>';
            $top_poster = ['99685','68646','71562','110912','317248'];
            break;
            case 'Drama':
            $genre_description = '<p>Drama is usually qualified with additional terms that specify its particular subgenre, such as "political drama," "courtroom drama," "historical drama," "domestic drama," or "comedy-drama." These terms tend to indicate a particular setting or subject-matter, or else they qualify the otherwise serious tone of a drama with elements that encourage a broader range of moods.</p>';
            $top_poster = ['73486','109830','137523','50083','120689'];
            break;
            case 'Fantasy':
            $genre_description = '<p>Fantasy belongs to  magic, supernatural events, mythology, folklore, or exotic fantasy worlds. The genre is considered a form of speculative fiction alongside science fiction films and horror films, although the genres do overlap. Fantasy films often have an element of magic, myth, wonder, escapism, and the extraordinary.</p>';
            $top_poster = ['120737','24216','245429','38348','107048'];
            break;

            case 'Romance':
            $genre_description = '<p>Are romantic love stories recorded in visual media for broadcast in theaters and on TV that focus on passion, emotion, and the affectionate romantic involvement of the main characters and the journey that their genuinely strong, true and pure romantic love takes them through dating, courtship or marriage.</p>';
            $top_poster = ['332280','98635','314331','1041829','98258'];
            break;

            
            case 'Sci-Fi':
            $genre_description = '<p>Science fiction film (or sci-fi) is a genre that uses speculative, fictional science-based depictions of phenomena that are not fully accepted by mainstream science, such as extraterrestrial lifeforms, alien worlds, extrasensory perception and time travel, along with futuristic elements such as spacecraft, robots, cyborgs, interstellar travel or other technologies.</p>';
            $top_poster = ['83658','62622','76759','78748','63442'];
            break;

            case 'Mystery':
            $genre_description = '<p>Mystery film is a genre of film that revolves around the solution of a problem or a crime. It focuses on the efforts of the detective, private investigator or amateur sleuth to solve the mysterious circumstances of an issue by means of clues, investigation, and clever deduction.</p>';
            $top_poster = ['167404','1375666','209144','54215','387564'];
            break;

            
            

        }
$navbar = '
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
            <li><a class="active" href="..\..\imdb\index_.php">Home</a></li>
            <li><a href="#top">Top 5 '.$genre[0].' Films</a></li>
          </ul>
        <!-- ends nav-bar -->
          
        <h1>Film Genres</h1>
        <p>A film genre is a motion picture category based on similarities in either the narrative elements or the emotional response to the film. Most theories of film genre are borrowed from literary genre criticism. The basic genres include:
        <a href="Action.php">Action</a>
        <a href="Adventure.php">Adventure</a>,
        <a href="Biography.php">Biography</a>,
        <a href="Crime.php">Crime</a>,
        <a href="Drama.php">Drama</a>,
        <a href="Fantasy.php">Fantasy</a>,
        <a href="Romance.php">Romance</a>


        </p>
        <h1>'.$genre[0].
        '</h1><div id="top" class="info"><p>'.
        $genre_description.'</p></div><div class="top-ten"><h2>Top 5 '.
        $genre[0].' Films </h2>
        <a href="../../imdb/detail.php?search='.$top_poster[0].'"><img src="../img/'.$top_poster[0].'.jpg"></img></a>
        <a href="../../imdb/detail.php?search='.$top_poster[1].'"><img src="../img/'.$top_poster[1].'.jpg"></img></a>
        <a href="../../imdb/detail.php?search='.$top_poster[2].'"><img src="../img/'.$top_poster[2].'.jpg"></img></a>
        <a href="../../imdb/detail.php?search='.$top_poster[3].'"><img src="../img/'.$top_poster[3].'.jpg"></img></a>
        <a href="../../imdb/detail.php?search='.$top_poster[4].'"><img src="../img/'.$top_poster[4].'.jpg"></img></a>'; ?>
       