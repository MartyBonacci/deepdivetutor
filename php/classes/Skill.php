<?php

namespace EDU\CNM\DeepDiveTutor;
require_once("autoload.php");

/**
 * Class Skill
 * calling skill table, and defining restrictions on type to pushed through and validated is not validated will throw errors
 */



class Skill implements \JsonSerializable {
	/**
	 * @var skillId is an int its the id of the skill ; a primary key
	 */
	private $skillId;
	/**
	 * @var skillName is a string it will actually house the names of the skills specified by admin;
	 */
	private $skillName;

	/**
	 * Skill constructor.
	 * @param int|null $newSkillId test if this skill id is null or an int
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
	 * @return int|null value of skillId
	 */
	public function getSkillId(): int {
		return $this->skillId;
	}

	/**
	 * @param \RangeException
	 * $skillId is being set through place holder $newSkillId and checked to see if interger is less than or equal to zero
	 * if it is then an error is thrown because of invalid range.
	 */
	public function setSkillId(int $newSkillId): void {
		if($newSkillId <= 0) {
			throw(new \RangeException("This Skill Id is not positive"));
		}
		$this->skillId = $newSkillId;
	}

	/**
	 * @return skillName String
	 * we are grabing the  collumn skillName from the variable skillName
	 */
	public function getSkillName(): string {
		return $this->skillName;
	}

	/**
	 * @param string $newSkillName is being tested for \InvalidArgumentException and \RangeException
	 * @param \RangeException will be thrown if skilll is too long
	 */
	public function setSkillName(string $newSkillName): void {
		$newSkillName = trim($newSkillName);
		$newSkillName = filter_var($newSkillName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
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
	 * @throws \TypeError thrown if $pdo is not a connection object
	 * @throws \PDOException if mySQl related errors occur
	 * @param \PDO $pdo PDO connection object
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
	public static function getSkillNameBySkillId(\PDO $pdo, int $skillId): \SPLFixedArray {
		if($skillId <= 0) {
			throw(new \RangeException("SkillId Must be positive"));
		}
		$query = "SELECT skillId, skillName from skill where skillId = :skillId";
		$statement = $pdo->prepare($query);
		$parameters = ["skillId" => $skillId];
		$statement->execute($parameters);
		$skills = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$skills = new Skill($row["skillId"], $row["skillName"]);
				$skills[$skills->key()] = $skills;
				$skills->next();
			} catch(\Exception $exception) {
				throw (new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($skills);
	}

		public function jsonSerialize() {
			return (get_object_vars($this));
		}

}
