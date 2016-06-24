<?php //Search for all movies that a given actor was in.
require_once("common.php");
require_once("top.html");

if (actor_found()) { //If something goes wrong, error reporting happens in function.
	$query = /*Find all movies the actor was in.*/"
	SELECT m.name, m.year
		FROM actors a
			JOIN roles r ON r.actor_id = a.id
			JOIN movies m ON m.id = r.movie_id
		WHERE a.id = :actor_id;
		";
	$stmt = $db->prepare($query);	//Prepare SQL Template into a Statement
	$stmt->bindParam(":actor_id", $actor_id, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll();
	?>
		<h1>Results for <?= $actor_name ?></h1>
		<table>
			<caption>Films with <?= $actor_name ?></caption>
	<?php
	create_table_rows($rows);
}

require_once("bottom.html");
?>