<?php
/**
 * Contact Module
 * 
 * @author Lalitchandra Pakalomattam
 * @author Rajanigandha Balasubramanium
 * @todo Form Editor now the form just be static it still be good tho!
 *
 */
class Module_Contact extends Module
{

	/**
	 * 
	 * We be getting da STD from contact!
	 * 
	 * @param $pageId Page id
	 * @return stdClass Contact stuff
	 */
	private function _getContact($pageId)
	{
		$pageId = (int) $pageId;
		
                try
                   {
                     $this->kobros->validator->validateId($pageId);
                   }
                   catch(Exception $e)
                   {                     
                     $message = "Method: ".__METHOD__." ".$e->getMessage()."\n";
                     file_put_contents(ROOT.'/logs/ValidationErrors', $message, FILE_APPEND);   
                     die();
                   }
                try
                {
                    
                     $query = "SELECT * FROM contact where page_id = ?";
                     $statement = $this->kobros->db->prepare($query);
                     $parameters = array($pageId);
                     if($statement->execute($parameters))
                     {
                       return $statement->fetch(PDO::FETCH_OBJ);
                     } 
                }
                catch(PDOException $e)
                {
                        file_put_contents(ROOT.'/logs/PDOErrors', $e->getMessage(), FILE_APPEND); 
                        die();
                } 
		
	}
	
	
	protected function _default($params)
	{
		$view = new View();
		$view->page = $this->kobros->page;
		
		$contact = $this->_getContact($params['page']);

		if(!$contact) {
			throw new Exception('Contact data not found');
		}
		
		$view->contact = $contact;

		$view->error = false;
		
		$view->forward = $params['forward'];
		
		return $view->render(ROOT . '/templates/data/contact/default.phtml');
	}	
	
	
	
	protected function _send($params)
	{
		/*
                // Hackster protection!
		if(!isset($_SERVER['HTTP_REFERER']) || !preg_match("/http:\/\/{$_SERVER['HTTP_HOST']}/", $_SERVER['HTTP_REFERER'])) {
			throw new Exception('Go away evil hacksta!');
		}
                 * 
                 */
		
		$contact = $this->_getContact($params['page']);
			
		if(!$contact) {
			throw new Exception('Contact data not found');
		}

		$error = false;
		
		if(!isset($_POST)) {
			$error = true;
			
		} else {
			
			if(!isset($_POST['from']) || !isset($_POST['message']) || !$_POST['from'] || !$_POST['message']) {
				$error = true;
			}
		}

		
		if($error) {
			// We has error, render default wid error!
			$view = new View();
			$view->error = true;
			$view->page = $this->kobros->page;
			
			
			$view->contact = $contact;
			
			return $view->render(ROOT . '/templates/data/contact/default.phtml');
		} else {

			// mailer and redirect be here
			
			$mail = new Mailer($_POST['from'], $contact->mail_to, $contact->mail_subject, $_POST['message']);
			$mail->send();
	
                        $redirect = 'http://' . $_SERVER['HTTP_HOST'] . '/';
                        $redirectHeader = "Location: {$redirect}";
                        //file_put_contents(ROOT.'/logs/generalDebug', "functio logout:".$redirectHeader."\n", FILE_APPEND);

                        header($redirectHeader);                        

		}
		
		
	}
	
	
	protected function _thanks($params)
	{
		$view = new View();
		return $view->render(ROOT . '/templates/data/employ/thanks.phtml');
	}
	
	
	
}
