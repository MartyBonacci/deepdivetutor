<?php
namespace Edu\Cnm\DeepDiveTutor\Test;

use Edu\Cnm\DeepDiveTutor\{Profile, Skill, ProfileSkill};

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
class ProfileSkill extends DataDesignTest {
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
}