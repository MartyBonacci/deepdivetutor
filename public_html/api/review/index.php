<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\DeepDiveTutor\ {
	Review,
//only use the profile class for testing purposes
profile
};

/**
 * api for the review class
 *
 * @author tkotalik <tkotalik@cnm.edu>
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare and empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncrptedMySQL("/etc/apache2/capstone-mysql-deepdivetutor.ini");

	// mock a logged in user by mocking the session and assigning a specefic user to it.
	// this is only for testing purposes and should not be in the live code.
	// $_SESSION["profile"] = Profile::getProfileByProfileId($pdo, 732);

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, $id, FILTER_VALIDATE_INT);
	$reviewStudentProfileId = filter_input(INPUT_GET, "reviewStudentProfileId", FILTER_VALIDATE_INT);
	$reviewTutorProfileId = filter_input(INPUT_GET, "reviewTutorProfileId", FILTER_VALIDATE_INT);

	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// handle GET request - if id is present, that review is returned, otherwise all review are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific review or all reviews and update reply
	}

}