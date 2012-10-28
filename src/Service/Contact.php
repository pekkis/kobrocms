<?php
namespace Service;

class Contact {
    
    /**
     * @var Swift_Mailer
     */
    private $mailer;
    
    /**
     * @var string
     */
    private $to;
    
    /**
     * @var string
     */
    private $subject;
    
    public function __construct(\Swift_Mailer $mailer, $sendMailsTo, $emailSubject) {
        $this->mailer = $mailer;
        $this->to = $sendMailsTo;
        $this->subject = $emailSubject;
    }
    
    public function sendContact($fromEmail, $message) {
        if (!filter_var($fromEmail, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        
        if (empty($message)) {
            return false;
        }
        
        $email = \Swift_Message::newInstance()
            ->setTo($this->to)
            ->setSubject($this->subject)
            ->setFrom($fromEmail)
            ->setBody($message);
        
        $this->mailer->send($email);
        
        return true;
    }
}
