<?php //Search for all movies that a given actor was in with Kevin Bacon.
require_once("common.php");
require_once("top.html");

if (actor_found()) { //If something goes wrong, error reporting happens in function.
	$tmpl = /*Find Kevin Bacon's primary key.*/"
	SELECT id
	FROM actors
	WHERE last_name = 'Bacon'
		AND first_name LIKE 'Kevin%'
	ORDER BY film_count DESC, id
	LIMIT 1;
	";
	$stmt = $db->prepare($tmpl);	//Prepare SQL Template into a Statement
	$stmt->execute();
	$rows = $stmt->fetchAll();
	foreach ($rows as $row) {
		$kevin_id = $row["id"];
	}

	$query = /*Find all movies the actor was in with Kevin Bacon.*/"
	SELECT m.name, m.year
		FROM actors a
			JOIN roles r ON r.actor_id = a.id
			JOIN movies m ON m.id = r.movie_id
			JOIN roles rk ON rk.movie_id = m.id AND rk.actor_id = :kevin_id
		WHERE a.id = :actor_id;
		";
	$stmt = $db->prepare($query);	//Prepare SQL Template into a Statement
	$stmt->bindParam(":actor_id", $actor_id, PDO::PARAM_INT);
	$stmt->bindParam(":kevin_id", $kevin_id, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll();
	if (empty($rows)) {
		?>
		<h1><?= $actor_name ?> has not been in any movies with Kevin Bacon.</h1>
<?php } else { ?>
		<h1>Results for <?= $actor_name ?></h1>
		<table>
			<caption>Films with <?= $actor_name ?> and Kevin Bacon</caption>
		<?php
		create_table_rows($rows);
	}
}

require_once("bottom.html");
?>