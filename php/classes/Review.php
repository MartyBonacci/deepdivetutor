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
	 *
	 **/

}