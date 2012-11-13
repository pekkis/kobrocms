<?php
/**
 * News module be about dem news showings.
 * 
 * @author Lalitchandra Pakalomattam
 * @author Devadutt Chattopadhyay
 *
 */
class Module_News extends Module
{

	private function _newsQuery($pageId, $limit)
	{
		$limit = (int) $limit;
		
		// Be private method so no can call from module! Safe!                
                
		$sql = "SELECT * FROM news WHERE page_id = :pageId ORDER BY created DESC LIMIT :limit";
		$query = $this->kobros->db->prepare($sql);
                $query->bindParam(":pageId",$pageId, PDO::PARAM_INT);
                $query->bindParam(":limit", $limit, PDO::PARAM_INT);
                $query->execute();   
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
	protected function _headlines($params)
	{
		$news = $this->_newsQuery($params['page'], $params['number']);
						
		$view = new View();
		$view->news = $news;
		$view->page_id = $params['page'];
		
		return $view->render(ROOT . '/templates/data/news/headlines.phtml');
				
	}	
	

	protected function _default($params)
	{
		$news = $this->_newsQuery($params['page'], 99999);
		$view = new View();
		$view->news = $news;
		$view->page_id = $params['page'];
		
		return $view->render(ROOT . '/templates/data/news/default.phtml');
				
	}	
	
	
	protected function _view($params)
	{
		$pageId = (int) $params['page'];
		$itemId = (int) $params['id'];
                
                $sqlSelect = "SELECT * FROM news WHERE page_id = :pageId AND id = :itemId";
                $query = $this->kobros->db->prepare($sqlSelect);
                $query->bindParam(":pageId",$pageId, PDO::PARAM_INT);
                $query->bindParam(":itemId", $itemId, PDO::PARAM_INT);
                $query->execute();                
                
		$news = array();
		while($res = $query->fetch(PDO::FETCH_OBJ)) {
			$news[] = $res; 
		}
		
		if(!sizeof($news)) {
			throw new Exception('No news be here');
		}
						
		$view = new View();
		$view->item = $news[0];
		
		$comments = array();
                
                $sqlNewsComments = "SELECT * FROM news_comments WHERE news_id = :id ORDER BY created DESC";
                $query = $this->kobros->db->prepare($sqlNewsComments);
                $query->bindParam(":id",$view->item->id, PDO::PARAM_INT);
                $query->execute();
                
		while($res = $query->fetch(PDO::FETCH_OBJ)) {
			$comments[] = $res;
		}
		
		$view->comments = $comments;
				
		return $view->render(ROOT . '/templates/data/news/view.phtml');
		
	}
	
	
	protected function _comment($params)
	{
				
		$pageId = (int) $params['page'];
		$itemId = (int) $params['id'];
		
		$sqlSelect = "SELECT * FROM news WHERE page_id = :pageId AND id = :itemId";
		$query = $this->kobros->db->prepare($sqlSelect);
                $query->bindParam(":pageId",$pageId, PDO::PARAM_INT);
                $query->bindParam(":itemId", $itemId, PDO::PARAM_INT);
                $query->execute();
                
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
		
		$sqlInsert = "INSERT INTO news_comments (news_id, comment, created) VALUES(:itemId, :comment, :now)";
		$stmt = $this->kobros->db->prepare($sqlInsert);
                $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
                $stmt->bindParam(":comment", $_POST['comment']);
                $stmt->bindParam(":now", $now);
		$stmt->execute();
		
		header("Location: {$_SERVER['HTTP_REFERER']}");
		
	}
	
	
	
}
