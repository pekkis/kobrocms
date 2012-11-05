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
		
                try
                {
                  $this->kobros->validator->validateId($pageId);
                  $this->kobros->validator->validateId($limit);
                }
                catch(Exception $e)
                {
                  $message = "Method: ".__METHOD__." ".$e->getMessage()."\n";
                  file_put_contents(ROOT.'/logs/ValidationErrors', $message, FILE_APPEND);   
                  die();
                }
                try
                {
                    
                     $query = "SELECT * FROM news WHERE page_id = ? ORDER BY created DESC LIMIT {$limit}";
                     $statement = $this->kobros->db->prepare($query);
                     $parameters = array($pageId);
                     if($statement->execute($parameters))
                     {
                       	$news = array();
                        while($res = $statement->fetch(PDO::FETCH_OBJ))
                        {
                            $news[] = $res; 
                        }
                     } 
                } 
                catch(PDOException $e)
                {
                    file_put_contents(ROOT.'/logs/PDOErrors', $e->getMessage(), FILE_APPEND); 
                    die();
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

                
                
                try
                {
                  $this->kobros->validator->validateId($pageId);
                  $this->kobros->validator->validateId($itemId);
                }
                catch(Exception $e)
                {
                  $message = "Method: ".__METHOD__." ".$e->getMessage()."\n";
                  file_put_contents(ROOT.'/logs/ValidationErrors', $message, FILE_APPEND);   
                  die();
                }
                try
                {
                    
                     $query = "SELECT * FROM news WHERE page_id = ? AND id = ?";
                     $statement = $this->kobros->db->prepare($query);
                     $parameters = array($pageId, $itemId);
                     if($statement->execute($parameters))
                     {
                       	$news = array();
                        while($res = $statement->fetch(PDO::FETCH_OBJ))
                        {
                            $news[] = $res; 
                        }
                     } 
                } 
                catch(PDOException $e)
                {
                    file_put_contents(ROOT.'/logs/PDOErrors', $e->getMessage(), FILE_APPEND); 
                    die();
                }                

                if(!sizeof($news)) {
                        throw new Exception('No news be here');
                }                
			
		$view = new View();
		$view->item = $news[0];
		
		$comments = array();
                
                
                
                try
                {
                  $this->kobros->validator->validateId($view->item->id);
                }
                catch(Exception $e)
                {
                  $message = "Method: ".__METHOD__." ".$e->getMessage()."\n";
                  file_put_contents(ROOT.'/logs/ValidationErrors', $message, FILE_APPEND);   
                  die();
                }
                try
                {
                    
                     $query = "SELECT * FROM news_comments WHERE news_id = ? ORDER BY created DESC";
                     $statement = $this->kobros->db->prepare($query);
                     $parameters = array($view->item->id);
                     if($statement->execute($parameters))
                     {
                        while($res = $statement->fetch(PDO::FETCH_OBJ))
                        {
                            $comments[] = $res; 
                        }
                     } 
                } 
                catch(PDOException $e)
                {
                    file_put_contents(ROOT.'/logs/PDOErrors', $e->getMessage(), FILE_APPEND); 
                    die();
                }                
		$view->comments = $comments;
				
		return $view->render(ROOT . '/templates/data/news/view.phtml');
		
	}
	
	
	protected function _comment($params)
	{
				
		$pageId = (int) $params['page'];
		$itemId = (int) $params['id'];                
                $escapedComment = $this->kobros->escaper->escapeHtml($_POST['comment']);

                try
                {
                  $this->kobros->validator->validateId($params['page']);
                  $this->kobros->validator->validateId($params['id']);
                }
                catch(Exception $e)
                {
                  $message = "Method: ".__METHOD__." ".$e->getMessage()."\n";
                  file_put_contents(ROOT.'/logs/ValidationErrors', $message, FILE_APPEND);   
                  die();
                }
                try
                {                    
                     $query = "SELECT * FROM news WHERE page_id = ? AND id = ?";
                     $statement = $this->kobros->db->prepare($query);
                     $parameters = array($pageId, $itemId);
                     if($statement->execute($parameters))
                     {
                        $news = array();
                        while($res = $statement->fetch(PDO::FETCH_OBJ))
                        {
                            $news[] = $res; 
                        }
                     } 
                } 
                catch(PDOException $e)
                {
                    file_put_contents(ROOT.'/logs/PDOErrors', $e->getMessage(), FILE_APPEND); 
                    die();
                }                          

		
		if(!sizeof($news)) {
			throw new Exception('No news be here');
		}
		
		$item = $news[0];
		
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$sql = "INSERT INTO news_comments (news_id, comment, created) VALUES(?, ?, ?)";
		$stmt = $this->kobros->db->prepare($sql);
		
		$stmt->execute(array($item->id, $escapedComment, $now));

		
		
		$redirect = 'http://' . $_SERVER['HTTP_HOST'] . '/';
		$redirectHeader = "Location: {$redirect}";
                //file_put_contents(ROOT.'/logs/generalDebug', "functio logout:".$redirectHeader."\n", FILE_APPEND);
                
		header($redirectHeader);
		
		
		
		
	}
	
	
	
}
