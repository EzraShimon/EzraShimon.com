<?php require_once("top.html"); ?>

<!-- a page with a form for existing users to log in and check their dating matches -->
<form action="matches-submit.php">
	<fieldset>
		<legend>Returning User:</legend>
			<label><h1><strong>Name:</strong><input name="name" size="16" /></label></h1>
			<input type="submit" value="View My Matches" />

	</fieldset>
</form>

<?php require_once("bottom.html"); ?>