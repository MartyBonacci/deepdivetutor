<?php
namespace Edu\Cnm\DeepDiveTutor;

require_once("autoload.php");
/**
 * class for profile entity
 *
 * This is the Profile class for deepdivetutor.
 *
 * @author Jack Reuter <djreuter45@gmail.com>
 * @version 1.0.1
 */
class Profile {
	/**
	 * Id this profile; This is the primary key
	 * @var int $profileId
	 */
	private $profileId;
	/**
	 * Name for this profile
	 * @var string $profileName
	 */
	private $profileName;
	/**
	 * Email for this profile
	 * @var string $profileEmail
	 */
	private $profileEmail;
	/**
	 * Type of profile; Either student or tutor
	 * @var int $profileType
	 */
	private $profileType;
	/**
	 * GitHub Token for profile
	 * @var string $profileGithubToken
	 */
	private $profileGithubToken;
	/**
	 * Bio for this profile
	 * @var string $profileBio;
	 */
	private $profileBio;
	/**
	 * Rate for this profile
	 * @var float $profileRate
	 */
	private $profileRate;
	/**
	 * Image for this profile
	 * @var string $profileImage
	 */
	private $profileImage;
	/**
	 * Date this profile was last edited
	 * @var \DateTime
	 */
	private $profileLastEditDateTime;
	/**
	 * Activation token for this profile
	 * @var string $profileActivationToken
	 */
	private $profileActivationToken;
	/**
	 * Hash for this profile password
	 * @var string $profileHash
	 */
	private $profileHash;
	/**
	 * Salt for this profile
	 * @var string $profileSalt
	 */
	private $profileSalt;

	/**
	 * constructor for this profile
	 *
	 * @param int|null $newProfileId id of this profile or null if new profile
	 * @param string $newProfileName name of this profile owner
	 * @param string $newProfileEmail email address for this profile
	 * @param int $newProfileType type of profile
	 * @param string $newProfileGithubToken GitHub token for this profile
	 * @param string $newProfileBio bio for this profile
	 * @param float $newProfileRate rate for this profile
	 * @param string $newProfileImage image for this profile
	 * @param \DateTime $newProfileLastEditDateTime last edit date for this profile
	 * @param string $newProfileActivationToken activation token for this profile
	 * @param string $newProfileHash hash for this profile
	 * @param string $newProfileSalt salt for this profile
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @documentation https://php.net/manual/en/language.oop5.decon.php
	 */

}
