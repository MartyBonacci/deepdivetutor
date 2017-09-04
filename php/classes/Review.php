<?php

namespace Edu\Cnm\DeepDiveTutor;

require_once("autoload.php");

/**
 * <h1>deep dive tutor</h1>
 * @author Timothy Williams <tkotalik@cnm.edu>
 * @version 1.0
 **/
class Review implements \JsonSerializable {
	use ValidateDate;
	/**
	 * primary key for profileId
	 * @var int reviewId
	 **/
	private $reviewId;
	/**
	 * id of the student that saved this index.php; this is a foreign key
	 * @var int $reviewStudentProfileId
	 **/
	private $reviewStudentProfileId;
	/**
	 * id of the tutor that saved this index.php; this is a foreign key
	 * @var int $reviewTutorProfileId
	 **/
	private $reviewTutorProfileId;
	/**
	 * actual rating of tutor
	 * @var int $reviewRating
	 **/
	private $reviewRating;
	/**
	 * actual text of index.php
	 * @var string $reviewText
	 **/
	private $reviewText;
	/**
	 * date and time index.php was submitted in a PHP DateTime object
	 * @var \DateTime $reviewDateTime
	 **/
	private $reviewDateTime;

	/**
	 * constructor
	 *
	 * @param int|null $newReviewId of this index.php or null if a new index.php
	 * @param int $newReviewStudentProfileId id of the student that saved this index.php
	 * @param int $newReviewTutorProfileId id of the tutor that saved this index.php
	 * @param int $newReviewRating int containing rating number
	 * @param string $newReviewText string containing actual index.php text
	 * @param \DateTime $newReviewDateTime DateTime of when index.php was made
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers, negative floats)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @documentation https://php.net/manual/en.language.oop5.decon.php
	 **/

	public function __construct(?int $newReviewId, int $newReviewStudentProfileId, int $newReviewTutorProfileId,
										 int $newReviewRating, string $newReviewText, $newReviewDateTime = null) {
		try {
			$this->setReviewId($newReviewId);
			$this->setReviewStudentProfileId($newReviewStudentProfileId);
			$this->setReviewTutorProfileId($newReviewTutorProfileId);
			$this->setReviewRating($newReviewRating);
			$this->setReviewText($newReviewText);
			$this->setReviewDateTime($newReviewDateTime);

		} // determine what exception was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for item id
	 * @return int|null value of item id
	 **/
	public function getReviewId() : ?int {
		return ($this->reviewId);
	}

	/**
	 * mutator method for index.php id
	 * @param int|null $newReviewId new value of index.php id
	 * @throw \RangException if $newReviewId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setReviewId(?int $newReviewId) : void {
		// index.php id is null immediately return it
		if($newReviewId === null) {
			$this->reviewId = null;
			return;
		}

		// make sure index.php id is positive
		if($newReviewId <= 0) {
			throw(new \RangeException("index.php id is not positive"));
		}

		// convert and store the index.php id
		$this->reviewId = $newReviewId;
	}

	/**
	 * accessor method for reviewStudentProfileId
	 * @return int value of reviewStudentProfileId
	 **/

	public function getReviewStudentProfileId() : int {
		return ($this->reviewStudentProfileId);
	}

	/**
	 * mutator method for reviewStudentProfileId
	 * @param int $newReviewStudentProfileId new value of reviewStudentProfileId
	 * @throws \RangeException if $newReviewStudentProfileId is not positive
	 * @throws \TypeError if $newReviewStudentProfileId is not an integer
	 **/

	public function setReviewStudentProfileId(int $newReviewStudentProfileId) : void {
		// if reviewStudentProfileId is null immediately return it
		//if($newReviewStudentProfileId === null) {
//			$this->reviewStudentprofileId = null;
//			return;
//		}

		// make sure reviewStudentProfileId is positive
		if($newReviewStudentProfileId <= 0) {
			throw(new \RangeException("reviewStudentProfileId is not positive"));
		}

		// convert and store the reviewStudentProfileId
		$this->reviewStudentProfileId = $newReviewStudentProfileId;
	}

	/**
	 * accessor method for reviewTutorProfileId
	 * @return int value of reviewTutorProfileId
	 **/

	public function getReviewTutorProfileId() : int {
		return ($this->reviewTutorProfileId);
	}

	/**
	 * mutator method for reviewTutorProfileId
	 * @param int $newReviewTutorProfileId new value of reviewTutorProfileId
	 * @throws \RangeException if $newReviewTutorProfileId is not positive
	 * @throws \TypeError if $newReviewTutorProfileId is not an integer
	 **/

	public function setReviewTutorProfileId(int $newReviewTutorProfileId) : void {
		// if reviewTutorProfileId is null immediately return it
		//if($newReviewTutorProfileId === null) {
		//$this->reviewTutorProfileId = null;
		//return;
		//	}

		// make sure reviewTutorProfileId is positive
		if($newReviewTutorProfileId <= 0) {
			throw(new \RangeException("reviewTutorProfileId is not positive"));
		}

		// convert and store the reviewTutorProfileId
		$this->reviewTutorProfileId = $newReviewTutorProfileId;
	}

	/**
	 * accessor method for reviewRating
	 * @return int value of reviewRating
	 **/

	public function getReviewRating() : int {
		return ($this->reviewRating);
	}

	/**
	 * mutator method for reviewRating
	 * @param int $newReviewRating new value of reviewRating
	 * @throws \RangeException if $newReviewRating is not positive
	 * @throws \TypeError if $newReviewRating is not an integer
	 **/

	public function setReviewRating(?int $newReviewRating) : void {
		// if reviewRating is null immediately return it
		if($newReviewRating === null) {
			$this->reviewRating = null;
			return;
		}

		// make sure reviewRating is positive
		if($newReviewRating <= 0) {
			throw(new \RangeException("reviewRating is not positive"));
		}

		// convert and store the reviewRating
		$this->reviewRating = $newReviewRating;
	}

	/**
	 * accessor method for index.php text
	 * @return string value of index.php text
	 **/

	public function getReviewText() : string {
		return ($this->reviewText);
	}

	/**
	 * mutator method for index.php text
	 * @param string $newReviewText text for this index.php
	 * @throws \InvalidArgumentException if $newReviewText is not a string or is insecure
	 * @throws \RangeException if $newReviewText is > 500 characters
	 * @throws \TypeError if $newReviewText is not a string
	 **/

	public function setReviewText(string $newReviewText) : void {
		// verify index.php text is secure
		$newReviewText = trim($newReviewText);
		$newReviewText = filter_var($newReviewText, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify text is not empty
		if(empty($newReviewText) === true) {
			throw(new \InvalidArgumentException("index.php text is either empty or insecure"));
		}
		// verify reviewText will fit in the database
		if(strlen($newReviewText) > 500) {
			throw(new \RangeException("index.php text is too long"));
		}
		// store index.php text
		$this->reviewText = $newReviewText;
	}

	/**
	 * accessor method for index.php date time
	 * @return \DateTime value of  index.php date time
	 **/

	public function getReviewDateTime() : \DateTime {
		return ($this->reviewDateTime);
	}

	/**
	 * mutator method for index.php date time
	 * @param \DateTime|string|null $newReviewDateTime as a DateTime object or string (or null to load current time
	 * @throws \InvalidArgumentException if $newReviewDateTime is not a valid object or string
	 * @throws \RangeException if $newReviewDateTime is a date that does not exist
	 **/

	public function setReviewDateTime($newReviewDateTime = null) : void {
		// base case: if the date is null use the current date and time
		if($newReviewDateTime === null) {
			$this->ReviewDateTime = new \DateTime();
			return;
		}
		// store the index.php date using the ValidateDate trait
		try {
			$newReviewDateTime = self::validateDateTime($newReviewDateTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->reviewDateTime = $newReviewDateTime;
	}

	/**
	 * inserts this index.php into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function insert(\PDO $pdo) : void {
		//enforce the reviewId is null (i.e., don't insert a index.php that already exists)
		if($this->reviewId !== null) {
			throw(new \PDOException("not a new index.php"));
		}

		// create query template
		$query = "INSERT INTO index.php(reviewStudentProfileId, reviewTutorProfileId, reviewRating, 
		reviewText, reviewDateTime) VALUES(:reviewStudentProfileId,:reviewTutorProfileId, 
		:reviewRating, :reviewText, :reviewDateTime)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->reviewDateTime->format("y-m-d H:i:s");

		$parameters = ["reviewStudentProfileId" => $this->reviewStudentProfileId, "reviewTutorProfileId" => $this->reviewTutorProfileId,
			"reviewRating" => $this->reviewRating, "reviewText" => $this->reviewText, "reviewDateTime" => $formattedDate];
		$statement->execute($parameters);

		// update the null reviewId with what mySQL just gave us
		$this->reviewId = intval($pdo->lastInsertId());
	}

	/**
	 *deletes this index.php from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws |\PDOException when mySQL related errors occur
	 * @throws |\TypeError if $pdo is not a PDO connection object
	 **/

	public function delete(\PDO $pdo) : void {
		// enforce the reviewId is not null (i.e., don't delete a index.php that hasn't been inserted)
		if($this->reviewId === null) {
			throw(new \PDOException("unable to delete a index.php that does not exist"));
		}

		// create query template
		$query = "DELETE FROM index.php WHERE reviewId = :reviewId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["reviewId" => $this->reviewId];
		$statement->execute($parameters);
	}

	/**
	 * updates this index.php in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function update(\PDO $pdo) : void {
		// enforce the reviewId is not null (i.e., don't update a index.php that hasn't been inserted)
		if($this->reviewId === null) {
			throw(new \PDOException("unable to update a index.php that does not exist"));
		}

		// create query template
		$query = "UPDATE index.php SET reviewStudentProfileId = :reviewStudentProfileId, reviewTutorProfileId =:reviewTutorProfileId,
		reviewRating = :reviewRating, reviewText = :reviewText, reviewDateTime = :reviewDateTime";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->reviewDateTime->format("y-m-d H:i:s");
		$parameters = ["reviewStudentProfileId" => $this->reviewStudentProfileId, "reviewTutorProfileId" =>
			$this->reviewTutorProfileId, "reviewRating" => $this->reviewRating, "reviewText" => $this->reviewText,
			"reviewDateTime" => $this->reviewDateTime];
		$statement = $pdo->prepare($query);
	}

	/**
	 * gets the index.php by reviewId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $reviewId index.php id to search for
	 * @return Review | null Review found or null if not found
	 * @throws \PDOException when mySQl related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/

	public static function getReviewByReviewId(\PDO $pdo, int $reviewId) : ?Review {
		// sanitize the reviewId before searching
		if($reviewId <= 0) {
			throw(new \PDOException("index.php id is not positive"));
		}

		//create query template
		$query = "SELECT reviewId, reviewStudentProfileId, reviewTutorProfileId, reviewRating, reviewText,
		reviewDateTime FROM index.php WHERE reviewId = :reviewId";
		$statement = $pdo->prepare($query);

		// bind the index.php id to the place holder in the template
		$parameters = ["reviewId" => $reviewId];
		$statement->execute($parameters);

		// grab index.php from mySQL
		try {
			$review = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$review = new Review($row["reviewId"], $row["reviewStudentProfileId"], $row["reviewTutorProfileId"],
					$row["reviewRating"], $row["reviewText"], $row["reviewDateTime"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($review);
	}

	/**
	 * gets the index.php by reviewStudentProfileId
	 *
	 * @param \PDO $pdo Pdo connection object
	 * @param int $reviewStudentProfileId profile id to search by
	 * @return \SplFixedArray SplFixedArray of reviews found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/

	public static function getReviewByReviewStudentProfileId(\PDO $pdo, int $reviewStudentProfileId) : \SPLFixedArray {
		// sanitize the index.php student profile id before searching
		if($reviewStudentProfileId <= 0) {
			throw(new \RangeException("index.php student profile id must be positive"));
		}
		// create query template
		$query = "SELECT reviewId, reviewStudentProfileId, reviewTutorProfileId, reviewRating, reviewText, 
		reviewDateTime FROM index.php WHERE reviewStudentProfileId = :reviewStudentProfileId";
		$statement = $pdo->prepare($query);
		// bind the index.php student profile id to the place holder in the template
		$parameters = ["reviewStudentProfileId" => $reviewStudentProfileId];
		$statement->execute($parameters);
		// build an array of reviews
		$reviews = new \SPLFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->Fetch()) !== false) {
			try {
				$review = new Review($row["reviewId"], $row["reviewStudentProfileId"], $row["reviewTutorProfileId"],
					$row["reviewRating"], $row["reviewText"], $row["reviewDateTime"]);
				$reviews[$reviews->key()] = $review;
				$reviews->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($reviews);
	}


	/**
	 * gets the index.php by index.php tutor profile id
	 *
	 * @param \PDO $pdo Pdo connection object
	 * @param int $reviewTutorProfileId profile id to search by
	 * @return \SplFixedArray SplFixedArray of reviews found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/

	public static function getReviewByReviewTutorProfileId(\PDO $pdo, int $reviewTutorProfileId) : \SPLFixedArray {
		// sanitize the index.php student profile id before searching
		if($reviewTutorProfileId <= 0) {
			throw(new \RangeException("index.php tutor profile id must be positive"));
		}
		// create query template
		$query = "SELECT reviewId, reviewStudentProfileId, reviewTutorProfileId, reviewRating, reviewText, 
		reviewDateTime FROM index.php WHERE reviewTutorProfileId = :reviewTutorProfileId";
		$statement = $pdo->prepare($query);
		// bind the index.php tutor profile id to the place holder in the template
		$parameters = ["reviewTutorProfileId" => $reviewTutorProfileId];
		$statement->execute($parameters);
		// build an array of reviews
		$reviews = new \SPLFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->Fetch()) !== false) {
			try {
				$review = new Review($row["reviewId"], $row["reviewStudentProfileId"], $row["reviewTutorProfileId"],
					$row["reviewRating"], $row["reviewText"], $row["reviewDateTime"]);
				$reviews[$reviews->key()] = $review;
				$reviews->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($reviews);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		// format the date so that the front end can consume it
		$fields["reviewDateTime"] = round(floatval($this->reviewDateTime->format("U.u")) * 1000);
		return ($fields);
	}
}


