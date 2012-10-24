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
    
    private function _newsQuery($pageId, $limit)
	{
		$limit = (int) $limit;
		
		// Be private method so no can call from module! Safe!
		
		$sql = "SELECT * FROM news WHERE page_id = {$pageId} ORDER BY created DESC LIMIT {$limit}";
		$query = $this->db->query($sql);
		$news = array();
		while($res = $query->fetch(PDO::FETCH_OBJ)) {
			$news[] = $res; 
		}
        
		return $news;
	}
	
	/**
	 * Headlines
	 * 
	 * @param $params
	 * @return string
	 */
	public function _headlines($params)
	{
		$news = $this->_newsQuery($params['page'], $params['number']);
						
		$view = new View();
		$view->news = $news;
		$view->page_id = $params['page'];
		
		return $view->render(ROOT . '/templates/data/news/headlines.phtml');
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
	
	
	public function _comment($params)
	{
				
		$pageId = (int) $params['page'];
		$itemId = (int) $params['id'];
		
		$sql = "SELECT * FROM news WHERE page_id = {$pageId} AND id = {$itemId}";
		$query = $this->db->query($sql);
		$news = array();
		while($res = $query->fetch(PDO::FETCH_OBJ)) {
			$news[] = $res; 
		}
		
		if(!sizeof($news)) {
			throw new Exception('No news be here');
		}
		
		$item = $news[0];
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$sql = "INSERT INTO news_comments (news_id, comment, created) VALUES(?, ?, ?)";
		$stmt = $this->db->prepare($sql);
		
		$stmt->execute(array($item->id, $_POST['comment'], $now));
		header("Location: {$_SERVER['HTTP_REFERER']}");
	}
}
