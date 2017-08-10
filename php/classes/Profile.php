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
class Profile implements \JsonSerializable {
	use ValidateDate;
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
	public function __construct(?int $newProfileId, string $newProfileName, string $newProfileEmail, int
	$newProfileType, string $newProfileGithubToken, string $newProfileBio, float $newProfileRate, string $newProfileImage, $newProfileLastEditDateTime = null, string $newProfileActivationToken, string $newProfileHash, string $newProfileSalt) {
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
	public function getProfileId(): ?int {
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
		if($newProfileType !== 0 && $newProfileType !== 1) {
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
	public function getProfileGithubToken(): string {
		return ($this->profileGithubToken);
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
		return ($this->profileBio);
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

	/**
	 * accessor method for profile rate
	 *
	 * @return float value of profile rate
	 */
	public function getProfileRate(): float {
		return ($this->profileRate);
	}

	/**
	 * mutator method for profile rate
	 *
	 * @param float $newProfileRate new value of profile rate
	 * @throws \RangeException if $newProfileRate is > 999.99
	 * @throws \TypeError if $newProfileRate is not a float
	 */
	public function setProfileRate(float $newProfileRate): void {
		// allow for float
		$newProfileRate = filter_var($newProfileRate, FILTER_SANITIZE_NUMBER_FLOAT);

		// verify profileRate is positive
		if($newProfileRate <= 0) {
			throw(new \RangeException("profile rate must be greater than 0"));
		}

		// convert and store profile rate
		$this->profileRate = $newProfileRate;
	}

	/**
	 * accessor method for profile image
	 *
	 * @return string value for profile image
	 */
	public function getProfileImage(): string {
		return ($this->profileImage);
	}

	/**
	 * mutator method for profile image
	 *
	 * @param string $newProfileImage new value of profile image
	 * @throws \InvalidArgumentException if $newProfileImage is not a string or insecure
	 * @throws \RangeException if $newProfileImage is > 32 characters
	 * @throws \TypeError if $newProfileImage is not a string
	 */
	public function setProfileImage(string $newProfileImage): void {
		// verify image is secure
		$newProfileImage = trim($newProfileImage);
		$newProfileImage = filter_var($newProfileImage, FILTER_SANITIZE_STRING);

		// make sure profile image is not empty
		if(empty($newProfileImage) === true) {
			throw(new \InvalidArgumentException("profile image is either empty or insecure"));
		}
		// make sure profile image will fit in the database
		if(strlen($newProfileImage) !== 32) {
			throw(new \RangeException("profile image must be 32 characters"));
		}

		// store the profile image
		$this->profileImage = $newProfileImage;
	}

	/**
	 * accessor method for last profile edit date time
	 *
	 * @return \DateTime value of last profile edit date
	 */
	public function getProfileLastEditDateTime(): \DateTime {
		return ($this->profileLastEditDateTime);
	}

	/**
	 * mutator method for last profile edit date time
	 *
	 * @param \DateTime|string|null $newProfileLastEditDateTime as a DateTime object or string (or null to load
	 * current time)
	 * @throws \InvalidArgumentException if $newProfileLastEditDateTime is not a valid object or string
	 * @throws \RangeException if $newProfileLastEditDateTime is a date that does not exist
	 */
	public function setProfileLastEditDateTime($newProfileLastEditDateTime = null): void {
		// base case: if the date is null use the current date and time
		if($newProfileLastEditDateTime === null) {
			$this->profileLastEditDateTime = new \DateTime();
			return;
		}
		// store the last profile edit date
		try {
			$newProfileLastEditDateTime = self::validateDateTime($newProfileLastEditDateTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->profileLastEditDateTime = $newProfileLastEditDateTime;
	}

	/**
	 * accessor method for profile activation token
	 *
	 * @return string value of profile activation token
	 */
	public function getProfileActivationToken(): string {
		return ($this->profileActivationToken);
	}

	/**
	 * mutator method for profile activation token
	 *
	 * @param string $newProfileActivationToken
	 * @throws \InvalidArgumentException if $newProfileActivationToken is not a string
	 * @throws \RangeException if $newProfileActivationToken is not exactly 32 characters
	 * @throws \TypeError if $newProfileActivationToken is not a string
	 */
	public function setProfileActivationToken(?string $newProfileActivationToken): void {
		// if activation token is null immediately return it
		if($newProfileActivationToken === null) {
			$this->profileActivationToken = null;
			return;
		}

		// make sure string token is hexadecimal
		$newProfileActivationToken = strtolower(trim($newProfileActivationToken));
		if(ctype_xdigit($newProfileActivationToken) === false) {
			throw(new \RangeException("profile activation is not valid"));
		}

		// make sure activation token is exactly 32 characters long
		if(strlen($newProfileActivationToken) !== 32) {
			throw(new \RangeException("token must be 32 characters"));
		}

		// store activation token
		$this->profileActivationToken = $newProfileActivationToken;
	}

	/**
	 * accessor method for profile hash
	 *
	 * @return string value of profile hash
	 */
	public function getProfileHash(): string {
		return ($this->profileHash);
	}

	/**
	 * mutator method for profile hash
	 *
	 * @param string $newProfileHash
	 * @throws \InvalidArgumentException if $newProfileHash is not a string
	 * @throws \RangeException if $newProfileHash is not exactly 128 characters
	 * @throws \TypeError if $newProfileHash is not a string
	 */
	public function setProfileHash(string $newProfileHash): void {
		// make sure hash is properly formatted
		$newProfileHash = trim($newProfileHash);
		$newProfileHash = strtolower($newProfileHash);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("profile hash is empty or insecure"));
		}

		// make sure hash is hexadecimal
		if(!ctype_xdigit($newProfileHash)) {
			throw(new \InvalidArgumentException("profile hash is not valid"));
		}

		// make sure hash is 128 characters
		if(strlen($newProfileHash) !== 128) {
			throw(new \RangeException("hash must be 128 characters"));
		}

		// store profile hash
		$this->profileHash = $newProfileHash;
	}

	/**
	 * accessor method for profile salt
	 *
	 * @returns string value for profile salt
	 */
	public function getProfileSalt(): string {
		return ($this->profileSalt);
	}

	/**
	 * mutator method for profile salt
	 *
	 * @param string $newProfileSalt
	 * @throws \InvalidArgumentException if $newProfileSalt is not secure
	 * @throws \RangeException if $newProfileSalt is not exactly 64 characters
	 * @throws \TypeError if $newProfileSalt is not a string
	 */
	public function setProfileSalt(string $newProfileSalt): void {
		// make sure profile salt is the right format
		$newProfileSalt = trim($newProfileSalt);
		$newProfileSalt = strtolower($newProfileSalt);

		// make sure salt is a hexadecimal
		if(!ctype_xdigit($newProfileSalt)) {
			throw(new \InvalidArgumentException("profile salt is empty"));
		}

		// make sure salt is exactly 64 characters
		if(strlen($newProfileSalt) !== 64) {
			throw (new \RangeException("salt must be 64 characters"));
		}

		// store the salt
		$this->profileSalt = $newProfileSalt;
	}

	/**
	 * inserts this profile into MySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when MySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo): void {
		// make sure profile id is null (so that a profile that already exists doesn't get inserted)
		if($this->profileId !== null) {
			throw(new \PDOException("not a new profile"));
		}

		// create a query template
		$query = "INSERT INTO profile(profileName, profileEmail, profileType, profileGithubToken, profileBio, 
			profileRate, profileImage, profileLastEditDateTime, profileActivationToken, profileHash, profileSalt) VALUES
		(:profileName, :profileEmail, :profileType, :profileGithubToken, :profileBio, :profileRate, :profileImage, 
		:profileLastEditDateTime, :profileActivationToken, :profileHash, :profileSalt)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		var_dump($this);
		$formattedDate = $this->profileLastEditDateTime->format("Y-m-d H:i:s.u");
		$parameters = ["profileName" => $this->profileName, "profileEmail" => $this->profileEmail, "profileType" =>
			$this->profileType, "profileGithubToken" => $this->profileGithubToken, "profileBio" => $this->profileBio, "profileRate" => $this->profileRate, "profileImage" => $this->profileImage, "profileLastEditDateTime" => $formattedDate, "profileActivationToken" =>
			$this->profileActivationToken, "profileHash" => $this->profileHash, "profileSalt" => $this->profileSalt];
		$statement->execute($parameters);

		// update the null profile id with what MySQL gave
		$this->profileId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this profile from MySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when MySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo): void {
		// make sure profile id is not null so that it tries to delete a profile that doesn't exist
		if($this->profileId === null) {
			throw(new \PDOException("unable to delete a profile that does not exist"));
		}

		// create a query template
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["profileId" => $this->profileId];
		$statement->execute($parameters);
	}

	/**
	 * updates this profile in MySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when MySQL related error occurs
	 * @throws |\TypeError if $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo) {
		// make sure profile id is not null so that it won't try to update a profile that doesn't exist
		if($this->profileId === null) {
			throw(new \PDOException("unable to update a profile that does not exist"));
		}

		// create query template
		$query = "UPDATE profile SET profileName = :profileName, profileEmail = :profileEmail, profileType = :profileType, 
profileGithubToken = :profileGithubToken, profileBio = :profileBio, profileRate = :profileRate, profileImage = 
:profileImage, profileLastEditDateTime = :profileLastEditDateTime, profileActivationToken = :profileActivationToken, 
profileHash = :profileHash, profileSalt = :profileSalt WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->profileLastEditDateTime->format("Y-m-d H:i:s.u");
		$parameters = ["profileName" => $this->profileName, "profileEmail" => $this->profileEmail, "profileType" =>
			$this->profileType, "profileGithubToken" => $this->profileGithubToken, "profileBio" => $this->profileBio,
			"profileRate" => $this->profileRate, "profileImage" => $this->profileImage, "profileLastEditDateTime" =>
				$formattedDate, "profileActivationToken" => $this->profileActivationToken, "profileHash" =>
				$this->profileHash, "profileSalt" => $this->profileSalt, "profileId" => $this->profileId];
		$statement->execute($parameters);
	}

	/**
	 * gets the profile by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $profileId profile id to search for
	 * @return Profile|null Profile found or null if not found
	 * @throws \PDOException when MySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getProfileByProfileId(\PDO $pdo, int $profileId): ?Profile {
		// sanitize the profile id before searching
		if($profileId <= 0) {
			throw(new \PDOException("profile id is not positive"));
		}

		// create query template
		$query = "SELECT profileId, profileName, profileEmail, profileType, profileGithubToken, profileBio, profileRate, profileImage, 
profileLastEditDateTime, profileActivationToken, profileHash, profileSalt FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// bind the profile id to the place holder in the template
		$parameters = ["profileId" => $profileId];
		$statement->execute($parameters);

		// grab the profile from MySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileName"], $row["profileEmail"], $row["profileType"], $row["profileGithubToken"], $row["profileBio"], $row["profileRate"], $row["profileImage"], $row["profileLastEditDateTime"], $row["profileActivationToken"], $row["profileHash"], $row["profileSalt"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}

	/**
	 * gets profile by content
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileName name to search for
	 * @return \SplFixedArray SplFixedArray of Names found
	 * @throws \PDOException when MySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getProfileByProfileName(\PDO $pdo, string $profileName): \SplFixedArray {
		// sanitize the name before searching
		$profileName = trim($profileName);
		$profileName = filter_var($profileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileName) === true) {
			throw(new \PDOException("profile name is invalid"));
		}

		// escape any MySQL wildcards
		// $profileName = str_replace("_", "\\_", str_replace("%", "\\%", $profileName));

		// create query template
		$query = "SELECT profileId, profileName, profileEmail, profileType, profileGithubToken, profileBio, profileRate, profileImage, 
profileLastEditDateTime, profileActivationToken, profileHash, profileSalt FROM profile WHERE profileName = :profileName";
		$statement = $pdo->prepare($query);

		// bind the profile name to the placeholder in the template
		// $profileName = "%profileName%";
		$parameters = ["profileName" => $profileName];
		$statement->execute($parameters);

		// build an array of profile names
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileName"], $row["profileEmail"], $row["profileType"],
					$row["profileGithubToken"], $row["profileBio"], $row["profileRate"], $row["profileImage"], $row["profileLastEditDateTime"], $row["profileActivationToken"], $row["profileHash"], $row["profileSalt"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
	}

	/**
	 * gets profile by email
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileEmail email to search for
	 * @return Profile|null email found or null if not found
	 * @throws \PDOException when MySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getProfileByProfileEmail(\PDO $pdo, ?string $profileEmail): ?Profile {
		// sanitize the profile email before searching
		$profileEmail = trim($profileEmail);
		$profileEmail = filter_var($profileEmail, FILTER_SANITIZE_EMAIL);
		if(empty($profileEmail) === true) {
			throw(new \PDOException("no profiles exist matching that email"));
		}

		// create query template
		$query = "SELECT profileId, profileName, profileEmail, profileType, profileGithubToken, profileBio, profileRate, profileImage, 
profileLastEditDateTime, profileActivationToken, profileHash, profileSalt FROM profile WHERE profileEmail = :profileEmail";
		$statement = $pdo->prepare($query);

		// bind the profileEmail to the place holder in the template
		$parameters = ["profileEmail" => $profileEmail];
		$statement->execute($parameters);

		// grab the profile email from MySQL
		try {
			$email = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$email = new Profile($row["profileId"], $row["profileName"], $row["profileEmail"], $row["profileType"],
				$row["profileGithubToken"], $row["profileBio"], $row["profileRate"], $row["profileImage"], $row["profileLastEditDateTime"], $row["profileActivationToken"], $row["profileHash"], $row["profileSalt"]);
			}
		} catch(\Exception $exception) {
			// if row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($email);
	}

	/**
	 * gets profile by profile type
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $profileType to search for
	 * @return \SplFixedArray SplFixedArray of profile types
	 * @throws \PDOException when MySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getProfileByProfileType(\PDO $pdo, int $profileType): \SplFixedArray {
		// sanitize the description before searching
		if($profileType !== 0 && $profileType !== 1) {
			throw(new \PDOException("incorrect profile type"));
		}

		// create query template
		$query = "SELECT profileId, profileName, profileEmail, profileType, profileGithubToken, profileBio, profileRate, profileImage, 
profileLastEditDateTime, profileActivationToken, profileHash, profileSalt FROM profile WHERE profileType = :profileType";
		$statement = $pdo->prepare($query);

		// bind the profile type to the placeholder in the template
		$parameters = ["profileType" => $profileType];
		$statement->execute($parameters);

		// build an array of profile types
		$types = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$type = new Profile($row["profileId"], $row["profileName"], $row["profileEmail"], $row["profileType"],
				$row["profileGithubToken"], $row["profileBio"], $row["profileRate"], $row["profileImage"], $row["profileLastEditDateTime"], $row["profileActivationToken"], $row["profileHash"], $row["profileSalt"]);
				$types[$types->key()] = $type;
				$types->next();
			} catch(\Exception $exception) {
				// if row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($types);
	}

	/**
	 * gets profile by profile github token
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileGithubToken to search for
	 * @return Profile|null if githubToken if found or not found
	 * @throws \PDOException when MySQL related errors occur
	 * @throws \TypeError when variables are the wrong data type
	 */
	public static function getProfileByProfileGithubToken(\PDO $pdo, ?string $profileGithubToken): ?Profile {
		// sanitize the profile github token before searching
		$profileGithubToken = trim($profileGithubToken);
		$profileGithubToken = filter_var($profileGithubToken, FILTER_SANITIZE_STRING);
		if(empty($profileGithubToken) === true) {
			throw(new \PDOException("no GitHub account linked to profile"));
		}

		// create query template
		$query = "SELECT profileId, profileName, profileEmail, profileType, profileGithubToken, profileBio, profileRate, profileImage, 
profileLastEditDateTime, profileActivationToken, profileHash, profileSalt FROM profile WHERE profileGithubToken = :profileGithubToken";
		$statement = $pdo->prepare($query);

		// bind the profileGithubToken to the placeholder in the template
		$parameters = ["profileGithubToken" => $profileGithubToken];
		$statement->execute($parameters);

		// grab the profileGithubToken from MySQL
		try {
			$githubToken = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$githubToken = new Profile($row["profileId"], $row["profileName"], $row["profileType"], $row["profileGithubToken"], $row["profileBio"], $row["profileRate"], $row["profileImage"], $row["profileLastEditDateTime"], $row["profileActivationToken"], $row["profileHash"], $row["profileSalt"]);
			}
		} catch(\Exception $exception) {
			// if row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($githubToken);
	}

	/**
	 * gets profile by profile rate
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $profileRate to search for
	 * @return \SplFixedArray SplFixedArray of profile rates
	 * @throws \PDOException when MySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getProfileByProfileRate(\PDO $pdo, int $profileRate): \SplFixedArray {
		// sanitize the profile rate before searching
		$profileRate = filter_var($profileRate, FILTER_SANITIZE_NUMBER_INT);
		if($profileRate < 0) {
			throw(new \PDOException("profile rate is not positive"));
		}

		// create query template
		$query = "SELECT profileId, profileName, profileEmail, profileType, profileGithubToken, profileBio, profileRate, profileImage, 
profileLastEditDateTime, profileActivationToken, profileHash, profileSalt FROM profile WHERE profileRate = :profileRate";
		$statement = $pdo->prepare($query);

		// bind the profile type to the placeholder in the template
		$parameters = ["profileRate" => $profileRate];
		$statement->execute($parameters);

		// build an array of profile rates
		$rates = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$rate = new Profile($row["profileId"], $row["profileName"], $row["profileType"], $row["profileGithubToken"], $row["profileBio"], $row["profileRate"], $row["profileImage"], $row["profileLastEditDateTime"], $row["profileActivationToken"], $row["profileHash"], $row["profileSalt"]);
				$rates[$rates->key()] = $rate;
				$rates->next();
			} catch(\Exception $exception) {
				// if row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($rates);
	}

	/**
	 * get profile by profile activation token
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileActivationToken activation token to search for
	 * @return Profile|null if activation token is found or not found
	 * @throws \PDOException when MySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getProfileByProfileActivationToken(\PDO $pdo, ?string $profileActivationToken): ?Profile {
		// sanitize activation token before searching
		$profileActivationToken = trim($profileActivationToken);
		$profileActivationToken = filter_var($profileActivationToken, FILTER_SANITIZE_STRING);
		if(empty($profileActivationToken) === true) {
			throw(new \PDOException("activation token is not valid"));
		}

		// create query template
		$query = "SELECT profileId, profileName, profileEmail, profileType, profileGithubToken, profileBio, profileRate, profileImage, 
profileLastEditDateTime, profileActivationToken, profileHash, profileSalt FROM profile WHERE profileActivationToken =
 :profileActivationToken";
		$statement = $pdo->prepare($query);

		// bind the activation token to the placeholder in the template
		$parameters = ["profileActivationToken" => $profileActivationToken];
		$statement->execute($parameters);

		// grab the activation token from MySQL
		try {
			$activationToken = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$activationToken = new Profile($row["profileId"], $row["profileName"], $row["profileType"], $row["profileGithubToken"], $row["profileBio"], $row["profileRate"], $row["profileImage"], $row["profileLastEditDateTime"], $row["profileActivationToken"], $row["profileHash"], $row["profileSalt"]);
			}
		} catch(\Exception $exception) {
			// if row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($activationToken);
	}

	/**
	 * format the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		// format the date so that the front end can consume it right up
		$fields["profileLastEditDateTime"] = round(floatval($this->profileLastEditDateTime->format("U.u")) * 1000);
		return($fields);
	}
}
