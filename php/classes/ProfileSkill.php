<?php
namespace Edu\Cnm\DataDesign;

require_once("autoload.php");
/*item class*/
/**
 * Create profileSkill class
 *
 * This creates a weak class profileSkill
 *
 * @author MartyBonacci <mbonacci@@cnm.edu>
 * @version 1.0.0
 **/
class profileSkill implements \JsonSerializable {

	/**
	 * FOREIGN KEY for profile (profileId),
	 * @var int $profileSkillprofileId
	 **/
	private $profileSkillprofileId;
	/**
	 * FOREIGN KEY for skill (skillId)
	 * @var int $profileSkillSkillId
	 **/
	private $profileSkillSkillId;

	/**
	 * constructor for this profileSkill
	 *
	 * @param int $newprofileSkillprofileId of the profile that has the skill
	 * @param int $newprofileSkillSkillId of the skill that the profile has
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(?int $newprofileSkillprofileId, int $newprofileSkillSkillId) {
		try {
			$this->setprofileSkillprofileId($newprofileSkillprofileId);
			$this->setprofileSkillSkillId($newprofileSkillSkillId);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 * accessor method for FOREIGN KEY for profile (profileId)
	 *
	 * @return int value of FOREIGN KEY for profile (profileId)
	 **/
	public function getprofileSkillprofileId() : int{
		return($this->profileSkillprofileId);
	}

	/**
	 * mutator method for FOREIGN KEY for profile (profileId)
	 *
	 * @param int $newprofileSkillprofileId new value of FOREIGN KEY for profile (profileId)
	 * @throws \RangeException if $newPprofileSkillprofileId is not positive
	 * @throws \TypeError if $newprofileSkillprofileId is not an integer
	 **/
	public function setprofileSkillprofileId(int $newprofileSkillprofileId) : void {

		// verify the profile id is positive
		if($newprofileSkillprofileId <= 0) {
			throw(new \RangeException("tweet profile id is not positive"));
		}

		// convert and store the profile id
		$this->profileSkillprofileId = $newprofileSkillprofileId;
	}






	/**
	 * accessor method for FOREIGN KEY for skill (skillId)
	 *
	 * @return int value of FOREIGN KEY for skill (skillId)
	 **/
	public function getprofileSkillSkillId() : int{
		return($this->profileSkillSkillId);
	}

	/**
	 * mutator method for FOREIGN KEY for skill (skillId)
	 *
	 * @param int $newprofileSkillSkillId new value of profileSkillSkillId
	 * @throws \RangeException if $newprofileSkillSkillId is not positive
	 * @throws \TypeError if $newprofileSkillSkillId is not an integer
	 **/
	public function setprofileSkillSkillId(int $newprofileSkillSkillId) : void {

		// verify the skill id is positive
		if($newprofileSkillSkillId <= 0) {
			throw(new \RangeException("tweet profile id is not positive"));
		}

		// convert and store the skill id
		$this->profileSkillSkillId = $newprofileSkillSkillId;
	}



















	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		//format the date so that the front end can consume it
		$fields["tweetDate"] = round(floatval($this->tweetDate->format("U.u")) * 1000);
		return($fields);
	}
}

