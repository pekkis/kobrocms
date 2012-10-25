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
		$sql = "SELECT * FROM user WHERE login = :login AND password = :password";
		$query = $this->kobros->db->prepare($sql);
                $query->bindParam(":login", $params['login'], PDO::PARAM_INT);
                $query->bindParam(":password", $params['password'], PDO::PARAM_INT);
                $query->execute();
		$res = $query->fetch(PDO::FETCH_OBJ);
		
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
			$error = "Invalid username or password";
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
