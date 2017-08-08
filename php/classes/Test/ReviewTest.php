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

}