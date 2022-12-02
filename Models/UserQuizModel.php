<?php
class UserQuizModel extends Mysql
{
    public function __construct()
    {
        parent::__construct("quiz");
    }



    public function searchUserQuiz()
    {
        $querySelect = "SELECT uq.id FROM user_quiz uq left join user u ON u.id = uq.idUser left join quiz q ON q.id =uq.idQuiz where q.active = true and u.id = " . $_SESSION['iduser'] . ";";
        $request = $this->selectAll($querySelect);
        return $request;
    }

    public function searchQuizById(int $id)
    {
        $querySelect = "SELECT id, quizName, active FROM quiz WHERE id = $id";
        $request = $this->select($querySelect);
        return $request;
    }

    public function searchQuizByEmail($email)
    {
        $querySelect = "SELECT id, userName, userEmail FROM user WHERE userEmail = '" . $email . "';";
        $request = $this->select($querySelect);
        return $request;
    }




    public function loginUser($email, $password)
    {
        $sql = "SELECT id, userResponse, validate, userPassword, userName, userEmail FROM user WHERE userEmail = 
        '" . $email . "' and  validate = true";

        $request = $this->select($sql);
        if (is_array($request)) {
            if (count($request) > 0) {

                if (password_verify($password, $request['userPassword'])) {

                    $_SESSION['iduser'] = $request['id'];
                    $_SESSION['access_token'] = $request['id'];
                    $_SESSION['userResponse'] = $request['userResponse'];
                    $_SESSION['validate'] = true;
                    $_SESSION["userName"] = $request['userName'];
                    $_SESSION["userPassword"] = "";
                    $_SESSION["userEmail"] = $request['userEmail'];
                    $_SESSION["displayName"] = $_SESSION["userName"];
                    $_SESSION["photo"] = media() . "/images/uploads/user.png";
                    return true;
                } else {

                    return false;
                }
            }
        }
    }

    public function createUser($arrData)
    {
        try {
            $queryInsert = "INSERT INTO user (userName, userEmail, userPassword, privacyPolicy)
            VALUES(?, ?, ?, ?);";
            $resInsert = $this->insert($queryInsert, $arrData);
            $id = $this->connection->lastInsertId();

            $_SESSION['iduser'] = $id;

            $_SESSION['validate'] = false;
        } catch (PDOException $e) {

            if ($e->getCode() == 23000) {
                $sql = "SELECT id, userResponse, validate FROM user WHERE userEmail = '" . $arrData[1] . "' ;";

                $request = $this->select($sql);
                $_SESSION['iduser'] = $request['id'];
                $_SESSION['validate'] = true;
            }
        }


        return 1;
    }

    public function updateUser($id)
    {
        $id = base64_decode($id);
        if (is_numeric($id)) {
            $queryUpdate = "UPDATE user set validate = 1  WHERE id= ?";
            $arrData = array($id);
            $request = $this->update($queryUpdate, $arrData);
            return $request;
        }
        return false;
    }

    public function updatePassword($password, $id)
    {
        $queryUpdate = "UPDATE user set userPassword = '" . $password . "'  WHERE id= ?";
        $arrData = array($id);
        $request = $this->update($queryUpdate, $arrData);
        return $request;
    }
}
