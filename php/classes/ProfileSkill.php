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
		if($this->profileSkillprofileId === null || $this->profileSkillSkillId === null) {
			throw(new \PDOException("not a new profileSkillprofileId or profileSkillSkillId"));
		}



		// create query template
		$query = "INSERT INTO profileSkill(profileSkillprofileId, profileSkillSkillId) VALUES(:profileSkillprofileId, :profileSkillSkillId)";
		$statement = $pdo->prepare($query);

		$parameters = ["profileSkillprofileId" => $this->profileSkillprofileId, "profileSkillSkillId" => $this->profileSkillSkillId];
		$statement->execute($parameters);
	}











	/**
	 * deletes this Tweet from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		// enforce the tweetId is not null (i.e., don't delete a tweet that hasn't been inserted)
		if($this->tweetId === null) {
			throw(new \PDOException("unable to delete a tweet that does not exist"));
		}

		// create query template
		$query = "DELETE FROM tweet WHERE tweetId = :tweetId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["tweetId" => $this->tweetId];
		$statement->execute($parameters);
	}

	/**
	 * updates this Tweet in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo): void {
		// enforce the tweetId is not null (i.e., don't update a tweet that hasn't been inserted)
		if($this->tweetId === null) {
			throw(new \PDOException("unable to update a tweet that does not exist"));
		}

		// create query template
		$query = "UPDATE tweet SET tweetProfileId = :tweetProfileId, tweetContent = :tweetContent, tweetDate = :tweetDate WHERE tweetId = :tweetId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->tweetDate->format("Y-m-d H:i:s.u");
		$parameters = ["tweetProfileId" => $this->tweetProfileId, "tweetContent" => $this->tweetContent, "tweetDate" => $formattedDate, "tweetId" => $this->tweetId];
		$statement->execute($parameters);
	}

	/**
	 * gets the Tweet by tweetId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $tweetId tweet id to search for
	 * @return Tweet|null Tweet found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getTweetByTweetId(\PDO $pdo, int $tweetId): ?Tweet {
		// sanitize the tweetId before searching
		if($tweetId <= 0) {
			throw(new \PDOException("tweet id is not positive"));
		}

		// create query template
		$query = "SELECT tweetId, tweetProfileId, tweetContent, tweetDate FROM tweet WHERE tweetId = :tweetId";
		$statement = $pdo->prepare($query);

		// bind the tweet id to the place holder in the template
		$parameters = ["tweetId" => $tweetId];
		$statement->execute($parameters);

		// grab the tweet from mySQL
		try {
			$tweet = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$tweet = new Tweet($row["tweetId"], $row["tweetProfileId"], $row["tweetContent"], $row["tweetDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($tweet);
	}

	/**
	 * gets the Tweet by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $tweetProfileId profile id to search by
	 * @return \SplFixedArray SplFixedArray of Tweets found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getTweetByTweetProfileId(\PDO $pdo, int $tweetProfileId): \SPLFixedArray {
		// sanitize the profile id before searching
		if($tweetProfileId <= 0) {
			throw(new \RangeException("tweet profile id must be positive"));
		}
		// create query template
		$query = "SELECT tweetId, tweetProfileId, tweetContent, tweetDate FROM tweet WHERE tweetProfileId = :tweetProfileId";
		$statement = $pdo->prepare($query);
		// bind the tweet profile id to the place holder in the template
		$parameters = ["tweetProfileId" => $tweetProfileId];
		$statement->execute($parameters);
		// build an array of tweets
		$tweets = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$tweet = new Tweet($row["tweetId"], $row["tweetProfileId"], $row["tweetContent"], $row["tweetDate"]);
				$tweets[$tweets->key()] = $tweet;
				$tweets->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($tweets);
	}

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}
}

