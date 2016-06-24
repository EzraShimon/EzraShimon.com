<?php
require_once("common.php");
require_once("top.html");
?>

<!-- the page that receives data submitted by matches.php and show's the user's matches -->
<?php if (!name_in_system($_GET["name"])) { ?>
		<h1>Your account was not found!  Please make go back and make sure you have spelled your name correctly, or <a href="signup.php">create an account</a>.</h1>
<?php
} else {
	foreach (file("singles.txt", FILE_IGNORE_NEW_LINES) as $match) {
		list($user_name, $user_gender, $user_age, $user_personality_type, $user_operating_system, $user_min_seeking_age, $user_max_seeking_age) = explode(",", $match);
		if ($_GET["name"] === $user_name) {
			break;
		}
	}
	?>

		<h1>Matches for <?= $_GET["name"] ?></h1>

	<?php
	foreach (file("singles.txt", FILE_IGNORE_NEW_LINES) as $match) {
		list($name, $gender, $age, $personality_type, $operating_system, $min_seeking_age, $max_seeking_age) = explode(",", $match);
		if($gender !== $user_gender && $age >= $user_min_seeking_age && $age <= $user_max_seeking_age && $user_age >= $min_seeking_age && $user_age <= $max_seeking_age && $operating_system === $user_operating_system && ($personality_type[0] === $user_personality_type[0] || $personality_type[1] === $user_personality_type[1] || $personality_type[2] === $user_personality_type[2] || $personality_type[3] === $user_personality_type[3])) {
		?>
		<div class="match">
			<p>
				<img src=<?= image_location($name) ?> alt="profile picture">
				<?= $name ?>
			</p>

			<ul>
				<li><strong>gender:</strong><?= $gender ?></li>
				<li><strong>age:</strong><?= $age ?></li>
				<li><strong>type:</strong><?= $personality_type ?></li>
				<li><strong>OS:</strong><?= $operating_system ?></li>
			</ul>
		</div>
		<?php
		}
	}
}
?>

<?php include("bottom.html"); ?>