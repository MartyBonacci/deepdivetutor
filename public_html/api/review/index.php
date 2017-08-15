<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("etc/apache2/capstone-mysql/encrypted-config.php");

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
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
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
		if(empty($id) === false) {
			$review = Review::getReviewByReviewId($pdo, $id);
			if($review !== null) {
				$reply->data = $review;
			}
		} else if(empty($reviewProfileId) === false) {
			$reviews = Review::getReviewByReviewStudentProfileId($pdo, $reviewStudentProfileId)->toArray();
			if($reviews !== null) {
				$reply->data = $review;
			}
		} else if(empty($reviewProfileId) === false) {
			$reviews = Review::getReviewByReviewTutorProfileId($pdo, $reviewTutorProfileId)->toArray();
			if($reviews !== null) {
				$reply->data = $review;
			}
		} else if($method === "PUT" || $method == "POST") {

			//enforce that the user has an XSRF token
			veifyXsrf();

			$requestContent = file_get_contents("php://input");
			//Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
			$requestObject = json_decode($requestContent);
			// This line then decodes the JSON package and stores that result in $requestObject

			//  make sure Id is available
			if(empty($requestObject->id) === true) {
				throw(new \invalidArgumentException ("No Review Id.", 405));
			}

			//  make sure reviewStudentProfileId is available
			if(empty($requestObject->reviewStudentProfileId) === true) {
				throw(new \invalidArgumentException ("No Review Student Profile Id.", 405));
			}

			//  make sure reviewTutorProfileId is available
			if(empty($requestObject->reviewTutorProfileId) === true) {
				throw(new \invalidArgumentException ("No Review Tutor Profile Id.", 405));
			}



		}
		}

	}