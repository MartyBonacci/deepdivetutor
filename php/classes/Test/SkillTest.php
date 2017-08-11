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
	protected $VALID_GREAT_SKILL1 = "there are too many appleseeds in an apple!  -i dont know";
	/*
	 *Test to make sure \TypeException throws an error
	 */
	protected $VALID_GREAT_SKILL2 = "1234438282828";
	/**
	 * @var string check to see if it returns back empty error
	 */
	protected $VALID_GREAT_SKILL3 = "";

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
		$skill = new Skill(null, $this->VALID_GREAT_SKILL, $this->VALID_GREAT_SKILL1, $this->VALID_GREAT_SKILL2, $this->VALID_GREAT_SKILL3);
		$skill->insert($this->getPDO());
		$pdoSkill = Skill::getSkillNameBySkillId($this->getPDO(), $skill->getSkillId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("skill"));
		$this->assertEquals($pdoSkill->getSkillId(), $skill->getSkillId());
		$this->assertEquals($pdoSkill->getSkillName(), $skill->getSkillName());

	}
	public function testInvalidQuoteInsert(){
		//create a invalid quote object and try and insert it into the database
		$skill = new Skill(DeepDiveTutorTest::INVALID_KEY,$this->VALID_GREAT_SKILL, $this->VALID_GREAT_SKILL1, $this->VALID_GREAT_SKILL2, $this->VALID_GREAT_SKILL3);
		$skill->insert($this->getPDO());
	}

	/**
	 * test inserting a skill and regrabbing it from mySQL
	 */
	public function testGetValidSkillNameBySkillId(): void {
		//count the number of Rows and save it for later
		$numRows = $this->getConnection()->getRowCount("skill");

		//create a new Skill and insert to into mySql
		$skill = new Skill(null,$this->profile->getSkillID(), $this->VALID_GREAT_SKILL);
		$skill->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results= Skill::getSkillNameBySkillId($this->getPDO(), $skill->getSkillId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("skill"));
		$this->assertCount(1,$results);
		$this->assertContainsOnlyIntancesOf("Edu\\Cnm\\DeepDiveTutor\\Skill", $results);

		//grab the reslut from the array and validate it
		$pdoSkill = $results[0];
		$this->assertEquals($pdoSkill->getSkillId(), $this->skill->getSkillId());
		$this->assertEquals($podSkill->getSkillName(),$this->VALID_GREAT_SKILL);

	}
//grab the skillName by an invalid key
	public function testInvalidGetBySkillId() : void{
		$skill = Skill::getSkillNameBySkillId($this->getPDO(),DeepDiveTutorTest::INVALID_KEY);
		$this->assertEmpty($skill);
		$this->assertCount(0,$skill);
	}

	public function testGetAllSkillNames() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("skill");

		//insert skillName into database
		$skill = new Skill(null, $this->VALID_GREAT_SKILL);

		//insert the skill into the database
		$skill-> insert($this->getPDO());

		//grab the results from mySQL and enforce it meets expectations
		$results = Skill::getAllSkillNames($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("skill"));
		$this->assertCount(1, $results);
		$this->>assertContainsOnlyIstancesOf("Edu\\Cnm\\DeepDiveTutor\\Skill", $results);

		//grab the results from the array and make sure it meets expectations
		$pdoSkill = $results[0];
		$this->assertEquals($pdoSkill->getSkillName(),$skill->getSkillName());
	}

}
