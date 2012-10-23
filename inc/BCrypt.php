<?php

/**
 * Description of BCrypt
 *
 * @author Heikki
 */
class BCrypt {
    private $rounds;
    
    public function __construct($rounds = 12) {
        if(CRYPT_BLOWFISH != 1) {
            throw new Exception("Bcrypt is not supported on this server, please see the following to learn more: http://php.net/crypt");
        }
        $this->rounds = $rounds;
    }
    
    /* Gen Salt */
    public function genSalt() {
        /* openssl_random_pseudo_bytes(16) Fallback */
        $seed = '';
        for($i = 0; $i < 16; $i++) {
            $seed .= chr(mt_rand(0, 255));
        }
        /* GenSalt */
        $salt = substr(strtr(base64_encode($seed), '+', '.'), 0, 22);
        /* Return */
        return $salt;
    }
    
    /* Gen Hash */
    public function genHash($password) {
        /* Explain '$2a$' . $this->rounds . '$' */
            /* 2a selects bcrypt algorithm */
            /* $this->rounds is the workload factor */
        /* GenHash */
        $hash = crypt($password, '$2a$' . $this->rounds . '$' . $this->genSalt());
        /* Return */
        return $hash;
    }
    
    /* Verify Password */
    public function verify($password, $existingHash) {
        /* Hash new password with old hash */
        $hash = crypt($password, $existingHash);
        
        /* Do Hashs match? */
        if($hash === $existingHash) {
            return true;
        } else {
            return false;
        }
    }
}
?>
