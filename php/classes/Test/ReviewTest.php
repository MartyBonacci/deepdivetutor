<?php

namespace Edu\Cnm\DeepDiveTutor\Test;

use Edu\Cnm\DeepDiveTutor\ {
Profile,Review

};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the review class
 *
 * This is a complete PHPUnit test of the review class. It is complete because *ALL* mySQL/PDO enabled methods are tested
 * for both invalid and valid inputs.
 *
 * @see review
 * @author Timothy Williams <tkotalik@cnm.edu>
 **/
class ReviewTest extends DeepDiveTutorTest {
	/**
	 * this is for foriegn key relations
	 * @var Profile $profile
	 */
	protected $profile = null;


	protected $valid_ReviewId = null;
	/**
	 *profile that saved the review; this is for foreign key relations
	 * @var Profile $valid_StudentProfile
	 **/

	protected $valid_StudentProfile = null;

	/**
	 * profile that saved the review; this is for foreign key relations
	 * @var Profile $valid_TutorProfileId
	 **/

	protected $valid_TutorProfile = null;

	/**
	 * actual rating of tutor
	 * @var int $valid_rating
	 **/

	protected $valid_Rating = 3;

	/**
	 * actual text of review
	 * @var string $valid_Text
	 **/

	protected $valid_Text = "tutor was great";

	/**
	 * actual text of review
	 * @var string $valid_Text2
	 **/

	protected $valid_Text2= "tutor was terrible";

	/**
	 * timestamp of the review; this starts as null and is assigned later
	 * @var \DateTime $valid_datetime
	 **/

	protected $valid_Datetime = null;

	/**
	 * valid hash to create the organization and profile object for the test
	 * @var $VALID_HASH
	 **/

	protected $valid_Hash;

	/**
	 * valid hash to create the organization and profile object for the test
	 * @var string $VALID_SALT
	 **/

	protected $valid_Salt;

	/**
	 * placeholder until account activation is created
	 * @var string $VALID_ACTIVATION
	 **/

	protected $valid_Activation;

	/**
	 * create dependent objects before running each test
	 **/

	public final function setUp(): void {
		// run the default setUp() method first
		parent::setUp();

		$password = "abc123";
		$this->valid_Salt = bin2hex(random_bytes(32));
		$this->valid_Hash = hash_pbkdf2("sha512", $password, $this->valid_Salt, 262144);
		$this->valid_Activation = bin2hex(random_bytes(16));
		//$this->valid_Datetime = new \DateTime();

		// create and insert the mocked profile
		$this->profile = new Profile(null, "John Smith", "test@phpunit.de", "0", "Loremipsumdolorsitametconsecteturadipiscingelitposuerefhdrtuiseb",
			 "is a bio", 25.00, "Loremipsdolorsitametconthirtytwo", null, $this->valid_Activation, $this->valid_Hash, $this->valid_Salt);
		$this->profile->insert($this->getPDO());

		$this->valid_Datetime = new \DateTime();
	}

	/**
	 * test inserting a valid review and verify that the actual mySQL data matches
	 **/

	public function testInsertValidReview(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("review");

		//create a new review and insert into mySQL
		var_dump($this->valid_Datetime);
		$review = new Review(null, $this->profile->getProfileId(),$this->profile->getProfileId(), $this->valid_Rating, $this->valid_Text, $this->valid_Datetime);
		$review->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoReview = Review::getReviewByReviewId($this->getPDO(), $review->getReviewId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("review"));
		$this->assertEquals($pdoReview->getReviewStudentProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoReview->getReviewTutorProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoReview->getReviewRating(), $this->valid_Rating);
		$this->assertEquals($pdoReview->getReviewText(), $this->valid_Text);
		$this->assertEquals($pdoReview->getReviewDateTime(), $this->valid_Datetime);
	}
			/**
			 * test inserting a Review that already exist
			 *
			 * @expectedException \PDOException
			 **/

			public function testInsertInvalidReview(): void {
				// create a Review with a non null review id and watch it fail
				$review = new Review(DeepDiveTutorTest::INVALID_KEY, $this->profile->getProfileId(),$this->profile->getProfileId(), $this->profile->getProfileId,
					$this->valid_Rating, $this->valid_Text, $this->valid_Datetime);
				$review->insert($this->getPDO());
			}

			/**
			 * test inserting a review, editing it, and then updating it
			 **/

			public
			function testUpdateValidReview(): void {
				// count the number of rows and save it for later
				$numRows = $this->getConnection()->getRowCount("review");

				// create a new Review and insert into mySQL
				$review = new Review(null, $this->profile->getProfileId(),$this->profile->getProfileId(),  $this->valid_Rating, $this->valid_Text, $this->valid_Datetime);
				$review->insert($this->getPDO());

				// edit the Review and update it in mySQL
				$review->setReviewText($this->valid_Text2);
				$review->update($this->getPDO());

				// grab the data from mySQL and enforce the fields match our expectations
				$pdoReview = Review::getReviewByReviewId($this->getPDO(), $review->getReviewId());
				$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("review"));
				$this->assertEquals($pdoReview->getReviewStudentProfileId(), $this->profile->getProfileId());
				$this->assertEquals($pdoReview->getReviewTutorProfileId(), $this->profile->getProfileId());
				$this->assertEquals($pdoReview->getReviewRating(), $this->valid_Rating);
				$this->assertEquals($pdoReview->getReviewText(), $this->valid_Text);
				$this->assertEquals($pdoReview->getReviewDateTime(), $this->valid_Datetime);
			}

			/**
			 * test updating a Review that already exists
			 *
			 * @expectedException \PDOException
			 **/

			public function testUpdateInvalidReview(): void {
				// create a Review with a non null review id and watch it fail
				$review = new Review(0, $this->profile->getProfileId(),$this->profile->getProfileId(),  $this->valid_Rating, $this->valid_Text, $this->valid_Datetime);
				$review->update($this->getPDO());

			}

			/**
			 * test creating a Review and then deleting it
			 **/

			public function testDeleteValidReview(): void {
				// count the number of rows and save it for later
				$numRows = $this->getConnection()->getRowCount("review");

				// create a new Review and insert to into mySQL
				$review = new Review(null, $this->profile->getProfileId(),$this->profile->getProfileId(),  $this->valid_Rating, $this->valid_Text, $this->valid_Datetime);
				$review->insert($this->getPDO());

				// delete the Review from mySQL
				$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("review"));
				$review->delete($this->getPDO());

				// grab the data from mySQL and enforce the Review does not exist
				$pdoReview = Review::getReviewByReviewId($this->getPDO(), $review->getReviewId());
				$this->assertNull($pdoReview);
				$this->assertEquals($numRows, $this->getConnection()->getRowCount("review"));
			}

			/**
			 * test deleting a Review that does not exist
			 *
			 * @expectedException \PDOException
			 **/

			public function testDeleteInvalidReview(): void {
				// create a Review and try to delete it without actually inserting it
				$review = new Review(null, $this->profile->getProfileId(),$this->profile->getProfileId(),  $this->valid_Rating, $this->valid_Text, $this->valid_Datetime);
				$review->delete($this->getPDO());
			}

			/**
			 * test inserting a Review and regrabbing it from mySQL
			 **/
			public function testGetValidReviewByReviewId(): void {
				// count the number of rows and save it for later
				$numRows = $this->getConnection()->getRowCount("review");

				// create a new Review and insert to into mySQL
				$review = new Review(null, $this->profile->getProfileId(),$this->profile->getProfileId(),  $this->valid_Rating, $this->valid_Text, $this->valid_Datetime);
				$review->insert($this->getPDO());

				// grab the data from mySQL and enforce the fields match our expectations
				$pdoReview = Review::getReviewByReviewId($this->getPDO(), $review->getReviewId());
				$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("review"));
				$this->assertEquals($pdoReview->getReviewStudentProfileId(), $this->profile->getProfileId());
				$this->assertEquals($pdoReview->getReviewTutorProfileId(), $this->profile->getProfileId());
				$this->assertEquals($pdoReview->getReviewRating(), $this->valid_Rating);
				$this->assertEquals($pdoReview->getReviewText(), $this->valid_Text);
				$this->assertEquals($pdoReview->getReviewDateTime(), $this->valid_Datetime);
			}

			/**
			 * test grabbing a Review that does not exist
			 **/
			public function testGetInvalidReviewByReviewId(): void {
				// grab a profile id that exceeds the maximum allowable profile id
				$review = Review::getReviewByReviewId($this->getPDO(), DeepDiveTutorTest::INVALID_KEY);
				$this->assertNull($review);
			}

			/**
			 * test inserting a Review and regrabbing it from mySQL - ReviewStudentProfileId
			 **/
			public function testGetValidReviewByReviewStudentProfileId() {
				// count the number of rows and save it for later
				$numRows = $this->getConnection()->getRowCount("review");

				// create a new Review and insert to into mySQL
				$review = new Review(null, $this->profile->getProfileId(),$this->profile->getProfileId(),  $this->valid_Rating, $this->valid_Text, $this->valid_Datetime);
				$review->insert($this->getPDO());

				// grab the data from mySQL and enforce the fields match our expectations
				$results = Review::getReviewByReviewStudentProfileId($this->getPDO(), $review->getReviewStudentProfileId());
				$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("review"));
				$this->assertCount(1, $results);
				$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DeepDiveTutor\\Review", $results);

				// grab the result from the array and validate it
				$pdoReview = $results[0];
				$this->assertEquals($pdoReview->getReviewStudentProfileId(), $this->profile->getProfileId());
				$this->assertEquals($pdoReview->getReviewTutorProfileId(), $this->profile->getProfileId());
				$this->assertEquals($pdoReview->getReviewRating(), $this->valid_Rating);
				$this->assertEquals($pdoReview->getReviewText(), $this->valid_Text);
				$this->assertEquals($pdoReview->getReviewDateTime(), $this->valid_Datetime);
			}

			/**
			 * test grabbing a Review that does not exist
			 **/
			public function testGetInvalidReviewByReviewStudentProfileId(): void {
				// grab a profile id that exceeds the maximum allowable profile id
				$review = Review::getReviewByReviewStudentProfileId($this->getPDO(), DeepDiveTutorTest::INVALID_KEY);
				$this->assertCount(0, $review);
			}

	/**
	 * test inserting a Review and regrabbing it from mySQL - ReviewTutorProfileId
	 **/
	public function testGetValidReviewByReviewTutorProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("review");

		// create a new Review and insert to into mySQL
		$review = new Review(null, $this->profile->getProfileId(),$this->profile->getProfileId(),  $this->valid_Rating, $this->valid_Text, $this->valid_Datetime);
		$review->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Review::getReviewByReviewTutorProfileId($this->getPDO(), $review->getReviewTutorProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("review"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DeepDiveTutor\\Review", $results);

		// grab the result from the array and validate it
		$pdoReview = $results[0];
		$this->assertEquals($pdoReview->getReviewStudentProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoReview->getReviewTutorProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoReview->getReviewRating(), $this->valid_Rating);
		$this->assertEquals($pdoReview->getReviewText(), $this->valid_Text);
		$this->assertEquals($pdoReview->getReviewDateTime(), $this->valid_Datetime);
	}

	/**
	 * test grabbing a Review that does not exist
	 **/
	public function testGetInvalidReviewByReviewTutorProfileId(): void {
		// grab a profile id that exceeds the maximum allowable profile id
		$review = Review::getReviewByReviewTutorProfileId($this->getPDO(), DeepDiveTutorTest::INVALID_KEY);
		$this->assertCount(0, $review);
	}

}