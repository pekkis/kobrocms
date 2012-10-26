<?php
/**
 * User klass be handling all users needs.
 *
 * @author Devadutt Chattopadhyay
 * @author Rajanigandha Balasubramanium
 * @author Lalitchandra Pakalomattam
 *
 */
class User
{

	/**
	 * User object is stored here.
	 *
	 * @var stdClass
	 */
	public $obj;

	private function __construct()
	{
		// We be setting dem session properties and starting it wid dem it deserve!

		session_name('KBRSESSIONID');
		session_start();

		if(!isset($_SESSION['user'])) {

			// If no user in session we get new STDs.
			$user = new stdClass();
			$user->login = 'anonymous';
			// Anonymous has no passwords.
			$user->password = null;
			// Anonymous always be anonymous role.
			$user->role = 'anonymous';

			// Finally here. Give STDs to usersession too!
			$_SESSION['user'] = $user;

		}

		$this->obj = $_SESSION['user'];

	}



	/**
	 * User be singelton pattern.
	 *
	 * @return User
	 */
	static public function getInstance()
	{
		static $instance;
		if(!$instance) {
			$instance = new self();
		}

		return $instance;

	}




}
