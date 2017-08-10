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
	 * @var ProfileSkillProfileId profile id
	 **/
	protected $profileSkillProfileId = null;

	/**
	 * Skill associated with a Profile; this is for foreign key relations
	 * @var profileSkillSkillId skill id
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
		$this->profile = new profile(null, "Billy Bob", "billy@bob.com", 1, "aksjdhfg872346sdjfg", "I'm super awesome! Pick me!", 99.99, "awesomepic.jpg", $this->profileLastEditDateTime, "aksjfgasdjkhf892345747956", $this->profileHash, "+12125551212", $this->profileSalt);
		$this->profile->insert($this->getPDO());
		// create the and insert the mocked skill
		$this->skill = new skill(null, "JavaScript");
		$this->skill->insert($this->getPDO());
		// calculate the date (just use the time the unit test was setup...)
		$this->profileLastEditDateTime = new \DateTime();
	}


}