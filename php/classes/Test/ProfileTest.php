<?php
namespace Edu\Cnm\DeepDiveTutor\Test;

use Edu\Cnm\DeepDiveTutor\{Profile};

// grab the class
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class
 * It is complete because *ALL* MySQL\PDO enabled methods are tested for both invalid and valid inputs
 *
 * @see Profile
 * @author Jack Reuter <djreuter45@gmail.com>
 */
class ProfileTest extends DeepDiveTutorTest {
	/**
	 * placeholder until account activation is created
	 * @var string $VALID_ACTIVATION
	 */
	protected $VALID_ACTIVATION;

	/**
	 * valid name to use
	 * @var string $VALID_NAME
	 */
	protected $VALID_NAME = "John Smith";

	/**
	 * valid email to use
	 * @var string $VALID_EMAIL
	 */
	protected $VALID_EMAIL = "test@phpunit.de";

	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 */
	protected $VALID_HASH;

	/**
	 * valid salt to use
	 * @var $VALID_SALT
	 */
	protected $VALID_SALT;

	/**
	 * valid profile type (student)
	 * @var int $VALID_TYPE_S
	 */
	protected $VALID_TYPE_S = 0;

	/**
	 * valid profile type (tutor)
	 * @var int $VALID_TYPE_T
	 */
	protected $VALID_TYPE_T = 1;

	/**
	 * valid profile github token
	 * @var $VALID_GITHUBTOKEN
	 */
	protected $VALID_GITHUBTOKEN;

	/**
	 * valid profile rate
	 * @var float $VALID_RATE
	 */
	protected $VALID_RATE =

}