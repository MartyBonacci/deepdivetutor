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
	 * @param int and not null $newProfileSkillprofileId of the profile that has the skill
	 * @param int and not null $newProfileSkillSkillId of the skill that the profile has
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
		} //determine what exception type was thrown
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
	public function getProfileSkillprofileId(): int {
		return ($this->profileSkillprofileId);
	}

	/**
	 * mutator method for FOREIGN KEY for profile (profileId)
	 *
	 * @param int $newProfileSkillprofileId new value of FOREIGN KEY for profile (profileId)
	 * @throws \RangeException if $newProfileSkillprofileId is not positive
	 * @throws \TypeError if $newProfileSkillprofileId is not an integer
	 **/
	public function setProfileSkillprofileId(int $newProfileSkillprofileId): void {

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
	public function getProfileSkillSkillId(): int {
		return ($this->profileSkillSkillId);
	}

	/**
	 * mutator method for FOREIGN KEY for skill (skillId)
	 *
	 * @param int $newProfileSkillSkillId new value of profileSkillSkillId
	 * @throws \RangeException if $newProfileSkillSkillId is not positive
	 * @throws \TypeError if $newProfileSkillSkillId is not an integer
	 **/
	public function setProfileSkillSkillId(int $newProfileSkillSkillId): void {


		// verify the skill id is positive
		if($newProfileSkillSkillId <= 0) {
			throw(new \RangeException("profile skill id is not positive"));
		}

		// convert and store the skill id
		$this->profileSkillSkillId = $newProfileSkillSkillId;
	}


	/**
	 * inserts this profileSkill into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {

		//throw an exception if either foreign key is null
		if($this->profileSkillprofileId === null) {
			throw(new \PDOException("unable to insert because profileSkillprofileId null"));
		}
		if($this->profileSkillSkillId === null) {
			throw(new \PDOException("unable to insert because profileSkillSkillId null"));
		}


		// create query template
		$query = "INSERT INTO profileSkill(profileSkillprofileId, profileSkillSkillId) VALUES(:profileSkillprofileId, :profileSkillSkillId)";
		$statement = $pdo->prepare($query);

		$parameters = ["profileSkillprofileId" => $this->profileSkillprofileId, "profileSkillSkillId" => $this->profileSkillSkillId];
		$statement->execute($parameters);
	}


	/**
	 * deletes this profileSkill from mySQL by both foreign keys
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		//throw an exception if either foreign key is null
		if($this->profileSkillprofileId === null) {
			throw(new \PDOException("unable to delete because profileSkillprofileId null"));
		}
		if($this->profileSkillSkillId === null) {
			throw(new \PDOException("unable to delete because profileSkillSkillId null"));
		}

		// create query template
		$query = "DELETE FROM profileSkill WHERE profileSkillprofileId = :profileSkillprofileId && profileSkillSkillId =:profileSkillSkillId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["profileSkillprofileId" => $this->profileSkillprofileId, "profileSkillSkillId" => $this->profileSkillSkillId];
		$statement->execute($parameters);
	}


	/**
	 * deletes this profileSkill from mySQL by profileSkillprofileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		//throw an exception if either foreign key is null
		if($this->profileSkillprofileId === null) {
			throw(new \PDOException("unable to delete because profileSkillprofileId null"));
		}


		// create query template
		$query = "DELETE FROM profileSkill WHERE profileSkillprofileId = :profileSkillprofileId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["profileSkillprofileId" => $this->profileSkillprofileId];
		$statement->execute($parameters);
	}


	/**
	 * gets the profileSkills by profileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $profileSkillprofileId profile id to search for
	 * @return profileSkillprofileId|null profile id found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileSkillsByProfileSkillprofileId(\PDO $pdo, int $profileSkillprofileId) {
		// sanitize the profileSkillprofileId before searching
		if($profileSkillprofileId <= 0) {
			throw(new \PDOException("profileSkillprofileId id is not positive"));
		}

		// create query template
		$query = "SELECT profileSkillprofileId, profileSkillSkillId FROM profileSkill WHERE profileSkillprofileId = :profileSkillprofileId";
		$statement = $pdo->prepare($query);

		// bind the profileId to the place holder in the template
		$parameters = ["profileSkillprofileId" => $profileSkillprofileId];
		$statement->execute($parameters);

		//build an array of profileSkills
		$profileSkills = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			// grab the profileSkill from mySQL
			try {
				$profileSkill = newprofileSkill($row["profileSkillProfileId"], $row["profileSkillSkillId"]);
				$profileSkills[$profileSkills->key()] = $profileSkill;
				$profileSkills->next();

			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			return ($profileSkills);
		}
	}

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}
}

