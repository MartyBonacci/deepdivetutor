<?php

namespace Edu\Cnm\DeepDiveTutor;

require_once("autoload.php");

/**
 * class for profile entity
 *
 * This is the Profile class for deepdivetutor.
 *
 * @author Jack Reuter <djreuter45@gmail.com>
 * @version 1.0.1
 */
class Profile {
	/**
	 * Id this profile; This is the primary key
	 * @var int $profileId
	 */
	private $profileId;
	/**
	 * Name for this profile
	 * @var string $profileName
	 */
	private $profileName;
	/**
	 * Email for this profile
	 * @var string $profileEmail
	 */
	private $profileEmail;
	/**
	 * Type of profile; Either student or tutor
	 * @var int $profileType
	 */
	private $profileType;
	/**
	 * GitHub Token for profile
	 * @var string $profileGithubToken
	 */
	private $profileGithubToken;
	/**
	 * Bio for this profile
	 * @var string $profileBio ;
	 */
	private $profileBio;
	/**
	 * Rate for this profile
	 * @var float $profileRate
	 */
	private $profileRate;
	/**
	 * Image for this profile
	 * @var string $profileImage
	 */
	private $profileImage;
	/**
	 * Date this profile was last edited
	 * @var \DateTime
	 */
	private $profileLastEditDateTime;
	/**
	 * Activation token for this profile
	 * @var string $profileActivationToken
	 */
	private $profileActivationToken;
	/**
	 * Hash for this profile password
	 * @var string $profileHash
	 */
	private $profileHash;
	/**
	 * Salt for this profile
	 * @var string $profileSalt
	 */
	private $profileSalt;

	/**
	 * constructor for this profile
	 *
	 * @param int|null $newProfileId id of this profile or null if new profile
	 * @param string $newProfileName name of this profile owner
	 * @param string $newProfileEmail email address for this profile
	 * @param int $newProfileType type of profile
	 * @param string $newProfileGithubToken GitHub token for this profile
	 * @param string $newProfileBio bio for this profile
	 * @param float $newProfileRate rate for this profile
	 * @param string $newProfileImage image for this profile
	 * @param \DateTime $newProfileLastEditDateTime last edit date for this profile
	 * @param string $newProfileActivationToken activation token for this profile
	 * @param string $newProfileHash hash for this profile
	 * @param string $newProfileSalt salt for this profile
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @documentation https://php.net/manual/en/language.oop5.decon.php
	 */
	public function construct__(?int $newProfileId, string $newProfileName, string $newProfileEmail, int $newProfileType, string $newProfileGithubToken, string $newProfileBio, float $newProfileRate, string $newProfileImage, $newProfileLastEditDateTime = null, string $newProfileActivationToken, string $newProfileHash, string $newProfileSalt) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileName($newProfileName);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileType($newProfileType);
			$this->setProfileGithubToken($newProfileGithubToken);
			$this->setProfileBio($newProfileBio);
			$this->setProfileRate($newProfileRate);
			$this->setProfileImage($newProfileImage);
			$this->setProfileLastEditDateTime($newProfileLastEditDateTime);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileHash($newProfileHash);
			$this->setProfileSalt($newProfileSalt);
		} // determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for profile id
	 *
	 * @return int|null value of profile id
	 */
	public function getProfileId(): int {
		return ($this->profileId);
	}

	/**
	 * mutator method for profile id
	 *
	 * @param int|null $newProfileId new value of profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 */
	public function setProfileId(?int $newProfileId): void {
		// if profile id is null immediately return it
		if($newProfileId === null) {
			$this->profileId = null;
			return;
		}

		// make sure profile id is positive
		if($newProfileId <= 0) {
			throw(new \RangeException("profile id is not positive"));
		}

		// convert and store the profile id
		$this->profileId = $newProfileId;
	}

	/**
	 * accessor method for profile name
	 *
	 * @return string value of profile name
	 */
	public function getProfileName(): string {
		return ($this->profileName);
	}

	/**
	 * mutator method for profile name
	 * @param string $newProfileName new value of profile name
	 * @throws \InvalidArgumentException if $newProfileName is not a string or is insecure
	 * @throws \RangeException if $newProfileName > 50 characters
	 * @throws \TypeError if $newProfileName is not a string
	 */
	public function setProfileName(string $newProfileName): void {
		// verify the name is secure
		$newProfileName = trim($newProfileName);
		$newProfileName = filter_var($newProfileName, FILTER_SANITIZE_STRING);
		// make sure name is not empty
		if(empty($newProfileName) === true) {
			throw(new \InvalidArgumentException("name is empty or insecure"));
		}
		// verify name will fit into database
		if(strlen($newProfileName) > 50) {
			throw(new \RangeException("name is too long"));
		}
		// store profile name
		$this->profileName = $newProfileName;
	}

	/**
	 * accessor method for profile email
	 *
	 * @return string value of profile email
	 */
	public function getProfileEmail(): string {
		return ($this->profileEmail);
	}

	/**
	 * mutator method for profile email
	 *
	 * @param string $newProfileEmail new value of profile email
	 * @throws \InvalidArgumentException if $newProfileEmail is not a string or is insecure
	 * @throws \RangeException if $newProfileEmail is > 128 characters
	 * @throws \TypeError if $newProfile email is not a string
	 */
	public function setProfileEmail(string $newProfileEmail): void {
		// verify email is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_EMAIL);

		// verify email is not empty
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("email is empty or insecure"));
		}
		// verify email will fit into database
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("email is too long"));
		}
		// store the profile email
		$this->profileEmail = $newProfileEmail;
	}

	/**
	 * accessor method for profile type
	 *
	 * @return int value of profile type
	 */
	public function getProfileType(): int {
		return ($this->profileType);
	}

	/**
	 * mutator method for profile type
	 *
	 * @param int $newProfileType new type of profile
	 * @throws \RangeException if $newProfileType is not positive
	 * @throws \TypeError if $newProfileType is not an integer
	 */
	public function setProfileType(int $newProfileType): void {
		// verify the profile type is 0 or 1
		if($newProfileType !== 0 | 1) {
			throw(new \RangeException("profile type is out of bounds"));
		}

		// convert and store profile type
		$this->profileType = $newProfileType;
	}

	/**
	 * accessor method for profile github token
	 *
	 * @return string value of github token
	 */
	public function getProfileActivationToken(): string {
		return($this->profileGithubToken);
	}

	/**
	 * mutator method for profile github token
	 *
	 * @param string $newProfileGithubToken new github token for profile
	 * @throws \InvalidArgumentException if $newProfileGithubToken is not a string or is insecure
	 * @throws \RangeException if $newProfileGithubToken is > 64 characters
	 * @throws \TypeError if $newProfileGithubToken is not a string
	 */
	public function setProfileGithubToken(string $newProfileGithubToken): void {
		// verify github token is secure
		$newProfileGithubToken = trim($newProfileGithubToken);
		$newProfileGithubToken = filter_var($newProfileGithubToken, FILTER_SANITIZE_STRING);

		// verify github token is not empty
		if(empty($newProfileGithubToken) === true) {
			throw(new \InvalidArgumentException("github token is empty or insecure"));
		}

		// verify github token will fit in the database
		if(strlen($newProfileGithubToken) !== 64) {
			throw(new \RangeException("github token must be 64 characters"));
		}

		// store github token
		$this->profileGithubToken = $newProfileGithubToken;
	}
	/**
	 * accessor method for profile bio
	 *
	 * @return string value of profile bio
	 */
	public function getProfileBio(): string {
		return($this->profileBio);
	}
	/**
	 * mutator method for profile bio
	 *
	 * @param string $newProfileBio bio for this profile
	 * @throws \InvalidArgumentException if $newProfileBio is not a string or is insecure
	 * @throws \RangeException if $newProfileBio is > 500 characters
	 * @throws \TypeError if $newProfileBio is not a string
	 */
	public function setProfileBio(string $newProfileBio): void {
		// verify profile bio is secure
		$newProfileBio = trim($newProfileBio);
		$newProfileBio = filter_var($newProfileBio, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// verify bio is not empty
		if(empty($newProfileBio) === true) {
			throw(new \InvalidArgumentException("profile bio is either empty or insecure"));
		}
		// verify profile bio will fit in the database
		if(strlen($newProfileBio) > 500) {
			throw(new \RangeException("profile bio is too long"));
		}
		// store profile bio
		$this->profileBio = $newProfileBio;
	}


}
