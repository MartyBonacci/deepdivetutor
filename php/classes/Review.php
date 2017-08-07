<?php

namespace Edu\Cnm\DeepDiveTutor;

require_once("autoload.php");

/**
 * <h1>deep dive tutor</h1>
 * @author Timothy Williams <tkotalik@cnm.edu>
 * @version 1.0
 **/
class Review {
	/**
	 * primary key for profileId
	 * @var int reviewId
	 **/
	private $reviewId;
	/**
	 * id of the student that saved this review; this is a foreign key
	 * @var int $reviewStudentProfileId
	 **/
	private $reviewStudentProfileId;
	/**
	 * id of the tutor that saved this review; this is a foreign key
	 * @var int $reviewTutorProfileId
	 **/
	private $reviewTutorProfileId;
	/**
	 * actual rating of tutor
	 * @var int $reviewRating
	 **/
	private $reviewRating;
	/**
	 * actuall text of review
	 * @var string $reviewText
	 **/
	private $reviewText;
	/**
	 * date and time review was submitted, in a PHP DateTime object
	 * @var \timestamp $reviewDateTime
	 **/
	private $reviewDateTime;

	/**
	 * constructor
	 *
	 * @param int|null $newReviewId of this review or null if a new review
	 * @param int $newReviewStudentProfileId id of the student that saved this review
	 * @param int $newReviewTutorProfileId id of the tutor that saved this review
	 * @param int $newReviewRating int containing rating number
	 * @param string $newReviewText string containing actual review text
	 * @param timestamp $newReviewDateTime timestamp of when review was made
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \Range Exception if data values are out of bounds (e.g., strings too long, negative integers, negative floats)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @documentation https://php.net/manual/en.language.oop5.decon.php
	 **/

	public function __construct(?int $newReviewId, int $newReviewStudentProfileId, int $newReviewTutorProfileId,
										 int $newReviewRating, string $newReviewText, timestamp $newReviewDateTime) {
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
	public function getReviewId(): ?int {
		return ($this->reviewId);
	}

	/**
	 * mutator method for review id
	 * @param int|null $newReviewId new value of review id
	 * @throw \RangException if $newReviewId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setReviewId(?int $newReviewId): void {
		// review id is null immediately return it
		if($newReviewId === null) {
			$this->reviewId = null;
			return;
		}

		// make sure review id is positive
		if($newReviewId <= 0) {
			trow(new \RangeException("review id is not positive"));
		}

		// convert and store the review id
		$this->reviewId = $newReviewId;
	}

	/**
	 * accessor method for reviewStudentProfileId
	 * @return int value of reviewStudentProfileId
	 **/

	public function getReviewStudentProfileId(): int {
		return ($this->reviewStudentProfileId);
	}

	/**
	 * mutator method for reviewStudentProfileId
	 * @parm int $newReviewStudentProfileId new value of reviewStudentProfileId
	 * @throws \RangeException if $newReviewStudentProfileId is not positive
	 * @throws \TypeError if $newReviewStudentProfileId is not an integer
	 **/

	public function setReviewStudentProfileId(?int $newReviewStudentProfileId): void {
		// if reviewStudentProfileId is null immediately return it
		if($newReviewStudentProfileId === null) {
			$this->reviewStudentprofileId = null;
			return;
		}

		// make sure reviewStudentProfileId is positive
		if($newReviewStudentProfileId <= 0) {
			throw(new \RangeException("reviewStudentProfileId is not positive"));
		}

		// convert and store the reviewStudentProfileId
		$this->reviewStudentProfileId = $newReviewSudentProfileId;
	}

	/**
	 * accessor method for reviewTutorProfileId
	 * @return int value of reviewTutorProfileId
	 **/

	public function getReviewTutorProfileId(): int {
		return ($this->reviewTutorProfileId);
	}

	/**
	 * mutator method for reviewTutorProfileId
	 * @param int $newReviewTutorProfileId new value of reviewTutorProfileId
	 * @throws \RangeException if $newReviewTutorProfileId is not positive
	 * @throws \TypeError if $newReviewTutorProfileId is not an integer
	 **/

	public function setReviewTutorProfileId(?int $newReviewTutorProfileId): void {
		// if reviewTutorProfileId is null immediately return it
		if($newReviewTutorProfileId === null) {
			$this->reviewTutorprofileId = null;
			return;
		}

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

	public function getReviewRating(): int {
		return ($this->reviewRating);
	}

	/**
	 * mutator method for reviewRating
	 * @parm int $newReviewRating new value of reviewRating
	 * @throws \RangeException if $newReviewRating is not positive
	 * @throws \TypeError if $newReviewRating is not an integer
	 **/

	public function setReviewRating(?int $newReviewRating): void {
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
	 * accessor method for review text
	 * @return string value of review text
	 **/

	public function getReviewText(): string {
		return ($this->reviewText);
	}

	/**
	 * mutator method for review text
	 * @param string $newReviewText text for this review
	 * @throws \InvalidArgumentException if $newReviewText is not a string or is insecure
	 * @throws \RangeException if $newReviewText is > 500 characters
	 * @throws \TypeError if $newReviewText is not a string
	 **/

	public function setReviewText(string $newReviewText): void {
		// verify review text is secure
		$newReviewText = trim($newReviewText);
		$newReviewText = filter_var($newReviewText, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify text is not empty
		if(empty($newReviewText) === true) {
			throw(new \InvalidArgumentException("review text is either empty or insecure"));
		}
		// verify reviewText will fit in the database
		if(strlen($newReviewText) > 500) {
			throw(new \RangeException("review text is too long"));
		}
		// store review text
		$this->reviewText = $newReviewText;
	}

	/**
	 * accessor method for review date time
	 * @return \DateTime value of  review date time
	 **/

	public function getReviewDateTime(): \DateTime {
		return ($this->reviewDateTime);
	}

	/**
	 * mutator method for review date time
	 * @param \DateTime|string|null $newReviewDateTime as a DateTime object or string (or null to load current time
	 * @throws \InvalidArgumentException if $newReviewDateTime is not a valid object or string
	 * @throws \RangeException if $newReviewDateTime is a date that does not exist
	 **/

	public function setReviewDateTime($newReviewDateTime = null): void {
		// base case: if the date is null use the current date and time
		if($newReviewDateTime === null) {
			$this->ReviewDateTime = new \DateTime();
			return;
		}
		// store the review date time
		try {
			$newReviewDateTime = self::validateDateTime($newReviewDateTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->ReviewDateTime = $newReviewDateTime;
	}

	/**
	 * inserts this review into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function insert(\PDO $pdo): void {
		//enforce the reviewId is null (i.e., don't insert a review that already exists)
		if($this->reviewId !== null) {
			throw(new \PDOException("not a new review"));
		}

		// create query template
		$query = "INSERT INTO review(reviewStudentProfileId, reviewTutorProfileId, reviewRating, 
		reviewText, reviewDateTime) VALUES(:reviewStudentProfileId, :reviewTutorProfileId, :reviewTutorProfileId, 
		:reviewRating, :reviewText, :reviewDateTime)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDateTime = $this->reviewDateTime->format("y-m-d H:i:s");

		$parameters = ["reviewStudentProfileId" => $this->reviewStudentProfileId, "reviewTutorProfileId" => $this->reviewTutorProfileId,
			"reviewRating" => $this->reviewRating, "reviewText" => $this->reviewText, "reviewDateTime" => $this->reviewDateTime];
		$statement - execute($parameters);

		// update the null reviewId with what mySQL just gave us
		$this->reviewId = intval($pdo->lastInsertId());
	}

	/**
	 *deletes this review from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws |\PDOException whem mySQL related errors occur
	 * @throws |\TypeError if $pdo is not a PDO connection object
	 **/

	public function delete(\PDO $pdo): void {
		// enforce the reviewId is not null (i.e., don't delete a review that hasn't been inserted)
		if($this->reviewId === null) {
			throw(new \PDOException("unable to delete a review that does not exist"));
		}

		// create query template
		$query = "DELETE FROM review WHERE reviewId = : reviewId";
		$statement = $pdo - prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["reviewId" => $this->reviewId];
		$statement->execute($parameters);
	}

	/**
	 * updates this review in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function update(\PDO $pdo): void {
		// enforce the reviewId is not null (i.e., don't update a review that hasn't been inserted)
		if($this->reviewId === null) {
			throw(new \PDOException("unable to update a review that does not exist"));
		}

		// create query template
		$query = "UPDATE review SET reviewStudentProfileId = :reviewStudentProfileId, reviewTutorProfileId =:reviewTutorProfileId,
		reviewRating = :reviewRating, reviewText = :reviewText, reviewDateTime = :reviewDateTime";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formatedDateTime = $this->reviewDateTime->format("y-m-d H:i:s");
		$parameters = ["reviewStudentProfileId" => $this->reviewStudentProfileId, "reviewTutorProfileId" =>
			$this->reviewTutorProfileId, "reviewRating" => $this->reviewRating, "reviewText" => $this->reviewText,
			"reviewDateTime" => $this->reviewDateTime];
		$statement->execute($parameters);
	}

	/**
	 * gets the review by reviewId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $reviewId review id to search for
	 * @return Review | null Review found or null if not found
	 * @throws \PDOException when mySQl related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/

	public static function getReviewByReviewId(\PDO $pdo, int $reviewId) : ?Review {
		// sanitize the reviewId before searching
		if($reviewId <= 0) {
			throw(new \PDOException("review id is not positive"));
		}

		//create query template
		$query = "SELECT reviewId, reviewStudentProfileId, reviewTutorProfileId, reviewRating, reviewText,
		reviewDateTime FROM review WHERE reviewId = : reviewId";
		$statement = $pdo->prepare($query);

		// bind the review id to the place holder in the template
		$parameter = ["reviewId" => $reviewId];
		$statement->execute($parameters);

		// grab review from mySQL
		try{
			$review = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$review = new Review($row["reviewId"], $row["reviewStudentProfileId"], $row["reviewTutorProfileId"],
					$row["reviewRating"], $row["reviewText"], $row["reviewDateTime"]);
			}
		} catch(\Exception $exeption) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($review);
	}

}


