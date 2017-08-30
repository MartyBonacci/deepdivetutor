<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\DeepDiveTutor\{
	Skill
};

/**
 *
 * api for the skill class
 * @author Gdavis@cnm.edu
 *
 */
//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/deepdivetutor.ini");
	// mock a logged in user by mocking the session and assigning a specific user to it.
	//this is only for testing purposes and dhould not be in the live code.
	//$_SESSION["profile"] =$Profile::getProfileByProfileId($pdo, 732);

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "skillId", FILTER_VALIDATE_INT);


	if($method === "GET") {
//set xsrf cookie
		setXsrfCookie();

		//get a specific skillname based on SkillID and update reply
		if(empty ($id) === false) {
			$skill = Skill::getSkillNameBySkillId($pdo, $id);
			if($skill !== null) {
				$reply->data = $skill;
			}
		}
		//Get All SkillNames and update reply
		else {
			$skills = Skill::getAllSkillNames($pdo)->toArray();
			if($skills !== null) {
				$reply->data = $skills;
			}
		}
	}

} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type:application/json");
if($reply->data === null) {
	unset($reply->data);
}
//encodes json
echo json_encode($reply);