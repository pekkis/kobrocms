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
		
		//$sql = "SELECT * FROM user WHERE login = '{$params['login']}' AND password = '{$params['password']}'";
		
                 $query = "SELECT * FROM user WHERE login = ? AND password = ?";
                 $statement = $this->kobros->db->prepare($query);
                 $parameters = array($params['login'], $params['password']);
                 $statement-> execute($parameters);
                 $res = $statement->fetch(PDO::FETCH_OBJ);
                

		
		if($res) {
			
			$_SESSION['user'] = $res;

			// Redirect
		
			if($params['redirect']) {
				
				$redirect = $params['redirect'];
			} elseif(isset($_SERVER['HTTP_REFERER'])) {
				
				$redirect = $_SERVER['HTTP_REFERER'];
			} else {
				$redirect = 'http://' . $_SERVER['HTTP_HOST'] . '/';
			}
	
			$redirectHeader = "Location: {$redirect}";
			
			header($redirectHeader);
			
			
		} else {
			
			// We fail. Serve customer with nice error messages true kobro style!

			/* Define if user exist, give error message wrong password.
			$sql = "SELECT * FROM user WHERE login = '{$params['login']}'";
			if($res = $this->kobros->db->query($sql)->fetch(PDO::FETCH_OBJ)) {
				$error = "Invalid password."; 
			} else {
				// If user not exist he given other error. */
				$error = "ei kelpaa"; //turvallisempi virheilmoitus
			
			
			$view = new View();
			$view->error = $error;
			$view->user = $_SESSION['user'];
			return $view->render(ROOT . '/templates/data/user/default.phtml');	
			
			
		
		}
		
				
	}
	

	protected function _logout($params)
	{
		
		setcookie(session_name(), $_COOKIE[session_name()], 1, '/');		
		session_destroy();  //TUHOTAAN ISTUNTO MYÖS
		if($params['redirect']) {
			
			$redirect = $params['redirect'];
		} elseif(isset($_SERVER['HTTP_REFERER'])) {
			
			$redirect = $_SERVER['HTTP_REFERER'];
		} else {
			$redirect = 'http://' . $_SERVER['HTTP_HOST'] . '/';
		} 

		$redirectHeader = "Location: {$redirect}";

                header($redirectHeader);
                
	}
	

}   