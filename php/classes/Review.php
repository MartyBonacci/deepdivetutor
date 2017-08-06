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

}


