<?php require_once("top.html"); ?>

<!-- a page with a form that the user can use to sign up for a new account -->
<form action="signup-submit.php" enctype="multipart/form-data" method="post">
	<fieldset>
		<legend>Returning User:</legend>
		<ul>
			<li><label><strong>Name:</strong>
			<input name="name" size="16" required="required" /></label></li>

			<li><strong>Gender:</strong>
			<label><input type="radio" name="gender" value="M" />Male</label>
			<label><input type="radio" name="gender" value="F" checked="checked" />Female</label></li>

			<li><label><strong>Age:</strong>
			<input name="age" size="6" maxlength="2" required="required" /></label></li>

			<li><label><strong>Personality type:</strong>
			<input name="personality_type" size="6" maxlength="4" required="required" /></label>
			(<a href="http://www.humanmetrics.com/cgi-win/JTypes2.asp">Don't know your type?</a>)</li>

			<li><strong>Favorite OS:</strong>
			<select name="operating_system">
				<option>Windows</option>
				<option>Mac OS X</option>
				<option>Linux</option>
			</select></li>

			<li><strong>Seeking age:</strong>
			<input name="min_seeking_age" size="6" maxlength="2" placeholder="min" required="required" /> to
			<input name="max_seeking_age" size="6" maxlength="2" placeholder="min" required="required" /></li>

			<li><strong>Photo:</strong>
			<input type="file" name="photo" accept="image/*" required="required" ></li>
		</ul>

		<input type="submit" value="Sign Up" />
	</fieldset>
</form>

<?php require_once("bottom.html"); ?>