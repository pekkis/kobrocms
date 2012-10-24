<?php
/**
 * CHANGELOKI:
 * - Poistettu käytännössä turha referer parametri.
 * - action=login funktion käyttäjäsyötteeseen lisätty escapetus.
 * - action=logout funktioon lisätty piparien deletointi server-side.
 * 
 * 
 * User module
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
            
                $username = $this->kobros->db->quote($params['username']);
                $passwd = $this->kobros->db->quote($params['passwd']);
		$sql = "SELECT * FROM user WHERE login = {$username} AND password = {$passwd}";
                
                
		
		$res = $this->kobros->db->query($sql)->fetch(PDO::FETCH_OBJ);
		
		if($res) {
			// We find user, we set dem sessions users. Rock on!
			$_SESSION['user'] = $res;
			
			
		} else {
			
			//Wrong user or pw
                    
			$error = "Check your username and password.";
			
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
            $filename = ('/../../../../../tmp/sess_' . $params['KBRSI']);
            unlink($filename);
		
	}
	
}
