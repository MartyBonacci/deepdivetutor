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

	public final function setUp() : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_SALT = bin2hex(random_bytes(32));
		$this->VALID_PROFILE_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);


		// create and insert a Profile to own the test Review
		$this->profile = new Profile(null, 222222222222222222,"@handle", "test@phpunit.de", $this->VALID_PROFILE-HASH,
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

	
}