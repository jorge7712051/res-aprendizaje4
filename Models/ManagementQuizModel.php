<?php
    class ManagementQuizModel extends Mysql{
        public function __construct(){
            parent::__construct("quiz");
        }

      

        public function searchQuizResult(){
            $querySelect = "SELECT q.id, q.quizName, CASE WHEN q.active = 1 THEN 'Activo' ELSE 'Desactivado' END AS active
            from quiz q";
            $request = $this->selectAll($querySelect);
            return $request;
        }

        public function searchQuizById(int $id){
            $querySelect = "SELECT id, quizName, active FROM quiz WHERE id = $id";
            $request = $this->select($querySelect);
            return $request;
        }

        public function saveQuizResult($quizName, $active){
            $queryInsert = "INSERT INTO quiz (quizName,active) VALUES(?,?)";
            $arrData = array($quizName, $active);
            $resInsert = $this->insert($queryInsert, $arrData);
            return $resInsert;
        }

        public function activeQuiz(){
            $queryUpdate = "UPDATE quiz SET active = ?";
            $arrData = array(false);
            $request = $this->update($queryUpdate, $arrData);
            return $request;
        }

        public function updateQuiz($active, $quizName, $id){
            $queryUpdate = "UPDATE quiz SET active = ? , quizName = ?   WHERE id = ?";
            $arrData = array($active, $quizName, $id);
            $request = $this->update($queryUpdate, $arrData);
            return $request;
        }


        public function deleteAssignLearningResult(int $id){
            $sql = "DELETE FROM res_asignacion_resultados_de_aprendizaje WHERE id = $id";
            $request = $this->delete($sql);
            return $request;
        }
    }
?>