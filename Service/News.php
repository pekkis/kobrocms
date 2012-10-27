<?php
namespace Service;

use Doctrine\DBAL\Connection;

class News {
    
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
     * @return array
     */
	public function getHeadlines($limit)
	{
		$sql = 'SELECT * FROM news ORDER BY created DESC LIMIT :limit';
		$stmt = $this->db->executeQuery($sql, array('limit' => (int) $limit), array('limit' => 1));
        
		$news = array();
		while ($res = $stmt->fetch()) {
			$news[] = $res; 
		}
        
		return $news;
    }
	

    /**
     * @return array
     */
	public function getAllNews()
	{
		$stmt = $this->db->query('SELECT * FROM news');
        return $stmt->fetchAll();
	}	
	
	/**
     * @param integer $id
     * @return array
     * @throws \Exception
     */
	public function getNewsById($id)
	{
        $stmt = $this->db->executeQuery('SELECT * FROM news WHERE id = :id', array(
            'id' => $id
        ));
        
        return $stmt->fetch();
	}
    
    /**
     * @param integer $newsId
     * @return array|null
     */
    public function getNewsComments($newsId) {
        $sql = 'SELECT * FROM news_comments WHERE news_id = :newsId ORDER BY created DESC';
        $stmt = $this->db->executeQuery($sql, array(
           'newsId' => $newsId 
        ));
        
        return $stmt->fetchAll();
    }
	
	
	public function addCommentToNews($newsId, $comment)
	{
        // assert that news exists with given id
		$news = $this->getNewsById($newsId);
        
        if (!$news) {
            throw new \InvalidArgumentException('No news exists with given id');
        }

		$now = new \DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$sql = 'INSERT INTO news_comments (news_id, comment, created) VALUES(?, ?, ?)';
		$stmt = $this->db->prepare($sql);
		
		$stmt->execute(array($newsId, $comment, $now));
	}
}
