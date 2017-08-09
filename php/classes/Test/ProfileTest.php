<?php

namespace Edu\Cnm\DeepDiveTutor\Test;

use Edu\Cnm\DeepDiveTutor\{
	Profile
};

// grab the class
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class
 * It is complete because *ALL* MySQL\PDO enabled methods are tested for both invalid and valid inputs
 *
 * @see Profile
 * @author Jack Reuter <djreuter45@gmail.com>
 */
class ProfileTest extends DeepDiveTutorTest {
	/**
	 * valid name to use
	 * @var string $VALID_NAME
	 */
	protected $VALID_NAME = "John Smith";

	/**
	 * valid email to use
	 * @var string $VALID_EMAIL
	 */
	protected $VALID_EMAIL = "test@phpunit.de";

	/**
	 * valid email 2 to use
	 * @var $VALID_EMAIL_2
	 */
	protected $VALID_EMAIL_2 = "updated.email@phpunit.de";

	/**
	 * valid profile type (student)
	 * @var int $VALID_TYPE_S
	 */
	protected $VALID_TYPE_S = 0;

	/**
	 * valid profile type (tutor)
	 * @var int $VALID_TYPE_T
	 */
	protected $VALID_TYPE_T = 1;

	/**
	 * valid profile github token
	 * @var $VALID_GITHUBTOKEN
	 */
	protected $VALID_GITHUBTOKEN = "Loremipsumdolorsitametconsecteturadipiscingelitposuerefhdrtuiseb";

	/**
	 * valid profile bio
	 * @var string $VALID_BIO
	 */
	protected $VALID_BIO = "This is a bio";

	/**
	 * valid profile rate
	 * @var float $VALID_RATE
	 */
	protected $VALID_RATE = 25.00;

	/**
	 * valid profile image
	 * @var $VALID_IMAGE
	 */
	protected $VALID_IMAGE = "Loremipsdolorsitametconthirtytwo";

	/**
	 * valid last edit date time
	 * @var $VALID_DATETIME
	 */
	protected $VALID_DATETIME = null;

	/**
	 * placeholder until account activation is created
	 * @var string $VALID_ACTIVATION
	 */
	protected $VALID_ACTIVATION;

	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 */
	protected $VALID_HASH;

	/**
	 * valid salt to use
	 * @var $VALID_SALT
	 */
	protected $VALID_SALT;


	/**
	 * run the default operation to create the salt and hash
	 */
	public final function setUp(): void {
		// refer to name of the base class as given in the extends declaration of this class
		parent::setUp();

		//
		$password = "abc123";
		$this->VALID_SALT = bin2hex(random_bytes(32));
		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 262144);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
	}

	/**
	 * test inserting a valid student Profile and verify that the actual MySQL data matches
	 */
	public function testInsertValidProfile(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert it into MySQL
		$profile = new Profile(null, $this->VALID_NAME, $this->VALID_EMAIL, $this->VALID_TYPE_S, $this->VALID_GITHUBTOKEN,
			$this->VALID_BIO, $this->VALID_RATE, $this->VALID_IMAGE, $this->VALID_DATETIME, $this->VALID_ACTIVATION,
			$this->VALID_HASH, $this->VALID_SALT);

		// var_dump($profile);

		$profile->insert($this->getPDO());

		// grab the data from MySQL and enforce the fields match out expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_NAME);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileType(), $this->VALID_TYPE_S);
		$this->assertEquals($pdoProfile->getProfileGithubToken(), $this->VALID_GITHUBTOKEN);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_BIO);
		$this->assertEquals($pdoProfile->getProfileRate(), $this->VALID_RATE);
		$this->assertEquals($pdoProfile->getProfileImage(), $this->VALID_IMAGE);
		$this->assertEquals($pdoProfile->getProfileLastEditDateTime(), $this->VALID_DATETIME);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
	}

	/**
	 * test inserting a Profile that already exists
	 *
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidProfile(): void {
		// create a profile with a non null profileId and watch it fail
		$profile = new Profile(DeepDiveTutorTest::INVALID_KEY, $this->VALID_NAME, $this->VALID_EMAIL,
			$this->VALID_TYPE_S, $this->VALID_GITHUBTOKEN, $this->VALID_BIO, $this->VALID_RATE, $this->VALID_IMAGE,
			$this->VALID_DATETIME, $this->VALID_ACTIVATION, $this->VALID_HASH, $this->VALID_SALT);
		$profile->insert($this->getPDO());
	}

	/**
	 * test inserting a tutor Profile, editing it, and then updating it
	 */
	public function testUpdateValidProfile() {
		// count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new profile and insert it into MySQL
		$profile = new Profile(null, $this->VALID_NAME, $this->VALID_EMAIL, $this->VALID_TYPE_T, $this->VALID_GITHUBTOKEN,
			$this->VALID_BIO, $this->VALID_RATE, $this->VALID_IMAGE, $this->VALID_DATETIME, $this->VALID_ACTIVATION,
			$this->VALID_HASH, $this->VALID_SALT);
		$profile->insert($this->getPDO());

		// edit the profile and update it in MySQL
		$profile->setProfileEmail($this->VALID_EMAIL_2);
		$profile->update($this->getPDO());

		// grab the data from MySQL and enforce the fields match expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_NAME);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL_2);
		$this->assertEquals($pdoProfile->getProfileType(), $this->VALID_TYPE_T);
		$this->assertEquals($pdoProfile->getProfileGithubToken(), $this->VALID_GITHUBTOKEN);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_BIO);
		$this->assertEquals($pdoProfile->getProfileRate(), $this->VALID_RATE);
		$this->assertEquals($pdoProfile->getProfileImage(), $this->VALID_IMAGE);
		$this->assertEquals($pdoProfile->getProfileLastEditDateTime(), $this->VALID_DATETIME);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
	}

	/**
	 * test updating a profile that does not exist
	 *
	 * @expectedException \PDOException
	 */
	public function testUpdateInvalidProfile() {
		// create a profile and try to update it without actually inserting it
		$profile = new Profile(null, $this->VALID_NAME, $this->VALID_EMAIL, $this->VALID_TYPE_S, $this->VALID_GITHUBTOKEN,
			$this->VALID_BIO, $this->VALID_RATE, $this->VALID_IMAGE, $this->VALID_DATETIME, $this->VALID_ACTIVATION,
			$this->VALID_HASH, $this->VALID_SALT);
		$profile->update($this->getPDO());
	}

	/**
	 * test creating a Profile and then deleting it
	 */
	public function testDeleteValidProfile(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new profile and insert it into MySQL
		$profile = new Profile(null, $this->VALID_NAME, $this->VALID_EMAIL, $this->VALID_TYPE_T, $this->VALID_GITHUBTOKEN,
			$this->VALID_BIO, $this->VALID_RATE, $this->VALID_IMAGE, $this->VALID_DATETIME, $this->VALID_ACTIVATION,
			$this->VALID_HASH, $this->VALID_SALT);
		$profile->insert($this->getPDO());

		// delete the Profile from MySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());

		// grab the data from MySQL and enforce the Profile does not exist
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertNull($pdoProfile);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
	}

	/**
	 * test deleting a Profile that doesn't exist
	 *
	 * @expectedException \PDOException
	 */
	public function testDeleteInvalidProfile(): void {
		// create a profile and try to delete it without actually inserting it
		$profile = new Profile(null, $this->VALID_NAME, $this->VALID_EMAIL, $this->VALID_TYPE_T, $this->VALID_GITHUBTOKEN,
			$this->VALID_BIO, $this->VALID_RATE, $this->VALID_IMAGE, $this->VALID_DATETIME, $this->VALID_ACTIVATION,
			$this->VALID_HASH, $this->VALID_SALT);
		$profile->delete($this->getPDO());
	}

	// Tests for Get By statements

	/**
	 * test inserting a Profile and regrabbing it from MySQL
	 */
	public function testGetValidProfileByProfileId(): void {
		// count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert it into MySQL
		$profile = new Profile(null, $this->VALID_NAME, $this->VALID_EMAIL, $this->VALID_TYPE_S, $this->VALID_GITHUBTOKEN,
			$this->VALID_BIO, $this->VALID_RATE, $this->VALID_IMAGE, $this->VALID_DATETIME, $this->VALID_ACTIVATION,
			$this->VALID_HASH, $this->VALID_SALT);
		$profile->insert($this->getPDO());

		// grab the data from MySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_NAME);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileType(), $this->VALID_TYPE_S);
		$this->assertEquals($pdoProfile->getProfileGithubToken(), $this->VALID_GITHUBTOKEN);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_BIO);
		$this->assertEquals($pdoProfile->getProfileRate(), $this->VALID_RATE);
		$this->assertEquals($pdoProfile->getProfileImage(), $this->VALID_IMAGE);
		$this->assertEquals($pdoProfile->getProfileLastEditDateTime(), $this->VALID_DATETIME);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
	}

	/**
	 * test grabbing a Profile that does not exist
	 */
	public function testGetInvalidProfileByProfileId(): void {
		// grab a profile id that exceeds the maximum allowable profile id
		$profile = Profile::getProfileByProfileId($this->getPDO(), DeepDiveTutorTest::INVALID_KEY);
		$this->assertNull($profile);
	}

	/**
	 * test get valid profile by name
	 */
	public function testGetValidProfileByName() {
		// count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert it into MySQL
		$profile = new Profile(null, $this->VALID_NAME, $this->VALID_EMAIL, $this->VALID_TYPE_S, $this->VALID_GITHUBTOKEN,
			$this->VALID_BIO, $this->VALID_RATE, $this->VALID_IMAGE, $this->VALID_DATETIME, $this->VALID_ACTIVATION,
			$this->VALID_HASH, $this->VALID_SALT);
		$profile->insert($this->getPDO());

		// grab the data from MySQL
		$results = Profile::getProfileByProfileName($this->getPDO(), $this->VALID_NAME);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));

		// enforce no other objects are bleeding into profile
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DeepDiveTutor\\Profile", $results);

		// enforce the results meet expectations
		$pdoProfile = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_NAME);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileType(), $this->VALID_TYPE_S);
		$this->assertEquals($pdoProfile->getProfileGithubToken(), $this->VALID_GITHUBTOKEN);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_BIO);
		$this->assertEquals($pdoProfile->getProfileRate(), $this->VALID_RATE);
		$this->assertEquals($pdoProfile->getProfileImage(), $this->VALID_IMAGE);
		$this->assertEquals($pdoProfile->getProfileLastEditDateTime(), $this->VALID_DATETIME);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
	}

	/**
	 * test grabbing a profile by name that does not exist
	 */
	public function testGetInvalidProfileByName(): void {
		// grab a name that does not exist
		$profile = Profile::getProfileByProfileName($this->getPDO(), "No Name");
		$this->assertCount(0, $profile);
	}

	/**
	 * test grabbing a profile by email
	 */
	public function testGetProfileByValidEmail(): void {
		// count number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert into MySQL
		$profile = new Profile(null, $this->VALID_NAME, $this->VALID_EMAIL, $this->VALID_TYPE_S, $this->VALID_GITHUBTOKEN,
			$this->VALID_BIO, $this->VALID_RATE, $this->VALID_IMAGE, $this->VALID_DATETIME, $this->VALID_ACTIVATION,
			$this->VALID_HASH, $this->VALID_SALT);
		$profile->insert($this->getPDO());

		// grab the data from MySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileEmail($this->getPDO(), $profile->getProfileEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_NAME);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileType(), $this->VALID_TYPE_S);
		$this->assertEquals($pdoProfile->getProfileGithubToken(), $this->VALID_GITHUBTOKEN);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_BIO);
		$this->assertEquals($pdoProfile->getProfileRate(), $this->VALID_RATE);
		$this->assertEquals($pdoProfile->getProfileImage(), $this->VALID_IMAGE);
		$this->assertEquals($pdoProfile->getProfileLastEditDateTime(), $this->VALID_DATETIME);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
	}

	/**
	 * test grabbing a Profile by email that does not exist
	 */
	public function testGetInvalidProfileByEmail(): void {
		// grab an email that does not exist
		$profile = Profile::getProfileByProfileEmail($this->getPDO(), "doesnotexist@phpunit.de");
		$this->assertNull($profile);
	}

	/**
	 * test grabbing a profile by profile type
	 */
	public function testGetValidProfileByType() {
		// count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert into MySQL
		$profile = new Profile(null, $this->VALID_NAME, $this->VALID_EMAIL, $this->VALID_TYPE_S, $this->VALID_GITHUBTOKEN,
			$this->VALID_BIO, $this->VALID_RATE, $this->VALID_IMAGE, $this->VALID_DATETIME, $this->VALID_ACTIVATION,
			$this->VALID_HASH, $this->VALID_SALT);
		$profile->insert($this->getPDO());

		// grab the data from MySQL
		$results = Profile::getProfileByProfileType($this->getPDO(), $this->VALID_TYPE_S);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));

		// enforce no other objects are bleeding into Profile
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DeepDiveTutor\\Profile", $results);

		// enforce the results meet expectations
		$pdoProfile = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_NAME);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileType(), $this->VALID_TYPE_S);
		$this->assertEquals($pdoProfile->getProfileGithubToken(), $this->VALID_GITHUBTOKEN);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_BIO);
		$this->assertEquals($pdoProfile->getProfileRate(), $this->VALID_RATE);
		$this->assertEquals($pdoProfile->getProfileImage(), $this->VALID_IMAGE);
		$this->assertEquals($pdoProfile->getProfileLastEditDateTime(), $this->VALID_DATETIME);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
	}

	/**
	 * test grabbing a Profile by profile type that does not exist
	 */
	public function testGetInvalidProfileByType(): void {
		// grab an profile type that does not exist
		$profile = Profile::getProfileByProfileType($this->getPDO(), 4);
		$this->assertCount(0, $profile);
	}

	/**
	 * test grabbing a profile by its github token
	 */
	public function testGetValidProfileByGithubToken(): void {
		// count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert it into MySQL
		$profile = new Profile(null, $this->VALID_NAME, $this->VALID_EMAIL, $this->VALID_TYPE_S, $this->VALID_GITHUBTOKEN,
			$this->VALID_BIO, $this->VALID_RATE, $this->VALID_IMAGE, $this->VALID_DATETIME, $this->VALID_ACTIVATION,
			$this->VALID_HASH, $this->VALID_SALT);
		$profile->insert($this->getPDO());

		// grab the data and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileGithubToken($this->getPDO(), $profile->getProfileGithubToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_NAME);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileType(), $this->VALID_TYPE_S);
		$this->assertEquals($pdoProfile->getProfileGithubToken(), $this->VALID_GITHUBTOKEN);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_BIO);
		$this->assertEquals($pdoProfile->getProfileRate(), $this->VALID_RATE);
		$this->assertEquals($pdoProfile->getProfileImage(), $this->VALID_IMAGE);
		$this->assertEquals($pdoProfile->getProfileLastEditDateTime(), $this->VALID_DATETIME);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
	}

	/**
	 * test grabbing a Profile by github token that does not exist
	 */
	public function testGetInvalidProfileByGithubToken(): void {
		// grab a github token that does not exist
		$profile = Profile::getProfileByProfileGithubToken($this->getPDO(), "fhdhghsjdb452ndvfnn556ndj57dn");
		$this->assertNull($profile);
	}

	/**
	 * test grabbing Profile by profile rate
	 */
	public function testGetValidProfileByRate() {
		// count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert it into MySQL
		$profile = new Profile(null, $this->VALID_NAME, $this->VALID_EMAIL, $this->VALID_TYPE_S, $this->VALID_GITHUBTOKEN,
			$this->VALID_BIO, $this->VALID_RATE, $this->VALID_IMAGE, $this->VALID_DATETIME, $this->VALID_ACTIVATION,
			$this->VALID_HASH, $this->VALID_SALT);
		$profile->insert($this->getPDO());

		// grab the data from MySQL
		$results = Profile::getProfileByProfileRate($this->getPDO(), $this->VALID_RATE);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));

		// enforce no other objects are bleeding into profile
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DeepDiveTutor\\Profile", $results);

		// enforce the results meet expectations
		$pdoProfile = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_NAME);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileType(), $this->VALID_TYPE_S);
		$this->assertEquals($pdoProfile->getProfileGithubToken(), $this->VALID_GITHUBTOKEN);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_BIO);
		$this->assertEquals($pdoProfile->getProfileRate(), $this->VALID_RATE);
		$this->assertEquals($pdoProfile->getProfileImage(), $this->VALID_IMAGE);
		$this->assertEquals($pdoProfile->getProfileLastEditDateTime(), $this->VALID_DATETIME);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
	}

	/**
	 * test grabbing profile by rate that does not exist
	 */
	public function testGetInvalidProfileByRate(): void {
		// grab a rate that does not exist
		$profile = Profile::getProfileByProfileRate($this->getPDO(), 1923.99);
		$this->assertCount(0, $profile);
	}

	/**
	 * test grabbing a profile by its activation token
	 */
	public function testGetValidProfileByActivationToken(): void {
		// count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert it into MySQL
		$profile = new Profile(null, $this->VALID_NAME, $this->VALID_EMAIL, $this->VALID_TYPE_S, $this->VALID_GITHUBTOKEN,
			$this->VALID_BIO, $this->VALID_RATE, $this->VALID_IMAGE, $this->VALID_DATETIME, $this->VALID_ACTIVATION,
			$this->VALID_HASH, $this->VALID_SALT);
		$profile->insert($this->getPDO());

		// grab the data from MySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileActivationToken($this->getPDO(), $profile->getProfileActivationToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_NAME);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileType(), $this->VALID_TYPE_S);
		$this->assertEquals($pdoProfile->getProfileGithubToken(), $this->VALID_GITHUBTOKEN);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_BIO);
		$this->assertEquals($pdoProfile->getProfileRate(), $this->VALID_RATE);
		$this->assertEquals($pdoProfile->getProfileImage(), $this->VALID_IMAGE);
		$this->assertEquals($pdoProfile->getProfileLastEditDateTime(), $this->VALID_DATETIME);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
	}

	/**
	 * test grabbing a Profile by activation token that does not exist
	 */
	public function testGetInvalidProfileByActivationToken(): void {
		// grab activation token that does not exist
		$profile = Profile::getProfileByProfileActivationToken($this->getPDO(), "ghdh45465f543n56hdbh32nfj6");
		$this->assertNull($profile);
	}
}