<?php
/**
 * Poll Module (tough question be asked!)
 * 
 * @director M. Night Shyamalan
 *
 */
class Module_Poll extends Module
{

	protected function _default($params)
	{
		$view = new View();
		$view->page = $this->kobros->page;
		$view->error = false;
		
		$sql = "SELECT * FROM question WHERE id = {$params['question_id']}";
		$q = $this->kobros->db->query($sql);
		
		
		$question = $q->fetch(PDO::FETCH_OBJ);
		
		$sql = "SELECT * FROM answer WHERE question_id = {$question->id}";
		$q = $this->kobros->db->query($sql);
		
		$answers = array();
		while($res = $q->fetch(PDO::FETCH_OBJ)) {
		    $answers[] = $res;
		}
		
		// We put view
		$view = new View();		
		$view->question = $question;
		$view->answers = $answers;
		$view->forward = $params['forward'];
		
		return $view->render(ROOT . '/templates/data/poll/default.phtml');
	}	
	
	
	
	protected function _vote($params)
	{
		$sql = "UPDATE answer SET votes = votes + 1 WHERE question_id = {$params['question_id']} AND id = {$params['answer_id']}";
		$q = $this->kobros->db->exec($sql);
	    
		$forward = $params['forward'];
		header("Location: {$forward}");
		die();
		
		
	}
	
	
	protected function _twist($params)
	{
	    // Unexpected hard core plot twist be here! EASTER EGG!!!
	    
	    $sql = "SELECT * FROM answer";
		$q = $this->kobros->db->query($sql);
		
		$answers = array();
		while($res = $q->fetch(PDO::FETCH_OBJ)) {
		    $answers[] = $res;
		}	
		
		foreach($answers as $answer) {
		    $votes = rand(0, 10000);
		    $sql = "UPDATE answer SET votes = {$votes} WHERE id = {$answer->id}";
		    $q = $this->kobros->db->exec($sql);
		    		    
		}
		
	}
	
}
