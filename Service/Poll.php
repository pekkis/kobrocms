<?php
namespace Service;

class Poll {
    
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
     * @param integer $id
     * @return array
     */
    public function getQuestion($id) {
		$query = $this->db->query("SELECT * FROM question WHERE id = {$id}");
		return $query->fetch();
    }
    
    /**
     * @param integer $id
     * @return array
     */
    public function getAnswers($id) {
		$query = $this->db->query("SELECT * FROM answer WHERE question_id = {$id}");
		return $query->fetchAll();
    }
    
    /**
     * @param integer $questionId
     * @param integer $answerId
     */
    public function vote($questionId, $answerId) {
        $sql = "UPDATE answer SET votes = votes + 1 WHERE question_id = {$questionId} AND id = {$answerId}";
		$this->db->exec($sql);
    }
}