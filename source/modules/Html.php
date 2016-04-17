<?php
/**
 * HTML module be the basicext module of them all
 * 
 * @author Devadutt Chattopadhyay
 *
 */
class Module_Html extends Module
{

	protected function _default($params)
	{
		
	    
		// If we want html from different page we get it
		if(isset($params['page']) && $params['page']) {
			$page = $this->kobros->getPage($params['page']);
		} else {
			// We not get it
			$page = $this->kobros->page;
		}

		// We fetch from da base.
                
                $sql = "SELECT content FROM html WHERE block_id = :blockId AND page_id = :pageId";
                $q = $this->kobros->db->prepare($sql);
                $q->bindParam(":blockId", $params['block_id'], PDO::PARAM_INT);
                $q->bindParam(":pageId", $page->id, PDO::PARAM_INT);
                $q->execute();

		// We put view
		$view = new View();		
		$view->html = $q->fetch(PDO::FETCH_COLUMN);
		
		// User is needed because he has maybe admin right
		$view->user = $_SESSION['user'];
		
		$view->block_id = $params['block_id'];
		
		// Viewings renderer do dirty work now
		return $view->render(ROOT . '/templates/data/html/default.phtml');

				
	}
	
	
	protected function _edit($params)
	{
		// Uh oh our application may not work like we mean.
		// Well we fix later kludge for now so look better 4 customer than really are!
		ob_get_clean();
		
		// If we want html from different page we get it
		if(isset($params['page']) && $params['page']) {
			$page = $this->kobros->getPage($params['page']);
		} else {
			// We not get it
			$page = $this->kobros->page;
		}

		// We fetch all from da base.
		$sql = "SELECT * FROM html WHERE block_id = :blockId AND page_id = :pageId";
                $q = $this->kobros->db->prepare($sql);
                $q->bindParam(":blockId", $params['block_id'], PDO::PARAM_INT);
                $q->bindParam(":pageId", $page->id, PDO::PARAM_INT);
                $q->execute();
		
		
		// We put view
		$view = new View();		
		$view->html = $q->fetch(PDO::FETCH_OBJ);
		
		// User is needed because he has maybe admin right
		$view->user = $_SESSION['user'];

		
		
		return $view->render(ROOT . '/templates/data/html/edit.phtml');
		

	}
	
	
	/**
	 *
	 * We save html here
	 * 
	 * @param $params
	 * @return string
	 */
	public function _save($params)
	{
            $user = $this->kobros->user->obj;
            if($user->role == 'admin') {
		// We use prepared statement it be safe.
		$sql = "UPDATE html SET content = :content WHERE page_id = :page AND block_id = :blockId";
		$query = $this->kobros->db->prepare($sql);
                $query->bindParam(":content", $params['content']);
                $query->bindParam(":page", $params['page'], PDO::PARAM_INT);
                $query->bindParam(":blockId", $params['block_id'], PDO::PARAM_INT);
                $query->execute();
		
		
		// After savings we go back to previous.
		header("Location: {$_SERVER['HTTP_REFERER']}");
            }
		
	}
	
	
	
	
	
}
