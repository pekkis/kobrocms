<?php
namespace Service;

use Doctrine\DBAL\Connection;

class Html {
    
    /**
     * @var Connection
     */
    private $db;
    
    /**
     * @param \Doctrine\DBAL\Connection $db
     */
    public function __construct(Connection $db) {
        $this->db = $db;
    }
    
    /**
     * @return string
     */
    public function getHome() {
        $stmt = $this->db->query('SELECT content FROM html WHERE block_id = 1 AND page_id = 1');
        return $stmt->fetchColumn();
    }
    
    /**
     * @param string $content
     */
    public function saveHome($content) {
		$this->db->update(
                'html', 
                array('content' => $content), 
                array('page_id' => 1, 'block_id' => 1)
        );
    }
    
    public function getAbout() {
        $stmt = $this->db->query('SELECT content FROM html WHERE block_id = 1 AND page_id = 2');
        return $stmt->fetchColumn();
    }
    
    public function saveAbout($content) {
		$this->db->update(
                'html', 
                array('content' => $content), 
                array('page_id' => 2, 'block_id' => 1)
        );
    }
    
    /**
     * @return string
     */
    public function getTermsOfUse() {
        $stmt = $this->db->query('SELECT content FROM html WHERE block_id = 1 AND page_id = 100');
        return $stmt->fetchColumn();
    }
    
    /**
     * @return string
     */
    public function getPrivacyPolicy() {
        $stmt = $this->db->query('SELECT content FROM html WHERE block_id = 1 AND page_id = 99');
        return $stmt->fetchColumn();
    }
}