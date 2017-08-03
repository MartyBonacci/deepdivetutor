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
class profileSkill {

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
	 * @param int $newProfileSkillprofileId of the profile that has the skill
	 * @param int $newProfileSkillSkillId of the skill that the profile has
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(?int $newProfileSkillprofileId, int $newProfileSkillSkillId) {
		try {
			$this->setProfileSkillprofileId($newProfileSkillprofileId);
			$this->setProfileSkillSkillId($newProfileSkillSkillId);
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
	public function getProfileSkillprofileId() : int{
		return($this->profileSkillprofileId);
	}

	/**
	 * mutator method for FOREIGN KEY for profile (profileId)
	 *
	 * @param int $newProfileSkillprofileId new value of FOREIGN KEY for profile (profileId)
	 * @throws \RangeException if $newProfileSkillprofileId is not positive
	 * @throws \TypeError if $newProfileSkillprofileId is not an integer
	 **/
	public function setProfileSkillprofileId(int $newProfileSkillprofileId) : void {

		// verify the profile id is positive
		if($newProfileSkillprofileId <= 0) {
			throw(new \RangeException("skill profile id is not positive"));
		}

		// convert and store the profile id
		$this->profileSkillprofileId = $newProfileSkillprofileId;
	}






	/**
	 * accessor method for FOREIGN KEY for skill (skillId)
	 *
	 * @return int value of FOREIGN KEY for skill (skillId)
	 **/
	public function getProfileSkillSkillId() : int{
		return($this->profileSkillSkillId);
	}

	/**
	 * mutator method for FOREIGN KEY for skill (skillId)
	 *
	 * @param int $newProfileSkillSkillId new value of profileSkillSkillId
	 * @throws \RangeException if $newProfileSkillSkillId is not positive
	 * @throws \TypeError if $newProfileSkillSkillId is not an integer
	 **/
	public function setProfileSkillSkillId(int $newProfileSkillSkillId) : void {

		// verify the skill id is positive
		if($newProfileSkillSkillId <= 0) {
			throw(new \RangeException("profile skill id is not positive"));
		}

		// convert and store the skill id
		$this->profileSkillSkillId = $newProfileSkillSkillId;
	}















}

