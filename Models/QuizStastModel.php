<?php
    class QuizStastModel extends Mysql{
        public function __construct(){
            parent::__construct("quiz");
        }

      

        public function getResultQuiz(){
            $querySelect = "select q.id,q.question, a.answer, COUNT(a.answer) as total, qu.quizName FROM answer a
            left join question q on q.id = a.idQuestion
            left join quiz qu on qu.id = q.idQuiz
            where qu.active= true
            and a.idQuestion in ( SELECT d.idQuestion from domain d
                      INNER join question qu on d.idQuestion = qu.id        
                                )
            GROUP BY a.answer 
            order by total DESC;";
            $request = $this->selectAll($querySelect);
            return $request;
        }

        public function getTotal(){
            $querySelect = "SELECT COUNT(uq.idQuiz) AS total FROM user_quiz uq left join quiz q on q.id= uq.idQuiz WHERE Q.active= TRUE;";
            $request = $this->select($querySelect);
            return $request;
        }

        public function getLastResponse(){
            $querySelect = "SELECT uq.dateResponse, COUNT(uq.dateResponse) as total FROM `user_quiz` uq left join quiz q on q.id = uq.idQuiz where q.active= true GROUP by uq.dateResponse;";
            $request = $this->select($querySelect);
            return $request;
        }

      
    }
?>