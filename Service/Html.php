<?php
namespace Service;

class Html {
    
    /**
     * @var \PDO
     */
    private $db;
    
    /**
     * @param \PDO $db
     */
    public function __construct(\PDO $db) {
        $this->db = $db;
    }
    
    /**
     * @return string
     */
    public function getHome() {
        $stmt = $this->db->query("SELECT content FROM html WHERE block_id = 1 AND page_id = 1");
        return $stmt->fetchColumn();
    }
    
    /**
     * @param string $content
     */
    public function saveHome($content) {
        $sql = "UPDATE html SET content = ? WHERE page_id = ? AND block_id = ?";
		$stmt = $this->db->prepare($sql);
		
		$stmt->execute(array($content, 1, 1));
    }
    
    public function getAbout() {
        $stmt = $this->db->query("SELECT content FROM html WHERE block_id = 1 AND page_id = 2");
        return $stmt->fetchColumn();
    }
    
    public function saveAbout($content) {
        $sql = "UPDATE html SET content = ? WHERE page_id = ? AND block_id = ?";
		$stmt = $this->db->prepare($sql);
		
		$stmt->execute(array($content, 2, 1));
    }
}