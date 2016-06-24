<?php include("top.html"); 
	  include("common.php"); ?>

		<!--
			This is the page that receives data submitted by signup.php and signs up the new user.

			Implementation Note: I intentionally chose not to reoreder the matches to be in alphabetical order because debugging is much easier without doing that, and the only practicals reason to do that would be data management and showing users their matches in alphabetical order.  But in the real world, this data would be kept in an SQL database, ant it would be sorted upon being retrieved from the database if necessary.
		-->

<?php
//For each field, if it does not validate, print out a relevant error message.
if (preg_match("/[1-9]?\d/", $_POST["age"]) !== 1) { ?>
		<h1>"Please go back and enter a valid age!"</h1>
<?php } else if (preg_match("/[EI][NS][FT][JP]/", $_POST["personality_type"]) !== 1) { ?>
		<h1>"Please go back and enter a valid personality type!"</h1>
<?php } else if (preg_match("/[1-9]?\d/", $_POST["min_seeking_age"]) !== 1) { ?>
		<h1>"Please go back and enter a valid miniumum acceptable match age!"</h1>
<?php } else if (preg_match("/[1-9]?\d/", $_POST["max_seeking_age"]) !== 1) { ?>
		<h1>"Please go back and enter a valid maximum acceptable match age!"</h1>
<?php } else if (name_in_system($_POST["name"])) { ?>
		<h1>Your account already exists!  Please <a href="matches.php">log in to see your matches!</a></h1>
<?php
} else {

//After the fields validate, append the new match to the list of singles.
	file_put_contents("singles.txt", $_POST["name"] . "," . $_POST["gender"] . "," . $_POST["age"] . "," . $_POST["personality_type"] . "," . $_POST["operating_system"] . "," . $_POST["min_seeking_age"] . "," . $_POST["max_seeking_age"] . "\n", FILE_APPEND);
	move_uploaded_file($_FILES["photo"]["tmp_name"], "images/" . str_replace(" ", "_", strtolower($_POST["name"])) . ".jpg");
	chmod("images/" . name_of_profile_picture($_POST["name"]), 0777);
?>

		<h1>Thank you!</h1>

		<p>Welcome to NerdLuv, <?= $_POST["name"] ?>!</p>

		<p>Now <a href="matches.php">log in to see your matches!</a></p>

<?php } ?>

<?php include("bottom.html"); ?>