<?php
namespace Edu\Cnm\DeepDiveTutor;
require_once("autoload.php");
/**
 * JsonObjectStorageClass
 *
 * This class adds JsonSerializable to SplObjectStorage, allowing for the stored data to be json serialized.  This
 * lets the data be used in the interactions between frontend and backend in the RESTful apis.
 *
 * @author Jack Reuter
 *
 */
class JsonObjectStorage extends \SplObjectStorage implements \JsonSerializable {
	public function jsonSerialize() {
		$fields = [];
		foreach($this as $object) {
			$fields[] = $object;
			$object->skills = $this[$object];
		}
		return ($fields);
	}
}

