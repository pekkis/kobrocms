<?php
/**
 * User module
 * 
 * @author Rajanigandha Balasubramanium
 *
 */
class Module_User extends Module
{

	protected function _info($params)
	{
								
		$view = new View();
		$view->target = $params['target'];				
		$view->user = $_SESSION['user'];
		
		return $view->render(ROOT . '/templates/data/user/info.phtml');
						
	}	
	
	
	protected function _default($params)
	{
		
		$view = new View();
		$view->page = $this->kobros->page;
		
		$view->user = $this->kobros->user->obj;
		
		return $view->render(ROOT . '/templates/data/user/default.phtml');	
	}
	
	
	
	protected function _login($params)
	{
		
		$sql = "SELECT * FROM user WHERE login = '{$params['login']}' AND password = '{$params['password']}'";
		
		$res = $this->kobros->db->query($sql)->fetch(PDO::FETCH_OBJ);
		
		if($res) {
			// We find user, we set dem sessions users. Rock on!
			$_SESSION['user'] = $res;

			// Redirect
		
			if($params['redirect']) {
				// If we have param redirect we use dat to redirect.
				$redirect = $params['redirect'];
			} elseif(isset($_SERVER['HTTP_REFERER'])) {
				// We know dem referes. We can go back there.
				$redirect = $_SERVER['HTTP_REFERER'];
			} else {
				$redirect = 'http://' . $_SERVER['HTTP_HOST'] . '/';
			}
	
			$redirectHeader = "Location: {$redirect}";
			
			header($redirectHeader);
			
			
		} else {
			
			// We fail. Serve customer with nice error messages true kobro style!

			// Define if user exist, give error message wrong password.
			$sql = "SELECT * FROM user WHERE login = '{$params['login']}'";
			if($res = $this->kobros->db->query($sql)->fetch(PDO::FETCH_OBJ)) {
				$error = "Invalid password.";
			} else {
				// If user not exist he given other error.
				$error = "User does not exist.";
			}
			
			$view = new View();
			$view->error = $error;
			$view->user = $_SESSION['user'];
			return $view->render(ROOT . '/templates/data/user/default.phtml');	
			
			
		
		}
		
				
	}
	

	protected function _logout($params)
	{
		// We log out. Set cookie to expire in 1970, redirect. User now anonymous 4 good.
		setcookie(session_name(), $_COOKIE[session_name()], 1, '/');		
		
		if($params['redirect']) {
			// If we have param redirect we use dat to redirect.
			$redirect = $params['redirect'];
		} elseif(isset($_SERVER['HTTP_REFERER'])) {
			// We know dem referes. We can go back there.
			$redirect = $_SERVER['HTTP_REFERER'];
		} else {
			$redirect = 'http://' . $_SERVER['HTTP_HOST'] . '/';
		}

		$redirectHeader = "Location: {$redirect}";
		header($redirectHeader);
	}
	
}
