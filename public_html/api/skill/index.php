<?php
require_once dirname(__DIR__, 3). "/vendor/autoload.php";
require_once dirname(__DIR__, 3). "/php/classes/autoload.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\DeepDiveTutor\{
	Skill
};

/**
 *
 * api for the Tweet class
 * @author Gdavis@cnm.edu
 *
 */

if(session_Status() !== PHP_SESSION_ACTIVE){
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status=200;
$reply->data = null;

try{
	//grab the mySQL connection
	$pdo =connectToEncryptedMySQL("/etc/apache@/capstone-mysql/deepdivetutor.ini");
	// mock a logged in user by mocking the session and assigning a specific user to it.
	//this is only for testing purposes and dhould not be in the live code.
	//$_SESSION["profile"] =$Profile::getProfileByProfileId($pdo, 732);

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"]: $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$skillId =filter_input(INPUT_GET,"skillId", FILTER_VALIDATE_INT);

}
