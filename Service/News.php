<?php
namespace Service;

class News {
    
    /**
     * @var \PDO 
     */
    private $db;
    
    public function __construct(\PDO $db) {
        $this->db = $db;
    }
	
	/**
     * @return array
     */
	public function getHeadlines($limit)
	{
		$sql = "SELECT * FROM news ORDER BY created DESC LIMIT {$limit}";
		$query = $this->db->query($sql);
        
		$news = array();
		while ($res = $query->fetch()) {
			$news[] = $res; 
		}
        
		return $news;
    }
	

    /**
     * @return array
     */
	public function getAllNews()
	{
		$stmt = $this->db->query("SELECT * FROM news");
        return $stmt->fetchAll();
	}	
	
	/**
     * @param integer $id
     * @return array
     * @throws \Exception
     */
	public function getNewsById($id)
	{
		if ($query = $this->db->query("SELECT * FROM news WHERE id = {$id}")) {
            return $news = $query->fetch();
        } else {
            throw new \Exception('No news be here');
        }
	}
    
    /**
     * @param integer $newsId
     * @return array|null
     */
    public function getNewsComments($newsId) {
        if ($query = $this->db->query("SELECT * FROM news_comments WHERE news_id = {$newsId} ORDER BY created DESC")) {
            return $query->fetchAll();
        }
    }
	
	
	public function addCommentToNews($newsId, $comment)
	{
        // assert that news exists with given id
		$news = $this->getNewsById($newsId);

		$now = new \DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$sql = "INSERT INTO news_comments (news_id, comment, created) VALUES(?, ?, ?)";
		$stmt = $this->db->prepare($sql);
		
		$stmt->execute(array($newsId, $comment, $now));
	}
}
