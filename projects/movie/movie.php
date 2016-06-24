<?php
/*  Script to generate a movie-rating page based on server-side text files with movie information and reviews.
    Author: Samuel Rosenfeld

    Special Note: I changed the reviews in tmnt2 to be of the form "review1," instead of "review01."  I had a few options for how to deal wth the problem of the files being named inconsistently.  It would have been possible to work around this without changing the file name, but if I was working on a real project, I would want to write a script to change the names of the files instead of running an extra line of code to check the format every time.  This could be done in PHP, and this script could be called each time the website is accessed, but I thought that that would be unecessary for this assignment, considering it would only have ever been executed once, and it would have been executed on my machine before I uploaded my files to your server.
*/
$movie = $_GET ["film"];
list($name, $year, $rating) = file($movie . "/info.txt", FILE_IGNORE_NEW_LINES);
$number_of_reviews = count(glob($movie . "/review*.txt"));
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Rancid Tomatoes</title>
		<meta charset="utf-8" />
		<link href="movie.css" type="text/css" rel="stylesheet" />
        <link href="http://www.cs.washington.edu/education/courses/cse190m/12sp/homework/2/rotten.gif" type="image/gif" rel="shortcut icon" />
	</head>

	<body>
        <div id="banner">
            <img src="http://www.cs.washington.edu/education/courses/cse190m/12sp/homework/2/banner.png" alt="Rancid Tomatoes" />
        </div>

        <h1><?= $name ?> (<?= $year ?>)</h1>
        
        <h1></h1>

        <div id="content">
            <div id="overview">
                <div>
                    <img src=<?= $movie . "/overview.png" ?> alt="general overview" />
                </div>

                <dl>
                    <?php
                    foreach (file($movie . "/overview.txt", FILE_IGNORE_NEW_LINES) as $movie_detail) {
                        list($term, $definition) = explode(":", $movie_detail); ?>
                    <dt><?= $term ?></dt>
                    <dd><?= $definition ?></dd>
                    <?php } ?>
                </dl>
            </div>

            <div id="reviews">
                <div>
                    <?php if ($rating >= 60) { ?>
                    <img src="http://www.cs.washington.edu/education/courses/cse190m/12sp/homework/2/freshbig.png" alt="Fresh" />
                    <?php } else { ?>
                    <img src="http://www.cs.washington.edu/education/courses/cse190m/12sp/homework/2/rottenbig.png" alt="Rotten" />
                    <?php } ?>
                    <?= $rating ?>%
                </div>

                <div class="column">
                    <?php
                    for ($i = 1; $i <= $number_of_reviews; $i++) {
                        list($review, $rating, $name, $affiliation) = file($movie . "/review" . $i . ".txt", FILE_IGNORE_NEW_LINES);
                        ?>

                    <p>
                        <?php if ($rating === "FRESH") { ?>
                        <img src="http://www.cs.washington.edu/education/courses/cse190m/12sp/homework/2/fresh.gif" alt="Fresh" />
                        <?php } else { /* rating === ROTTEN */ ?> 
                        <img src="http://www.cs.washington.edu/education/courses/cse190m/12sp/homework/2/rotten.gif" alt="Rotten" />
                        <?php } ?>
                        <q><?= $review ?></q>
                    </p>
                    <p>
                        <img src="http://www.cs.washington.edu/education/courses/cse190m/12sp/homework/2/critic.gif" alt="Critic" />
                        <?= $name ?><br />
                        <b><?= $affiliation ?></b>
                    </p>

                        <?php
                        if ($i == ceil($number_of_reviews / 2)) { /* I'm not sure why '===' does not work here. */ ?>
                </div>

                <div class="column">
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <p id="footer">(1-<?= $number_of_reviews ?>) of <?= $number_of_reviews ?></p>
        </div>
        
        <ul>
            <?php
            $movies = array();
            foreach (glob('*') as $file) {
                if (is_dir($file)) {
                    $movie = fgets(fopen($file . '/info.txt', 'r'));
                    ?>
            <li><a href="<?= 'movie.php?film=' . $file ?>"><?= $movie ?></a></li>
                    <?php
                }
            }
            ?>
        </ul>
        
        <div>
            <a href="https://webster.cs.washington.edu/validate-html.php"><img src="http://webster.cs.washington.edu/w3c-html.png" alt="Valid HTML5" /></a> <br />
            <a href="https://webster.cs.washington.edu/validate-css.php"><img src="http://webster.cs.washington.edu/w3c-css.png" alt="Valid CSS" /></a>
        </div>
	</body>
</html>
