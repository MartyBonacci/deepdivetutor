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
	 * @var int $profileSkillProfileId
	 **/
	private $profileSkillProfileId;
	/**
	 * FOREIGN KEY for skill (skillId)
	 * @var int $profileSkillSkillId
	 **/
	private $profileSkillSkillId;

	/**
	 * constructor for this profileSkill
	 *
	 * @param int and not null $newProfileSkillProfileId of the profile that has the skill
	 * @param int and not null $newProfileSkillSkillId of the skill that the profile has
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(?int $newProfileSkillProfileId, int $newProfileSkillSkillId) {
		try {
			$this->setProfileSkillProfileId($newProfileSkillProfileId);
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
	public function getProfileSkillProfileId(): int {
		return ($this->profileSkillProfileId);
	}

	/**
	 * mutator method for FOREIGN KEY for profile (profileId)
	 *
	 * @param int $newProfileSkillProfileId new value of FOREIGN KEY for profile (profileId)
	 * @throws \RangeException if $newProfileSkillProfileId is not positive
	 * @throws \TypeError if $newProfileSkillProfileId is not an integer
	 **/
	public function setProfileSkillProfileId(int $newProfileSkillProfileId): void {

		// verify the profile id is positive
		if($newProfileSkillProfileId <= 0) {
			throw(new \RangeException("skill profile id is not positive"));
		}

		// convert and store the profile id
		$this->profileSkillProfileId = $newProfileSkillProfileId;
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
		if($this->profileSkillProfileId === null) {
			throw(new \PDOException("unable to insert because profileSkillProfileId null"));
		}
		if($this->profileSkillSkillId === null) {
			throw(new \PDOException("unable to insert because profileSkillSkillId null"));
		}


		// create query template
		$query = "INSERT INTO profileSkill(profileSkillProfileId, profileSkillSkillId) VALUES(:profileSkillProfileId, :profileSkillSkillId)";
		$statement = $pdo->prepare($query);

		$parameters = ["profileSkillProfileId" => $this->profileSkillProfileId, "profileSkillSkillId" => $this->profileSkillSkillId];
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
		if($this->profileSkillProfileId === null) {
			throw(new \PDOException("unable to delete because profileSkillProfileId null"));
		}
		if($this->profileSkillSkillId === null) {
			throw(new \PDOException("unable to delete because profileSkillSkillId null"));
		}

		// create query template
		$query = "DELETE FROM profileSkill WHERE profileSkillProfileId = :profileSkillProfileId && profileSkillSkillId =:profileSkillSkillId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["profileSkillProfileId" => $this->profileSkillProfileId, "profileSkillSkillId" => $this->profileSkillSkillId];
		$statement->execute($parameters);
	}


	/**
	 * gets the profileSkills by profileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $profileSkillProfileId profile id to search for
	 * @return profileSkillSkillId|null profile id found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileSkillsByProfileSkillProfileId(\PDO $pdo, int $profileSkillProfileId) {
		// sanitize the profileSkillProfileId before searching
		if($profileSkillProfileId <= 0) {
			throw(new \PDOException("profileSkillProfileId id is not positive"));
		}

		// create query template
		$query = "SELECT profileSkillProfileId, profileSkillSkillId FROM profileSkill WHERE profileSkillProfileId = :profileSkillProfileId";
		$statement = $pdo->prepare($query);

		// bind the profileId to the place holder in the template
		$parameters = ["profileSkillProfileId" => $profileSkillProfileId];
		$statement->execute($parameters);

		//build an array of profileSkills
		$profileSkills = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			// grab the profileSkill from mySQL
			try {
				$profileSkill = new ProfileSkill($row["profileSkillProfileId"], $row["profileSkillSkillId"]);
				$profileSkills[$profileSkills->key()] = $profileSkill;
				$profileSkills->next();

			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			return ($profileSkills);
		}
	}

	/**
	 * gets the profileSkills by skillId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $profileSkillSkillId profile id to search for
	 * @return profileSkillProfileId|null profile id found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileSkillsByProfileSkillSkillId(\PDO $pdo, int $profileSkillSkillId) {
		// sanitize the profileSkillSkillId before searching
		if($profileSkillSkillId <= 0) {
			throw(new \PDOException("profileSkillSkillId id is not positive"));
		}

		// create query template
		$query = "SELECT profileSkillProfileId, profileSkillSkillId FROM profileSkill WHERE profileSkillSkillId = :profileSkillSkillId";
		$statement = $pdo->prepare($query);

		// bind the profileId to the place holder in the template
		$parameters = ["profileSkillSkillId" => $profileSkillSkillId];
		$statement->execute($parameters);

		//build an array of profileSkills
		$profileSkills = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			// grab the profileSkill from mySQL
			try {
				$profileSkill = new ProfileSkill($row["profileSkillProfileId"], $row["profileSkillSkillId"]);
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

