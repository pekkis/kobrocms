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
		
		$contact = $this->kobros->db->query("SELECT * FROM contact where page_id = {$pageId}")->fetch(PDO::FETCH_OBJ); 
		
		return $contact;
		
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
		// Hackster protection!
		if(!isset($_SERVER['HTTP_REFERER']) || !preg_match("/http:\/\/{$_SERVER['HTTP_HOST']}/", $_SERVER['HTTP_REFERER'])) {
			throw new Exception('Go away evil hacksta!');
		}
		
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

                        // HAl: Swiftmailer taken into use
                        
                        $transport = Swift_SmtpTransport::newInstance('localhost', 25);
                        $mailer = Swift_Mailer::newInstance($transport);

                        $message = Swift_Message::newInstance();
                        $message->setSubject($contact->mail_subject);
                        $mailFrom = array($_POST['from']);
                        $message->setFrom($mailFrom);
                        $message->setBody($_POST['message']);
                        $message->setTo($contact->mail_to);
                        
                        $result = $mailer->send($message);
                        
                        if ($result != FALSE) {
                            // If we has forward field, we forward there. Otherwise
                            // we be using dem internal thanx page!1!

                            if(isset($_POST['forward']) && $_POST['forward']) {
                                $forwardTo = "Location: {$_POST['forward']}";                			    
                            } else {
                                $forwardTo = "Location: /?page={$this->kobros->page->id}&action=thanks";
                            }

                            header($forwardTo);			
                        }
                        else {
                            // We has error, render default wid error!
                            $view = new View();
                            $view->error = true;
                            $view->page = $this->kobros->page;
                            $view->contact = $contact;
                            return $view->render(ROOT . '/templates/data/contact/default.phtml');
                        }
		}
	}
	
	
	protected function _thanks($params)
	{
		$view = new View();
		return $view->render(ROOT . '/templates/data/employ/thanks.phtml');
	}
	
	
	
}
