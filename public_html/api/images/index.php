<?php

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\DeepDiveTutor\ {
	Profile
};

/**
 * API for Images
 *
 * @author Jack Reuter
 * @version 1.0
 */

if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new StdClass();
$reply->status = 200;
$reply->data = null;

try {
	// Grab the MySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/deepdivetutor.ini");

	/**
	 * Cloudinary API
	 *
	 */

	$config = readConfig("/etc/apache2/capstone-mysql/deepdivetutor.ini");
	$cloudinary = json_decode($config["cloudinary"]);
	\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, "api_key" => $cloudinary->apiKey, "api_security" => $cloudinary->apiSecurity, "api_secret" => $cloudinary->apiSecret]);

	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$imageCloudinaryId = filter_input(INPUT_GET, "imageCloudinaryId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	// make sure id is valid for methods that require it
	if(($method === "DELETE") && (empty($id) === true || $id < 0)) {
		throw (new InvalidArgumentException("Id cannot be empty or negitive", 405));
	}

	// handle the POST request
	if($method === "POST") {
		// set XSRF token
		setXsrfCookie();

		// verify user ids logged into their profile before uploading an image
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $id) {
			throw (new \InvalidArgumentException("you are not allowed to access this profile", 403));
		}

		// assigning variable to the user profile, add image extension
		$tempUserFileName = $_FILES["image"] ["temp_name"];

		// upload image to cloudinary and get public id
		$cloudinaryResult = \Cloudinary\Uploader::upload($tempUserFileName, array("width" => 500, "crop" => "scale"));

		// after sending the image to Cloudinary, create a new image
		$password = "password1234";
		$validSalt = bin2hex(random_bytes(32));
		$validHash = hash_pbkdf2("sha512", $password, $validSalt, 262144);

		$image = new Profile(null, $profileName["Slim Shady"], $profileEmail["slim@shady.com"], $profileType[0],
			$profileGithubToken[null], "Im the real Slim Shady", 999.99, $profileImage[$cloudinaryResult], null,
			null, $validHash, $validSalt);

		$image->insert($pdo);

		$reply->data = $image->getProfileImage();
		$reply->message = "Image uploaded Ok";

	}

} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-Type: application/json");
// encode and return reply to front end caller
echo json_encode($reply);

