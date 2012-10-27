<?php
namespace Service;

use Doctrine\DBAL\Connection;

class Poll {
    
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
     * @param integer $id
     * @return array
     */
    public function getQuestion($id) {
		$stmt = $this->db->executeQuery("SELECT * FROM question WHERE id = :id", array(
            'id' => $id
        ));
		return $stmt->fetch();
    }
    
    /**
     * @param integer $id
     * @return array
     */
    public function getAnswers($id) {
		$stmt = $this->db->executeQuery("SELECT * FROM answer WHERE question_id = :id", array(
            'id' => $id
        ));
		return $stmt->fetchAll();
    }
    
    /**
     * @param integer $questionId
     * @param integer $answerId
     */
    public function vote($questionId, $answerId) {
        $sql = "UPDATE answer SET votes = votes + 1 WHERE question_id = :questionId AND id = :answerId";
		$this->db->executeQuery($sql, array(
            'questionId' => $questionId,
            'answerId' => $answerId
        ));
    }
}