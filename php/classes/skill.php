<?php

/**
 * Class Skill
 * calling skill table, and defining restrictions on type to pushed through and validated if not validated will throw errors
 */
class Skill implements  \JsonSerializable{
	/**
	 * @var skillId is an int its the id of the skill ; a primary key
	 */
	private $skillId;
	/**
	 * @var
	 */
	private $skillName;

	public function __construct(?int $newSkillId, string $newSkillName){
		try {
			$this->setSkillId($newSkillId);
			$this->setSkillName($newSkillName);
		}
		catch (\InvalidArgumentException| \RangeException |\Exception | \TypeError $exception){
			$exceptionType = get_class($exception);
			throw(new exceptionType($exception->getMessage(),0,$exception));
					}
	}

	/**
	 * @return mixed
	 */
	public function getSkillId(): int {
		return $this->skillId;
	}

	/**
	 * @param mixed $skillId
	 */
	public function setSkillId(int $newSkillId): void {
		if ($newSkillId<= 0){
			throw(new \RangeException("This Skill Id is not positive"));
		}
		$this->skillId = $newSkillId;
	}
	/**
	 * @return mixed
	 */
	public function getSkillName(): string {
		return $this->skillName ;
	}
}
	public function setSkillName(string $newSkillName): void{
	$newSkillName = trim($newSkillName);
	$newSkillName = filter_var($newSkillName,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($newSkillName)=== true){
		throw(new \InvalidArgumentException("The Skill Name is Empty!"));
	}
	if(strlen($newSkillName)>32){
		throw(new \RangeException("Skill Name is Too Looooong!"));
	}
	$this->skillName = $newSkillName;
}