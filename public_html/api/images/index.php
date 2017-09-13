<?php

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\DeepDiveTutor\ {
	Profile
};

/**
 * Cloudinary API for Images
 *
 * @author Jack Reuter
 * @version 1.0
 */

// prepare an empty reply
$reply = new StdClass();
$reply->status = 200;
$reply->data = null;

try {

	// start session
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}

	// Grab the MySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/deepdivetutor.ini");

	// profile id of profile to use for testing
	// $person = 64;

	// grab a profile by its profileId and add it to the session
	// $_SESSION["profile"] = Profile::getProfileByProfileId($pdo, $person);

	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	$config = readConfig("/etc/apache2/capstone-mysql/deepdivetutor.ini");
	$cloudinary = json_decode($config["cloudinary"]);
	\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, "api_key" => $cloudinary->apiKey, "api_secret" => $cloudinary->apiSecret]);

	// handle the POST request
	if($method === "POST") {
		// set XSRF token
		setXsrfCookie();

		// verify user is logged into their profile before uploading an image
		if(empty($_SESSION["profile"]) === true) {
			throw (new \InvalidArgumentException("you are not allowed to access this profile", 403));
		}


		// assigning variable to the user profile, add image extension
		$tempUserFileName = $_FILES["image"]["tmp_name"];

		// upload image to cloudinary and get public id
		$cloudinaryResult = \Cloudinary\Uploader::upload($tempUserFileName, array("width" => 500, "crop" => "scale"));

		// after sending the image to Cloudinary, create a new image
		$profile = Profile::getProfileByProfileId($pdo, $_SESSION["profile"]->getProfileId());
		$profile->setProfileImage($cloudinaryResult["secure_url"]);
		$profile->update($pdo);

		$reply->message = "Image uploaded Ok";

	}

} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-Type: application/json");
// encode and return reply to front end caller
echo json_encode($reply);
