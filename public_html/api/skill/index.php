<?php

require_once dirname(__DIR__,3) . "/vendor/autoload.php";
require_once dirname(__DIR__,3) . "/php/classes/autoload.php";
require_once dirname(__DIR__,3) . "/php/lib/xsrf.php";

use Edu\Cnm\DeepDiveTutor\{
	Skill,
	Profile
};

/**
 * api for the Skill class
 *
 * @author {} <gdavis42@cnm.edu>
 */

//verify session, start if not active
if(session_status()!==PHP_SESSION_ACTIVE){
	session_start();
}

$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/deepdivetutor.ini");
	// mock a logged in user by mocking the session and assigning a specific user to it.
	//this is only for testing purposes and should not be in live code.
	//$_SESSION["profile"] = Profile::getProfileByProfileId($pdo, 732);

//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//sanitize input
	$skillId = filter_input(INPUT_GET, "skillId", FILTER_VALIDATE_INT);
	$skillName = filter_input(INPUT_GET, "skillName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


	//make sure the id is vallid for methods that require it
	if(($method == "DELETE" || $method === "PUT") && (empty($skillId) === true || $skillId < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}



//handle GET request - if id is present, that tweet is returned, otherwise all tweets are returned
if ($method==="GET"){
	setXsrfCookie ();
	//get a specific skillName and update reply
	if(empty($skillId)===false){
		$
	}
	}
}