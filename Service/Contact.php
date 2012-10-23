<?php
namespace Service;

class Contact {
    public function sendContact($fromEmail, $message) {
        if (!filter_var($fromEmail, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        
        if (empty($message)) {
            return false;
        }
        
        return true;
    }
}
