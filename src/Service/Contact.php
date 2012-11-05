<?php
namespace Service;

use Doctrine\DBAL\Connection;

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
    
    public function __construct(\Swift_Mailer $mailer, Connection $connection) {
        $this->mailer = $mailer;
        
        $stmt = $connection->query('SELECT mail_to, mail_subject FROM contact WHERE id = 1');
        $contact = $stmt->fetch();
        
        $this->to = $contact['mail_to'];
        $this->subject = $contact['mail_subject'];
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
