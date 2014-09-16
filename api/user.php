<?php

//Normally the class files would be in their own dirctory
//and included here like the owasp libraries.
require_once('/var/www/owasp-esapi-php-read-only/src/ESAPI.php');
require_once('/var/www/owasp-esapi-php-read-only/src/reference/DefaultValidator.php');

class user {

	public $userId;
	public $username;
	public $welcome;
	private $esapi;
	private $encoder;
	private $validator;

	function __construct() {
		//The xml file is in its insecure default location.
		//We would normally have all referenced libraries outside of the webroot.
		$this->esapi = new ESAPI('../owasp-esapi-php-read-only/test/testresources/ESAPI.xml');
		ESAPI::setEncoder(new DefaultEncoder());
		ESAPI::setValidator(new DefaultValidator());
		$this->encoder = ESAPI::getEncoder();
		$this->validator = ESAPI::getValidator();
	}

	public function login($username,$password) {

		//Get each character reduced to it's most simple form
		$canonicalized_username = $this->canonicalize($username);
		$canonicalized_password = $this->canonicalize($password);
		
		//Remove the cruft we don't want
		$sanitized_username = filter_var($canonicalized_username, FILTER_SANITIZE_EMAIL);
		$sanitized_password = preg_replace("/[^a-zA-Z]/", "", $canonicalized_password);

		//Make sure what we have left meets the business rules
		if (filter_var($sanitized_username, FILTER_VALIDATE_EMAIL)) {
			$clean['username'] = $sanitized_username;
		}
		if (strlen($sanitized_password) < 9) {
			$clean['password'] = $sanitized_password;
		}

		//Normally we would use an OOP database connection singleton
		//And the connection details would not be hardcoded
		$dbConnection = new PDO('mysql:host=localhost;dbname=application', 'user', 'password');

		$dbStmt = $dbConnection->prepare("SELECT * FROM tbl_users WHERE username=:username AND password=:password");
		$dbStmt->execute(array(':username' => $clean['username'], ':password' => $clean['password']));
		$rows = $dbStmt->fetchAll(PDO::FETCH_ASSOC);
		if (count($rows)==1) {
		
			$this->userId=$rows[0]['id'];
			$this->username=$rows[0]['username'];
			$this->welcome=$rows[0]['welcome'];
			$_SESSION['csrfToken']=time(); //generateCsrfToken(); <- that would be preferrable
		
		}
		else {
			//turn away the hacker & log stuff or make poor, clueless users cry
			$this->welcome='please try again';
		}
	
		//Close the db
		$dbConnection = null;
	}

	//this also would live elsewhere and be included for 'DRY' reasons
	private  function canonicalize($input) {
		try {
		$input = $this->encoder->canonicalize($input);
		} catch (IntrusionException $e) {
		echo($e->getUserMessage());
		exit();
		}
	return $input;
	}

}



$userCheck=new user;
$userCheck->login($_POST['username'],$_POST['password']);

echo $userCheck->welcome;
?>

