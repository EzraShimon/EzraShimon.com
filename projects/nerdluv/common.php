<?php
//A set of common functions that are reused in several pages.

//Return true if a user with the given name is already in the system, and false otherwise.
function name_in_system($name)
{
	if (isset($name)) {
		foreach (file("singles.txt", FILE_IGNORE_NEW_LINES) as $match) {
			if (strstr($match, $name)) {
				return true;
			}
		}
	}
	return false;
}

//Return the name of a given user's profile picture.
function name_of_profile_picture($name)
{
	return str_replace(" ", "_", strtolower($name)) . ".jpg";
}

//Return the location of the image for the given user.
function image_location($name)
{
	if (is_file("images/" . name_of_profile_picture($name))) {
		return "images/" . name_of_profile_picture($name);
	}
	else {
		return "http://www.cs.washington.edu/education/courses/cse190m/12sp/homework/4/images/" . name_of_profile_picture($name);
	}
}