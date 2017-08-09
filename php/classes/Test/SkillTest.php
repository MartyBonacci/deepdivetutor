<?php
namespace Edu\Cnm\DeepDiveTutor\Test;
use Edu\Cnm\DeepDiveTutor\{
	Skill
};

require_once(dirname(__DIR__) . "/autoload.php");
/**
 * Class SkillTest
 * @package Edu\Cnm\DeepDiveTutor\Skill\Test
 */

class SkillTest extends DeepDiveTutorTest {
	/**
	 * Test to make sure the correct data doesn't throw errors
	 * @var string $VALID_GREAT_SKILL
	 */
	protected $skill = null;

	protected $VALID_GREAT_SKILL = "HTML";
	/*
	 *	Test to make sure \RangeException throws an error
	 */
	//protected $VALID_GREAT_SKILL1 = "there are too many appleseeds in an apple!  -i dont know";
	/*
	 *Test to make sure \TypeException throws an error
	 */
	//protected $VALID_GREAT_SKILL2 = "1234438282828";
	/**
	 * @var string check to see if it returns back empty error
	 */
	//protected $VALID_GREAT_SKILL3 = "";

	/**
	 * create all dependent objects so that the test can run properly
	 */
	public function setUp() {
		//run the setup method so the test can run properly
		//this is where all dependencies would be squashed so the test could be run properly
		parent::setUp();

	}

	/**
	 * perform the actual insert method and enforce that it meets expectations
	 */
	public function testValidSkillInsert() {
		$numRows = $this->getConnection()->getRowCount("skill");

		//create the skill object
		$skill = new Skill(null, $this->VALID_GREAT_SKILL/**, $this->VALID_GREAT_SKILL1, $this->VALID_GREAT_SKILL2, $this->VALID_GREAT_SKILL3**/);
		$skill->insert($this->getPDO());
		$pdoSkill = Skill::getSkillNameBySkillId($this->getPDO(), $skill->getSkillId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("skill"));
		$this->assertEquals($pdoSkill->getSkillId(), $skill->getSkillId());
		$this->assertEquals($pdoSkill->getSkillName(), $skill->getSkillName());

	}
}
