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
                try
                {
                  $this->kobros->validator->validateUserOrPass($params['login']);
                  $this->kobros->validator->validateUserOrPass($params['password']);

                }
                catch(Exception $e)
                {
                  $message = "Method: ".__METHOD__." ".$e->getMessage()."\n";
                  file_put_contents(Root.'/logs/ValidationErrors', $message, FILE_APPEND);   
                  die();
                }
                 
                try
                {                    
                     usleep(10000+rand(10,4000000));
                     // get user based on name
                     $query = "SELECT * FROM user WHERE login = ?";
                     $statement = $this->kobros->db->prepare($query);
                     $parameters = array($params['login']);
                     if($statement->execute($parameters))
                     {
                       $res = $statement->fetch(PDO::FETCH_ASSOC);
                     }
                     if($res)
                     {
                       $userHashedPassword = $res['password'];                      
                     }
                     
                     $salt = substr($userHashedPassword, 3, 15);                        
                     $hash = produceHash($params['password'], $salt);
                     
                     
                     
                     
                     if(strcmp($userHashedPassword, $hash))
                     {
                          $query = "SELECT * FROM user WHERE login = ?";
                          $statement = $this->kobros->db->prepare($query);                     
                          $parameters = array($params['login']);                     
                          //$res = $this->kobros->db->query($sql)->fetch(PDO::FETCH_OBJ);
                          if($statement->execute($parameters))
                          {
                            $res = $statement->fetch(PDO::FETCH_OBJ);

                            if($res) 
                            {  
                                    $_SESSION['user'] = $res;

                                    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . '/';
                                    $redirectHeader = "Location: {$redirect}";
                                    
                                    //file_put_contents(ROOT.'/logs/generalDebug', "functio login:".$redirectHeader."\n", FILE_APPEND);
                                    header($redirectHeader);
                             } 
                             else 
                             {
                                    //$error = "Login failed. Tried to access with passwd: ".$hash; 
                                    $view = new View();
                                    //$view->error = $error;
                                    $view->user = $_SESSION['user'];
                                    return $view->render(ROOT . '/templates/data/user/default.phtml');	
                             }                            

                           }                          
                     }
                     else
                     {
                         echo "not success";
                     }                
                }                 
                catch(PDOException $e)
                {
                    file_put_contents('../errorlogs/PDOErrors.txt', $e->getMessage(), FILE_APPEND); 
                    die();
                    
                }   		
	}
	

	protected function _logout($params)
	{
		// We log out. Set cookie to expire in 1970, redirect. User now anonymous 4 good.
		setcookie(session_name(), $_COOKIE[session_name()], 1, '/');	
                session_destroy();
                $redirect = 'http://' . $_SERVER['HTTP_HOST'] . '/';
		$redirectHeader = "Location: {$redirect}";
                //file_put_contents(ROOT.'/logs/generalDebug', "functio logout:".$redirectHeader."\n", FILE_APPEND);
                
		header($redirectHeader);
	}
	
}
