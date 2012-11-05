<?php
/**
 * This be a simple mailer class who be sending email!
 * 
 * @author Rajanigandha Balasubramanium
 *   
 */
class Mailer
{
	
	/**
	 * Mail from
	 * 
	 * @var string
	 */
	private $_from;
	
	private $_to;
	
	private $_subject;
	
	private $_message;
        
        private $validator;
	
	
	public function __construct($from, $to, $subject, $message)
	{
		// We construct mail from params.
            
                 $this->validator = new Validator();
                 try
                   {
                     $this->validator->validateEmailAddress($from);      
                     $this->validator->validateEmailAddress($to); 
                     $this->validator->validateEmailSubject($subject);
                     $this->validator->validateEmailMessage($message);
                   }
                   catch(Exception $e)
                   {                     
                     $message = "Method: ".__METHOD__." ".$e->getMessage()."\n";
                     file_put_contents(ROOT.'/logs/ValidationErrors', $message, FILE_APPEND);   
                     die();
                   }		
            
            
		$this->_from = $from;
		$this->_to = $to;
		$this->_subject = $subject;
		$this->_message = $message;
		
	}
	
	
	
	/**
	 * Sending dem concrete mails
	 * 
	 * @return bool Sendings on true, failings on falsE
	 */
	public function send()
	{
		$headers = "From: {$this->_from}";
		$params = array();
		return mail($this->_to, $this->_subject, $this->_message, $headers, null);
	}	
	

	
	
	
}
