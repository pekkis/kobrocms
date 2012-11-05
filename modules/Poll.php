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
                try
                {
                  $this->kobros->validator->validateId($params['question_id']);
                  $this->kobros->validator->validatePage1Forward($params['forward']);

                }
                catch(Exception $e)
                {                     
                  $message = "Method: ".__METHOD__." ".$e->getMessage()."\n";
                  file_put_contents(ROOT.'/logs/ValidationErrors', $message, FILE_APPEND);   
                  die();
                }

            
                $view = new View();
		$view->page = $this->kobros->page;
		$view->error = false;
		
		$sql = "SELECT * FROM question WHERE id = ?";
                $statement = $this->kobros->db->prepare($sql);
                $parameters = array($params['question_id']);
		//$q = $this->kobros->db->query($sql);
                if($statement->execute($parameters))
                {
                  $question = $statement->fetch(PDO::FETCH_OBJ);
                }		
		
		//$question = $statement->fetch(PDO::FETCH_OBJ);		
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
                try
                {
                  $this->kobros->validator->validateId($params['question_id']);
                  $this->kobros->validator->validateId($params['answer_id']);
                  $this->kobros->validator->validatePage1Forward($params['forward']);

                }
                catch(Exception $e)
                {
                  $message = "Method: ".__METHOD__." ".$e->getMessage()."\n";
                  file_put_contents(ROOT.'/logs/ValidationErrors', $message, FILE_APPEND);   
                  die();
                }
                $parameters = array($params['question_id'],$params['answer_id']);
		$sql = "UPDATE answer SET votes = votes + 1 WHERE question_id = ? AND id = ?";
                $statement = $this->kobros->db->prepare($sql); 
                $statement->execute($parameters);
	    
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
                
                try
                {
                  $this->kobros->validator->validateId($answer->id);                     
                }
                catch(Exception $e)
                {
                  $message = "Method: ".__METHOD__." ".$e->getMessage()."\n";
                  file_put_contents(ROOT.'/logs/ValidationErrors', $message, FILE_APPEND);   
                  die();
                }
                
		
		foreach($answers as $answer) {
		    $votes = rand(0, 10000);
                    $sql = "UPDATE answer SET votes = ? WHERE id = ?";    
                    $stmt = $this->kobros->db->prepare($sql);		
                    $stmt->execute(array($votes, $answer->id));                    
		   
		    		    
		}
		
	}
	
}
