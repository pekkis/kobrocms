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
                //Nääkin pitäis varmaan katsoa läpi!
                
		$sql = "SELECT * FROM news WHERE page_id = {$pageId} ORDER BY created DESC LIMIT {$limit}";
		$query = $this->kobros->db->query($sql);
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
		
		$sql = "SELECT * FROM news WHERE page_id = {$pageId} AND id = {$itemId}";
		$query = $this->kobros->db->query($sql);
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
		$query = $this->kobros->db->query("SELECT * FROM news_comments WHERE news_id = {$view->item->id} ORDER BY created DESC");
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
		
		$sql = "SELECT * FROM news WHERE page_id = {$pageId} AND id = {$itemId}";
		$query = $this->kobros->db->query($sql);
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
		$stmt = $this->kobros->db->prepare($sql);
		
		$stmt->execute(array($item->id, $_POST['comment'], $now));

		
		
		header("Location: {$_SERVER['HTTP_REFERER']}");
		
		
		
		
	}
	
	
	
}
