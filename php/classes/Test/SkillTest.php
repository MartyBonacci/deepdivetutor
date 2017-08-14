<?php
namespace Edu\Cnm\DeepDiveTutor\Test;
use Edu\Cnm\DeepDiveTutor\{
	Skill
};
use Zend\Stdlib\DateTime;

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
	protected $skill;

	protected $VALID_GREAT_SKILL = "HTML";
	/*
	 *	Test to make sure \RangeException throws an error

	protected $VALID_GREAT_SKILL1 = "there are too many appleseeds in an apple!  -i dont know";
	/*
	 *Test to make sure \TypeException throws an error

	protected $VALID_GREAT_SKILL2 = "1234438282828";
	/**
	 * @var string check to see if it returns back empty error

	protected $VALID_GREAT_SKILL3 = "";
	**/
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
	public function testValidSkillInsert(): void {
		$numRows = $this->getConnection()->getRowCount("skill");

		//create the skill object
		$skill = new Skill(null, $this->VALID_GREAT_SKILL);
		$skill->insert($this->getPDO());
		//grab data from mySQL and enforce that it meets expectations
		$pdoSkill = Skill::getSkillNameBySkillId($this->getPDO(), $skill->getSkillId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("skill"));
		$this->assertEquals($pdoSkill->getSkillId(), $skill->getSkillId());
		$this->assertEquals($pdoSkill->getSkillName(), $skill->getSkillName());

	}

	/**
	 * test inserting a Skill that already exit
	 * @expectedException  \PDOException
	 */

	public function testInvalidSkillInsert(): void {
		//create a invalid  object and try and insert it into the database
		$skill = new Skill(DeepDiveTutorTest::INVALID_KEY, $this->VALID_GREAT_SKILL);
		$skill->insert($this->getPDO());
	}

	/**
	 * test inserting a skill and regrabbing it from mySQL
	 */

	public function testGetValidSkillBySkillId(): void{
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("skill");

		//create a new Skill and Insert into mySQL
		$skill = new Skill(null, $this-> VALID_GREAT_SKILL);
		$skill->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields to match expectations
		$pdoSkill = Skill::getSkillNameBySkillId($this->getPDO(),$skill->getSkillId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("skill"));
		$this->assertEquals($pdoSkill->getSkillName(),$this->VALID_GREAT_SKILL);
	}



	//grab the skillName by an invalid key
	public function testInvalidGetBySkillId(): void {
		$skill = Skill::getSkillNameBySkillId($this->getPDO(), DeepDiveTutorTest::INVALID_KEY);
		$this->assertEmpty($skill);
	}

	/**
	 * Test Grabing all tweets
	 */
	public function testGetAllSkillNames(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("skill");

		//insert skillName into database
		$skill = new Skill(null, $this->VALID_GREAT_SKILL);

		//insert the skill into the database
		$skill->insert($this->getPDO());

		//grab the results from mySQL and enforce it meets expectations
		$results = Skill::getAllSkillNames($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("skill"));
		$this->assertCount(1, $results);
		//$this->assertContainsOnlyIstancesOf("Edu\\Cnm\\DeepDiveTutor\\Skill", $results);

		//grab the results from the array and make sure it meets expectations
		$pdoSkill = $results[0];
		$this->assertEquals($pdoSkill->getSkillName(), $skill->getSkillName());


	}
}
