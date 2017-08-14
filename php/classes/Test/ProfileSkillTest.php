<?php

namespace Edu\Cnm\DeepDiveTutor\Test;

use Edu\Cnm\DeepDiveTutor\{
	Profile, Skill, ProfileSkill
};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the ProfileSkill class
 *
 * This is a complete PHPUnit test of the ProfileSkill class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see ProfileSkill
 * @author Marty Bonacci <marty@customdept.com>
 **/
class ProfileSkillTest extends DeepDiveTutorTest {
	/**
	 * Profile that has the Skill; this is for foreign key relations
	 * @var Profile $profileSkillProfileId
	 **/
	protected $profileSkillProfileId = null;

	/**
	 * Skill associated with a Profile; this is for foreign key relations
	 * @var profile $profileSkillSkillId
	 **/
	protected $profileSkillSkillId = null;

	/**
	 * Date this profile was last edited
	 * @var \DateTime
	 */
	protected $profileLastEditDateTime;
	/**
	 * Activation token for this profile
	 * @var string $profileActivationToken
	 */
	protected $profileActivationToken;
	/**
	 * Hash for this profile password
	 * @var string $profileHash
	 */
	protected $profileHash;
	/**
	 * Salt for this profile
	 * @var string $profileSalt
	 */
	protected $profileSalt;
	/**
	 * profile that provides the profile id which is the foreign key in profile skill
	 * @var Profile $profile
	 */
	protected $profile;
	/**
	 *  skill that provides the skill id which is the foreign key in profile skill
	 * @var
	 */
	protected $skill;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp(): void {
		// run the default setUp() method first
		parent::setUp();
		// create a salt and hash for the mocked profile
		$password = "abc123";
		$this->profileSalt = bin2hex(random_bytes(32));
		$this->profileHash = hash_pbkdf2("sha512", $password, $this->profileSalt, 262144);
		$this->profileActivationToken = bin2hex(random_bytes(16));
		// create and insert the mocked profile
		$this->profile = new profile(null, "Billy Bob", "billy@bob.com", 1, "nfshfndhu4h5j4bjbdjbfjb5j4bj3jbfjb5jbj3bjbj3jbj4jbjbj4dknjb4jb5j", "I'm super awesome! Pick me!", 20, "12345678901234567890123456789012", $this->profileLastEditDateTime, $this->profileActivationToken, $this->profileHash, $this->profileSalt);
		$this->profile->insert($this->getPDO());
		// create the and insert the mocked skill
		$this->skill = new skill(null, "JavaScript");
		$this->skill->insert($this->getPDO());
		// calculate the date (just use the time the unit test was setup...)
		$this->profileLastEditDateTime = new \DateTime();
	}

	/**
	 * test creating valid profile skill then deleting it
	 */
	public function testInsertValidProfileSkillAndDelete(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profileSkill");
		// create a new Profile Skill and insert into mySQL
		$profileSkill = new ProfileSkill($this->profile->getProfileId(), $this->skill->getSkillId());
		$profileSkill->insert($this->getPDO());
		// delete the profileSkill from MySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profileSkill"));
		$profileSkill->delete($this->getPDO());
		// grab the data from mySQL and confirm that the profileSkill does not exist
		$pdoProfileSkill = ProfileSkill::getProfileSkillProfileIdAndProfileSkillSkillId($this->getPDO(), $this->profile->getProfileId(), $this->skill->getSkillId());
		$this->assertNull($pdoProfileSkill);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profileSkill"));
	}

	/**
	 * test creating valid profile skill then verifying that it matches the SQL data
	 */
	public function testInsertValidProfileSkill(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profileSkill");
		// create a new Profile Skill and insert into mySQL
		$profileSkill = new ProfileSkill($this->profile->getProfileId(), $this->skill->getSkillId());
		$profileSkill->insert($this->getPDO());
		// grab the data from MYSQL and enforce the fields match our expectations
		$pdoProfileSkill = ProfileSkill::getProfileSkillProfileIdAndProfileSkillSkillId($this->getPDO(), $this->profile->getProfileId(), $this->skill->getSkillId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profileSkill"));
		$this->assertEquals($pdoProfileSkill->getProfileSkillProfileId(), $this->getProfileSkillProfileId());
		$this->assertEquals($pdoProfileSkill->getProfileSkillSkillId(), $this->getProfileSkillSkillId());
	}

	/**
	 * test getting profile skills by skill id
	 */
	public function testGetProfileSkillByProfileSkillSkillId(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profileSkill");
		// create a new Profile Skill and insert into mySQL
		$profileSkill = new ProfileSkill($this->profile->getProfileId(), $this->skill->getSkillId());
		$profileSkill->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = ProfileSkill::getProfileSkillsByProfileSkillSkillId($this->getPDO(), $this->profile->getProfileId(), $this->skill->getSkillId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profileSkill"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DeepDiveTutor\\profileSkill", $results);
		// grab the result from the array and validate it
		$pdoProfileSkill = $results[0];
		$this->assertEquals($pdoProfileSkill->getProfileSkillProfileId(), $this->getProfileSkillProfileId());
		$this->assertEquals($pdoProfileSkill->getProfileSkillSkillId(), $this->getProfileSkillSkillId());
	}

	/**
	 * test getting profile skill by profile id
	 */
	public function testGetProfileSkillByProfileSkillProfileId(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profileSkill");
		// create a new Profile Skill and insert into mySQL
		$profileSkill = new ProfileSkill($this->profile->getProfileId(), $this->skill->getSkillId());
		$profileSkill->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = ProfileSkill::getProfileSkillsByProfileSkillProfileId($this->getPDO(), $this->profile->getProfileId(), $this->skill->getSkillId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profileSkill"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DeepDiveTutor\\profileSkill", $results);
		// grab the result from the array and validate it
		$pdoProfileSkill = $results[0];
		$this->assertEquals($pdoProfileSkill->getProfileSkillProfileId(), $this->getProfileSkillProfileId());
		$this->assertEquals($pdoProfileSkill->getProfileSkillSkillId(), $this->getProfileSkillSkillId());
	}


	/**
	 * test getting a profile skill that does not exist by skill id
	 */
	public function testGetInvalidProfileSkillByProfileSkillProfileId(): void {
		// grab a profile skill id that exceeds the maximum allowable profile skill id
		$profileSkill = ProfileSkill::getProfileSkillsByProfileSkillProfileId($this->getPDO(), DeepDiveTutorTest::INVALID_KEY);
		$this->assertCount(0, $profileSkill);
	}

	/**
	 * test getting a profile skill that does not exist by profile id
	 */
	public function testGetInvalidProfileSkillByProfileSkillSkillId(): void {
		// grab a profile skill id that exceeds the maximum allowable profile skill id
		$profileSkill = ProfileSkill::getProfileSkillsByProfileSkillSkillId($this->getPDO(), DeepDiveTutorTest::INVALID_KEY);
		$this->assertCount(0, $profileSkill);
	}

}