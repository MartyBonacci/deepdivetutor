<?php

namespace Edu\Cnm\DeepDiveTutor;
require_once("autoload.php");

/**
 * Class Skill
 * calling skill table, and defining restrictions on type to pushed through and validated is not validated will throw errors
 *
 * Created by PhpStorm.
 * User:George
 * Date:8/10/2017
 * Time: 10:08 AM
 */
class Skill implements \JsonSerializable {
	/**
	 * primary key of the skill
	 * @var $skilllId int
	 */
	private $skillId;
	/**
	 * houses names of the skills specified by admin
	 * @var string $skillName
	 */
	private $skillName;

	/**
	 * Skill constructor I.E the method that creates the quote object.
	 *
	 * @param int|null $newSkillId test id of skill or null  if the task is a new insert
	 * @param string $newSkillName test if this skill id is a string, if it holds under the 32 character limit, and if its an empty value
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data value is out of bounds
	 * @throws \Exception if some other exception occurs
	 * @throw \TypeError if data types violate type hints
	 */
	public function __construct(?int $newSkillId, string $newSkillName) {
		try {
			$this->setSkillId($newSkillId);
			$this->setSkillName($newSkillName);
		} catch(\InvalidArgumentException| \RangeException |\Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for skillId
	 * @return int|null value of skillId, main identifier for a specific quoute object.
	 */
	public function getSkillId(): int {
		return ($this->skillId);
	}

	/**
	 * mutator method for the skill ID
	 * @param int|null $newSkillId value of primary key for quote id.
	 * @throws \RangeException if the key is negative  throw error
	 */
	public function setSkillId(int $newSkillId = null): void {
		//Checks to see if the key is null. if it is null it is a new object and needs to be inserted into the database
		if($newSkillId === null) {
			$this->skillId = null;
			return;
		}
		//Enforce that the key is positive, if not throw range exception
		if($newSkillId <= 0) {
			throw(new \RangeException("This Skill Id is not positive"));
		}
		$this->skillId = $newSkillId;
	}

	/**
	 * accesor method for skillName since acdirectly comunicates with the database no sanitation is needed
	 * @return string $skillName the actuall  skillName  that was posted
	 */
	public function getSkillName(): string {
		return ($this->skillName);
	}

	/**
	 * Mutator method for SkillName
	 * @param $newSkillName string value for the quote in question
	 * @throws \RangeException will be thrown if skilll is too long
	 * @thros \RangeException: thrown if it wont fit the database
	 */
	public function setSkillName(string $newSkillName): void {
		$newSkillName = trim($newSkillName);
		$newSkillName = filter_var($newSkillName, FILTER_SANITIZE_STRING);
		if(empty($newSkillName) === true) {
			throw(new \InvalidArgumentException("The Skill Name is Empty!"));
		}
		if(strlen($newSkillName) > 32) {
			throw(new \RangeException("Skill Name is Too Looooong!"));
		}
		$this->skillName = $newSkillName;
	}

	/**
	 * insert method to insert dynamic values into place holders
	 * @param \PDO $pdo PDO connection object
	 * @throws \TypeError thrown if $pdo is not a connection object
	 * @throws \PDOException if mySQl related errors occur
	 *
	 */
	public function insert(\PDO $pdo): void {
		if($this->skillId !== null) {
			throw(new \PDOException("Not A New Skill"));
		}
		//create query template
		$query = "INSERT INTO skill(skillName) VALUE (:skillName)";
		$statement = $pdo->prepare($query);
		//bind the member variables to the placeholder template
		$parameters = ["skillName" => $this->skillName];
		$statement->execute($parameters);
		$this->skillId = intval($pdo->lastInsertId());
	}

	/**
	 * @param \PDO $pdo pulling data from database and filling them into variables
	 * @param int $skillId is being defined and constricted to an int value to be used to call an array of data
	 * @return \SplFixedArray is returning the skill names
	 * @throws \TypeError when variables are not the correct data
	 * @throws\PDOException when mySQL related errors occurs
	 */
	public static function getSkillNameBySkillId(\PDO $pdo, int $skillId): ?Skill {
		if($skillId <= 0) {
			throw(new \RangeException("SkillId Must be positive"));
		}
		//create query template
		$query = "SELECT skillId, skillName FROM skill WHERE skillId = :skillId";
		$statement = $pdo->prepare($query);
		//bind the skill id to the place holder in the template
		$parameters = ["skillId" => $skillId];
		$statement->execute($parameters);
		//grab skillName from mySQl
		try {
			$skills = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$skills = new Skill($row["skillId"], $row["skillName"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($skills);
	}

	public static function getAllSkillNames(\PDO $Pdo): \SplFixedArray {
		//create query template
		$query = "SELECT skillId, skillName FROM skill";
		$statement = $pdo->prepare($query);
		$statement->execute();
		//build and array of skills
		$skills = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$skill = new Skill($row["skillId"], $row["skillName"]);
				$skills[$skills->key()] = $skill;
				$skills->next();
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($skills);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 *
	 * @return array resultin state variables to serialize
	 */
	public function jsonSerialize() {
		return (get_object_vars($this));
	}

}
