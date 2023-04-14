<?php

class ManagementQuestionModel extends Mysql
{
    public function __construct()
    {
        parent::__construct("quiz");
    }



    public function searchQuestionResult()
    {
        $querySelect = "SELECT 
        q.id, q.question, q.type,  CASE WHEN q.required = 1 THEN 'Requerido' ELSE 'No requerido' END AS required , q.icon, qu.quizName
        from question q        
        INNER join quiz qu on qu.id= q.idQuiz
        WHERE q.active = true 
        ORDER by qu.id ASC;";
        $request = $this->selectAll($querySelect);
        return $request;
    }

    public function searchDomainResult()
    {
        $querySelect = "SELECT d.id, d.idQuestion, d.domain
        from domain d ;";
        $request = $this->selectAll($querySelect);
        return $request;
    }

    public function searchDomainResultById($id)
    {
        $querySelect = "SELECT d.id, d.idQuestion, d.domain
        from domain d 
        WHERE d.idQuestion= " . $id . ";";
        $request = $this->selectAll($querySelect);
        return $request;
    }

    public function searchQuestionById(int $id)
    {
        $querySelect = "SELECT 
        q.id, q.question, q.type, q.required , q.icon, qu.quizName , qu.id AS 'idQuiz'
        from question q        
        INNER join quiz qu on qu.id= q.idQuiz
        WHERE q.id = " . $id . " 
        ORDER by qu.id ASC";
        $request = $this->select($querySelect);
        return $request;
    }

    public function saveQuestionResult($required, $type, $icon, $questionName, $listQuiz, $domain = array())
    {
        if (count($domain) > 0) {
            try {
                $this->connection->beginTransaction();
                $queryInsert = "INSERT INTO question (question, type, required, icon, idQuiz) VALUES (?,?,?,?,?)";
                $arrData = array($questionName, $type, $required, $icon, $listQuiz);
                $resInsert = $this->insert($queryInsert, $arrData);
                $id = $this->connection->lastInsertId();
                foreach ($domain as &$valor) {
                    $queryInsert2 = "INSERT INTO domain (domain, idQuestion) VALUES (?,?)";
                    $arrData2 = array($valor, $id);
                    $resInsert = $this->insert($queryInsert2, $arrData2);
                }
                $this->connection->commit();
                return 1;
            } catch (\Throwable $th) {
                $this->connection->rollback();
                return 0;
            }
        } else {
            $queryInsert = "INSERT INTO question (question, type, required, icon, idQuiz) VALUES (?,?,?,?,?)";
            $arrData = array($questionName, $type, $required, $icon, $listQuiz);
            $resInsert = $this->insert($queryInsert, $arrData);
            return $resInsert;
        }
    }

    public function activeQuestionResult()
    {
        $queryUpdate = "UPDATE quiz SET active = ?";
        $arrData = array(false);
        $request = $this->update($queryUpdate, $arrData);
        return $request;
    }

    public function updateQuestion($arrData, $domain = array())
    {
        if (count($domain) > 0) {
            try {
                $this->connection->beginTransaction();
                $queryUpdate = "UPDATE question SET question= ?, type= ?, required = ?, icon= ?, idQuiz = ?  WHERE id = ?";
                $sql = "DELETE FROM domain WHERE idQuestion =" . $arrData[5];
                $request = $this->delete($sql);
                $resInsert = $this->update($queryUpdate, $arrData);
                foreach ($domain as &$valor) {
                    $queryInsert2 = "INSERT INTO domain (domain, idQuestion) VALUES (?,?)";
                    $arrData2 = array($valor, $arrData[5]);
                    $resInsert = $this->insert($queryInsert2, $arrData2);
                }
                $this->connection->commit();
                return 1;
            } catch (\Throwable $th) {
                $this->connection->rollback();
                return 0;
            }
        } else {
            $queryUpdate = "UPDATE question SET question= ?, type= ?, required = ?, icon= ?, idQuiz = ?  WHERE id = ?";
            $request = $this->update($queryUpdate, $arrData);
            return $request;
        }
    }




    public function deleteQuestion(int $id)
    {
        $queryUpdate = "UPDATE question SET active= 0  WHERE id = ?";
        $arrData = array($id);
        $request = $this->update($queryUpdate, $arrData);
        return $request;
    }

    public function getAnswer($id)
    {
        $querySelect = "select a.answer,a.idUser ,q.id, q.question, u.userEmail 
        FROM answer a 
        LEFT join question q on q.id= a.idQuestion 
        LEFT join user u on u.id= a.idUser 
        WHERE q.idQuiz=".$id." 
        AND  q.active = true
        order by a.idUser ASC, q.id ASC;";
        $request = $this->selectAll($querySelect);
        return $request;
    }

    public function getQuestion()
    {
        $querySelect = "select q.id, q.question FROM question q left join quiz qu on qu.id= q.idQuiz where qu.active= true
        and q.active= true;";
        $request = $this->selectAll($querySelect);
        return $request;
    }
}
