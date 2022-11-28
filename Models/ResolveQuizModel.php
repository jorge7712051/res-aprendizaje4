<?php

class ResolveQuizModel extends Mysql
{
    public function __construct()
    {
        parent::__construct("quiz");
    }

    public function getQuestions()
    {
        $sql = "SELECT qu.id, qu.question, qu.type, qu.required, qu.icon, q.id as 'id_quiz'  FROM question qu
        inner join quiz q on q.id=qu.idQuiz  WHERE q.active= true and qu.active = true ";
        
        $request = $this->selectAll($sql);
        if(count($request)>0){
            $_SESSION['id_quiz']=$request[0]['id_quiz'];
        }
        else{
            $_SESSION['id_quiz']=0;
        }
        
        return $request;
        
    }

    public function getDomain()
    {
        $sql = "SELECT id, domain, active, idQuestion  FROM domain WHERE active = true ";
        $request = $this->selectAll($sql);
        return $request;
    }

    public function Save($quiz)
    {
        try {
                $this->connection->beginTransaction();
                $sql = 'INSERT INTO answer (answer, idQuestion, idUser) VALUES(?, ?, ?)';
                
                foreach($quiz as $row) {
                    
                    $arrData = array($row[1], $row[0], $_SESSION['iduser']);
                    $resInsert = $this->insert($sql, $arrData);
                
                }
                $sql2 = "INSERT INTO user_quiz (idUser, idQuiz) VALUES (?,?)";
                $arrData2 = array( $_SESSION['iduser'], $_SESSION['id_quiz']);
              
                $resInsert2 = $this->insert($sql2, $arrData2);
                $this->connection->commit();
                $_SESSION['userResponse']= true;
        } catch (Exception $e) {
            $this->connection->rollBack();
            echo "Fallo: " . $e->getMessage();
        }
       
    }


    
}
