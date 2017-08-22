<?php

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\DeepDiveTutor\ {
	Profile
};

/**
 * API for Profile
 *
 * @author Jack Reuter
 * @version 1.0
 */

// verify the session; if not active, start it
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// grab the MySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/deepdivetutor.ini");

	$_SESSION = Profile::getProfileByProfileId($pdo, 1);

	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$profileName = filter_input(INPUT_GET, "profileName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileType = filter_input(INPUT_GET, "profileType", FILTER_SANITIZE_NUMBER_INT);
	$profileGithubToken = filter_input(INPUT_GET, "profileGithubToken", FILTER_SANITIZE_STRING);
	$brokeProfileRate = filter_input(INPUT_GET, "profileBrokeRate", FILTER_SANITIZE_NUMBER_FLOAT);
	$loadedProfileRate = filter_input(INPUT_GET, "profileLoadedRate", FILTER_SANITIZE_NUMBER_FLOAT);
	$profileActivationToken = filter_input(INPUT_GET, "profileActivationToken", FILTER_SANITIZE_STRING);


	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();

		// gets a profile by content
		if(empty($id) === false) {
			$profile = Profile::getProfileByProfileId($pdo, $id);

			if($profile !== null) {
				$reply->data = $profile;
			}
		} elseif(empty($profileName) === false) {
			$profile = Profile::getProfileByProfileName($pdo, $profileName);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} elseif(empty($profileEmail) === false) {
			$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} elseif(empty($profileType) === false) {
			$profile = Profile::getProfileByProfileType($pdo, $profileType);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} elseif(empty($profileGithubToken) === false) {
			$profile = Profile::getProfileByProfileGithubToken($pdo, $profileGithubToken);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} elseif(empty($brokeProfileRate) === false) {
			$profile = Profile::getProfileByProfileRate($pdo, $brokeProfileRate, $loadedProfileRate);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} elseif(empty($loadedProfileRate) === false) {
			$profile = Profile::getProfileByProfileRate($pdo, $brokeProfileRate, $loadedProfileRate);
			if($profile !== null) {
				$reply->data = $profile;
			}
		}
	} elseif($method === "PUT") {

		// enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $id) {
			throw(new \InvalidArgumentException("you are not allowed to access this profile", 403));
		}

		// decode the response from the frontend
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// retrieve the profile to be updated
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("profile does not exist", 404));
		}

		if(empty($requestObject->newPassword) === true) {

			// enforce that the XSRF token is present in the header
			verifyXsrf();

			// profile name
			if(empty($requestObject->profileName) === true) {
				throw(new \InvalidArgumentException("No profile name", 405));
			}

			// profile email is a required field
			if(empty($requestObject->profileEmail) === true) {
				throw(new \InvalidArgumentException("No profile email present", 405));
			}

			// profile type is a required field
			if(empty($requestObject->profileType) === true) {
				throw(new \InvalidArgumentException("No profile type selected", 405));
			}

			// profile bio is required
			if(empty($requestObject->profileBio) === true) {
				throw(new \InvalidArgumentException("No profile bio is filled out", 405));
			}

			$profile->setProfileName($requestObject->profileName);
			$profile->setProfileEmail($requestObject->profileEmail);
			$profile->setProfileType($requestObject->profileType);
			$profile->setProfileBio($requestObject->profileBio);

			// update reply
			$reply->message = "Profile information updated successfully";
		}

		/**
		 * update the password if requested
		 */
		// enforce that the current password and new password are present
		if(empty($requestObject->profilePassword) === false && empty($requestObject->profileConfirmPassword) === false
			&& empty($requestObject->Confirm) === false) {

			// make sure of new password and enforce the password exists
			if($requestObject->newProfilePassword !== $requestObject->profileConfirmPassword) {
				throw(new RuntimeException("New passwords do not match", 401));
			}

			// hash the previous password
			$currentPasswordHash = hash_pbkdf2("sha512", $requestObject->currentProfilePassword,
				$profile->getProfileSalt(), 262144);

			// make sure the hash given by the end user matches what is in the database
			if($currentPasswordHash !== $profile->getProfileHash()) {
				throw(new \RuntimeException("Old password is incorrect", 401));
			}

			// salt and hash the new password and update the profile object
			$newPasswordSalt = bin2hex(random_bytes(16));
			$newPasswordHash = hash_pbkdf2("sha512", $requestObject->newProfilePassword, $newPasswordSalt, 262144);
			$profile->setProfileHash($newPasswordHash);
			$profile->setProfileSalt($newPasswordSalt);
		}

		// perform the actual update to the database and update the message
		$profile->update($pdo);
		$reply->message = "profile password successfully updated";

	} elseif($method === "DELETE") {
		// verify the XSRF token
		verifyXsrf();

		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile does not exist"));
		}

		// enforce the user is signed in and trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $profile->getProfileId()) {
			throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
		}

		// delete the profile from the database
		$profile->delete($pdo);
		$reply->message = "Profile deleted";
	} else {
		throw(new InvalidArgumentException("Invalid HTTP request", 400));
	}

	// catch any exceptions that were thrown and update the status and message state variable fields
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);
