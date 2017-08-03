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
}
