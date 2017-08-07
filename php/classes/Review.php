<?php

namespace Edu\Cnm\DeepDiveTutor;
require_once("autoload.php");

/**
 * <h1>deep dive tutor</h1>
 * @author Timothy Williams <tkotalik@cnm.edu>
 * @version 1.0
 **/
class review {
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
			trhow(new \RangeException("review id is not positive"));
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
	public function setReviewStudentProfileId(?int $newReviewSudentProfileId): void {
		// if reviewStudentProfileId is null immediately return it
		if($newReviewSudentProfileId === null) {
			$this->reviewStudentprofileId = null;
			return;
		}

		// make sure reviewStudentProfileId is positive
		if($newReviewSudentProfileId <= 0) {
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
	 * @parm int $newReviewTutorProfileId new value of reviewTutorProfileId
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

}


