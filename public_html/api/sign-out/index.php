<?php
require_once dirname(__DIR__,3)."/php/classes/autoload.php";
require_once dirname(__DIR__,3)."/php/lib/xsr.php";
require once dirname("/etc/apache2/capstone-mysql/encrypted-config.php");

/**
 *
 * api for signing out
 * @author godfrey
 * @version 1.0
 */

//verify the xsrf challenge
if (session_status()!==PHP_SESSION_ACTIVE){
	session_start();
}

//prepare default error message
$reply =new stdClass();
$reply->status =200;
$reply->data=null;

try{
	$pdo = connectToEncrytedMySQL("/etc/apache2/capstone-mysql/deepdivetutor.ini");
	$method= array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER)? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	if ($method === "GET"){
		$_SESSION =[];

	}
}