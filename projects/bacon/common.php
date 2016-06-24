<?php //Variables and Functions used by both search-all.php and search-kevin.php.

require_once("password.php");

$db = new PDO("mysql:dbname=imdb", "hw5", $password);
$actor_name = $_GET["firstname"] . " " . $_GET["lastname"];
$actor_id;

//If the actor is found set $actor_id and return true, otherwise output an error message and return false.
function actor_found() {
	global $db;
	$tmpl = /*Find the id of the actor being searched*/"
	SELECT id
	FROM actors
	WHERE last_name = :last_name
		AND first_name LIKE concat(:first_name, '%')
    LIMIT 1;
	";
	$stmt = $db->prepare($tmpl);	//Prepare SQL Template into a Statement
	if (!($stmt->bindParam(":last_name", $_GET["lastname"], PDO::PARAM_STR, 70))) {
		?>
		<h1>There was a problem with the last name that you entered.  Please go back and correct it.</h1>
<?php } else if (!($stmt->bindParam(":first_name", $_GET["firstname"], PDO::PARAM_STR, 70))) { ?>
		<h1>"There was a problem with the first name that you entered.  Please go back and correct it."</h1>
		<?php
	}
	else {
		$stmt->execute();
		$rows = $stmt->fetchAll();
		foreach ($rows as $row) {
			global $actor_id;
			$actor_id = $row["id"];
			return true;
		}
	}
	?>
	<h1><?= $GLOBALS["actor_name"] . " not found." ?></h1>
	<?php
	return false;
}

//Input is the rows already calculated from an SQL statement.  Output this as rows in our already existing table, and close the table.
function create_table_rows($rows) {
	$i = 1;
	?>
			<tr><th>#</th> <th>Title</th> <th>Year</th></tr>
<?php foreach ($rows as $row) { ?>
			<tr><td><?= $i ?></td> <td><?= $row["name"] ?></td> <td><?= $row["year"] ?></td></tr>
		<?php
		$i++;
	}
	?>
		</table>
	<?php
}
