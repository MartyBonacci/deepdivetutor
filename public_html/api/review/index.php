<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

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

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/deepdivetutor.ini");

	// profileId of profile to use for testing,
	//$_SESSION = 3;

	// grab a profile by its profileId and add it to the session
	//$_SESSION["profile"] = Profile::getProfileByProfileId($pdo, $person);

	// mock a logged in user by mocking the session and assigning a specefic user to it.
	// this is only for testing purposes and should not be in the live code.
	//$_SESSION["profile"]= 74;

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];


	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	//$reviewId = filter_input(INPUT_GET, "reviewId", FILTER_VALIDATE_INT);
	$reviewStudentProfileId = filter_input(INPUT_GET, "reviewStudentProfileId", FILTER_VALIDATE_INT);
	$reviewTutorProfileId = filter_input(INPUT_GET, "reviewTutorProfileId", FILTER_VALIDATE_INT);
	$reviewRating = filter_input(INPUT_GET, "reviewRating", FILTER_VALIDATE_INT);
	$reviewText = filter_input(INPUT_GET, "reviewText", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

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
		} else if(empty($reviewStudentProfileId) === false) {
			$review = Review::getReviewByReviewStudentProfileId($pdo, $reviewStudentProfileId)->toArray();
			if($review !== null) {
				$reply->data = $review;
			}
		} else if(empty($reviewTutorProfileId) === false) {
			$review = Review::getReviewByReviewTutorProfileId($pdo, $reviewTutorProfileId)->toArray();
			if($review !== null) {
				$reply->data = $review;
			}
		}

	} else if($method === "PUT" || $method == "POST") {

		//enforce that the user has an XSRF token
		verifyXsrf();

		$requestContent = file_get_contents("php://input");
		//Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContent);
		// This line then decodes the JSON package and stores that result in $requestObject


		//  make sure reviewStudentProfileId is available
		if(empty($requestObject->reviewStudentProfileId) === true) {
			throw(new \invalidArgumentException ("No Review Student Profile Id.", 405));
		}

		//  make sure reviewTutorProfileId is available
		if(empty($requestObject->reviewTutorProfileId) === true) {
			throw(new \invalidArgumentException ("No Review Tutor Profile Id.", 405));
		}

		// make sure reviewRating is available
		if(empty($requestObject->reviewRating) === true) {
			throw(new \invalidArgumentException ("No Review Rating", 405));
		}

		// make sure review text is available (required field)
		if(empty($requestObject->reviewText) === true) {
			throw(new \InvalidArgumentException ("No text for Review.", 405));
		}

		// make sure tutor can't post or put review
		if ($_SESSION["profile"]->getProfileType() === 1){
			throw(new \InvalidArgumentException ("Silly Tutor Review's are for Student's", 405));
		}

		if ($_SESSION["profile"]->getProfileId() !== $requestObject->reviewStudentProfileId) {
			throw(new \InvalidArgumentException ("Your logged into the wrong account"));
		}

		$tutorProfileType=Profile::getProfileByProfileId($pdo, $requestObject->reviewTutorProfileId);

		// make sure a student can't post or put review for another student
		if ($tutorProfileType->getProfileType() !== 1)  {
			throw(new \InvalidArgumentException ("Silly student you cant review another student", 405));
		}


		// perform the actual put or post
		if($method === "PUT") {

			// retrieve the review to update
			$review = Review::getReviewByReviewId($pdo, $id);
			if($review === null) {
				throw(new RuntimeException("Review does not exist", 404));
			}

			// enforce the user is signed in and only trying to edit their own review
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $review->getReviewStudentProfileId()) {
				throw(new \invalidArgumentException("You are not allowed to edit this review", 403));
			}


			// update all atributes
			//$review->setReviewStudentProfileId($requestObject->reviewStudentProfileId);
			//$review->setReviewTutorProfileId($requestObject->reviewTutorProfileId);
			$review->setReviewRating($requestObject->reviewRating);
			$review->setReviewText($requestObject->reviewText);
			$review->update($pdo, $id);

			// update reply
			$reply->message = "review updated ok";
		} else if($method === "POST") {
			// enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to post reviews", 403));
			}

			// create new review and insert into database
			$review = new Review(null, $_SESSION["profile"]->getProfileId(), $requestObject->reviewTutorProfileId, $requestObject->reviewRating, $requestObject->reviewText, null);
			$review->insert($pdo);

			// update reply
			$reply->message = "review created ok";
		}
	} else if($method === "DELETE") {

		// enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the Review to be deleted
		$review = Review::getReviewByReviewId($pdo, $id);
		if($review === null) {
			throw(new RuntimeException("Review does not exist", 404));
		}

		// enforce the user is signed in and only trying to edit their own review
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $review->getReviewStudentProfileId()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this review", 403));
		}

//		// enforce the user is signed in and only trying to edit their own review
//		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $review->getReviewTutorProfileId()) {
//			throw(new \InvalidArgumentException("You are not allowed to delete this review", 403));
//		}

		// delete review
		$review->delete($pdo);
		// update reply
		$reply->message = "Review deleted Ok";

	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}

	// update the $reply->status $reply->message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);