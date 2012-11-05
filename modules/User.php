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
		//var_dump($_SESSION);	
                //die();
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
                     echo "Raimoa suututtaa Validaatio."; 
                     die();
                     //$message = "Method: ".__METHOD__." ".$e->getMessage()."\n";
                     //file_put_contents('../errorlogs/ValidationErrors.txt', $message, FILE_APPEND);   
                   }

                 
                 try
                 {
                     
                     
                     
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
                     
                     //get salt from passwd
                     $salt = substr($userHashedPassword, 3, 15);
                     
                     // generate hash from input passwd & hash.    
                     $hash = produceHash($params['password'], $salt);
                     
                     //var_dump($hash);
                     //var_dump($userHashedPassword);
                     
                     
                     
                     if(strcmp($userHashedPassword, $hash))
                     {
                          echo "success!!";
                          //check if hashed passwrd matches
                          //$sql = "SELECT * FROM user WHERE login = '{$params['login']}' AND password = '{$params['password']}'";
                          //$query = "SELECT * FROM user WHERE login = ? AND password = ?";
                          $query = "SELECT * FROM user WHERE login = ?";
                          $statement = $this->kobros->db->prepare($query);                     
                          $parameters = array($params['login']);                     
                          //$res = $this->kobros->db->query($sql)->fetch(PDO::FETCH_OBJ);
                          if($statement->execute($parameters))
                          {
                            $res = $statement->fetch(PDO::FETCH_OBJ);

                            if($res) 
                            {  
                                /*
                                 $error = print_r($res);; 
                                 $view = new View();
                                 $view->error = $error;
                                 $view->user = $_SESSION['user'];
                                 return $view->render(ROOT . '/templates/data/user/default.phtml');	   
                                 */

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
                             } 
                             else 
                             {
                                    $error = "Login failed. Tried to access with passwd: ".$hash; 
                                    $view = new View();
                                    $view->error = $error;
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
                    echo "Raimoa suututtaa."; 
                    die();
                    //file_put_contents('../errorlogs/PDOErrors.txt', $e->getMessage(), FILE_APPEND); 
                }   		
	}
	

	protected function _logout($params)
	{
		// We log out. Set cookie to expire in 1970, redirect. User now anonymous 4 good.
		setcookie(session_name(), $_COOKIE[session_name()], 1, '/');	
                session_destroy();
		
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
