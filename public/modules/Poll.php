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
                $sql = $this->kobros->db->prepare("SELECT * FROM question WHERE id = ?");
                $sql->bindParam(1, $params['question_id'], PDO::PARAM_STR);
                
                $sql->execute();

                $question = $sql->fetch(PDO::FETCH_OBJ);
                $sql = $this->kobros->db->prepare("SELECT * FROM answer WHERE question_id = ?");
                $sql->bindParam(1, $params['question_id'], PDO::PARAM_INT);
                $sql->execute();

                $answers = array();
        while($res = $sql->fetch(PDO::FETCH_OBJ)) {
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

                $sql = $this->kobros->db->prepare("UPDATE answer SET votes = votes + 1 WHERE question_id = ? AND id = ?");
                $sql->bindParam(1, $params['question_id'], PDO::PARAM_INT);
                $sql->bindParam(2, $params['answer_id'], PDO::PARAM_INT);
                $sql->execute();

                $forward = '/?page=1';
                header("Location: {$forward}");
                die();


}


        protected function _twist($params)
{

            $sql = $this->kobros->db->prepare("SELECT * FROM answer");
            $sql->execute();

            $answers = array();
            while($res = $sql->fetch(PDO::FETCH_OBJ)) {
                $answers[] = $res;
            }	

            foreach($answers as $answer) {
                    $votes = rand(0, 10000);
                    $sql = $this->kobros->db->prepare("UPDATE answer SET votes = ? WHERE id = ?");
                    $sql->bindParam(1, $votes, PDO::PARAM_INT);
                    $sql->bindParam(2, $answer->id, PDO::PARAM_INT);
                    $sql->execute();

             }

        }

}