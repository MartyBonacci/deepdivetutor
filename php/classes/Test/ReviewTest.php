<?php

namespace Edu\Cnm\DeepDiveTutor\Test;

use Edu\Cnm\DeepDiveTutor\{
	Profile, Review
};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "autoload.php");

/**
 * Full PHPUnit test for the review class
 *
 * This is a complete PHPUnit test of the review class. It is complete because *ALL* mySQL/PDO enabled methods are tested
 * for both invalid and valid inputs.
 *
 * @see review
 * @author Timothy Williams <tkotalik@cnm.edu>
 **/
class ReviewTest extends DeepDiveTutor {
	/**
	 *profile that created the review; this is for foreign key relations
	 * @var Profile profile
	 **/

	protected $profile = null;

	/**
	 * valid profile hash to create the profile object to own the test
	 * @var $VALID_HASH
	 **/

	protected $VALID_PROFILE_HASH;

	/**
	 * valid salt to use to create the profile object to own the test
	 * @var string $VALID_SALT
	 **/

	protected $VALID_PROFILE_SALT;

	/**
	 * content of review
	 * @var string $VALID_REVIEWCONTENT
	 **/

	protected $VALID_REVIEWCONTENT = "PHPUnit test passing";

	/**
	 * timestamp of the review; this starts as null and is assigned later
	 * @var \DateTime $VALID_REVIEWDATE
	 **/

	protected $VALID_REVIEWDATE = null;

	/**
	 * Valid timestamp to use as sunriseReviewDate
	 **/

	protected $VALID_SUNRISEDATE = null;

	/**
	 * Valid timestamp to use as sunsetReviewDate
	 **/

	protected $VALID_SUNSETDATE = null;

	/**
	 * create dependent objects before running each test
	 **/

	public final function setUp(): void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_SALT = bin2hex(random_bytes(32));
		$this->VALID_PROFILE_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);


		// create and insert a Profile to own the test Review
		$this->profile = new Profile(null, 222222222222222222, "@handle", "test@phpunit.de", $this->VALID_PROFILE - HASH,
			"+12125551212", $this->VALID_PROFILE_SALT);

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_REVIEWDATE = new \DateTime();

		// format the sunrise date to use for testing
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		//format the sunset date to use for testing
		$this->VALID_SUNSETDATE = new \DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));


	}

	/**
	 * test inserting a valid review and verify that the actual mySQL data matches
	 **/

	public function testInsertValidReview(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("review");

		//creae a new review and insert into mySQL
		$review = new Review(null, $this->profile ->getProfileId(), $this->VALID_REVIEWCONTENT,
			$this->VALID_REVIEWDATE);
		$review->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoReview = Review::getReviewByReviewId($this->getPDO(), $review->getReviewId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("review"));
		$this->assertEquals($pdoReview->getReviewProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoReview->getReviewContent(), $this->VALID_REVIEWCONTENT);
		// format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoReview->getReviewDate()->getTimestamp(), $this->VALID_REVIEWDATE->getTimestamp());
	}

		/**
		 * test inserting a Review that already exist
		 *
		 * @expectedException \PDOException
		 **/

		public function testInsertInvalidReview() : void {
			// create a Review with a non null review id and watch it fail
			$review = new Review(DeepDiveTutorTest::INVALID_KEY, $this->profile->getProfileId(), $this->VALID_REVIEWCONTENT, $this->VALID_REVIEWDATE);
			$review->insert($this->getPDO());
		}

		/**
		 * test inserting a review, editing it, and then updating it
		 **/

		public function testUpdateValidReview() : void {
			// count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("review");

			// create a new Review and insert into mySQL
			$review = new Review(null, $this->profile ->getProfileId(), $this->VALID_REVIEWCONTENT,
				$this->VALID_REVIEWDATE);
			$review->insert($this->getPDO());

			// edit the Review and update it in mySQL
			$review->setReviewContent($this->VALID_REVIEWCONTENT2);
			$review->update($this->getPDO());

			// grab the data from mySQL and enforce the fields match our expectations
			$pdoReview = Review::gerReviewByReviewId($this->getPDO(), $review->getReviewId());
			$this->asserEquals($numRows + 1, $this->getConnection()->getRowCount("review"));
			$this->assertEquals($pdoReview->getReviewProfileId(), $this->profile->getProfileId());
			$this->assertEquals($pdoReview->getReviewContent(), $this->VALID_REVIEWCONTENT2);
			// format the date too seconds since the beginning of time to void round off error
			$this->assertEquals($pdoReview->getReviewDate()->getTimestamp(), $this->VALID_REVIEWDATE->getTimestamp());
		}

		/**
		 *
		 **/

}