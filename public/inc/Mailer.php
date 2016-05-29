<?php
/**
 * Uusiks meni. Swiftmailer in place.
 * 
 * @author Rajanigandha Balasubramanium
 *   
 */
class Mailer
{
	
	private $_message;
	
	
	public function __construct($from, $to, $subject, $message)
	{
		// We construct mail from params.
                $swiftmsg = Swift_Message::newInstance();
                
		/*$this->_from = $from;
		$this->_to = $to;
		$this->_subject = $subject;
		$this->_message = $message;*/
                
                $swiftmsg->setSubject($subject);
                $swiftmsg->setFrom($from);
                $swiftmsg->setTo($to);
                $swiftmsg->setBody($message);
                
                $this->_message = $swiftmsg;
		
	}
	
	
	
	/**
	 * Sending dem concrete mails
	 * 
	 * @return bool Sendings on true, failings on falsE
	 */
	public function send()
	{
		/*$headers = "From: {$this->_from}";
		$params = array();
		return mail($this->_to, $this->_subject, $this->_message, $headers, null);*/
            
            $transport = Swift_SmtpTransport::newInstance('localhost', '25');
            $transport->setUsername('root');
            $transport->setPassword('root');
            
            $mailer = Swift_Mailer::newInstance($transport);
            
            $mailer->send($this->_message);
	}	
	

	
	
	
}
