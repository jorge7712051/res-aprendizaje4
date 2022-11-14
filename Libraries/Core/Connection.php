<?php
    class Connection{
        private $connect;

        public function __construct($typeConnection='default'){
            switch ($typeConnection) {
                case 'quiz':
                    $connectionString = "mysql:host=".DB_HOST_QUIZ.";dbname=".DB_NAME_QUIZ.";charset=".DB_CHARSET;
                    try{
                        $this->connect = new PDO($connectionString, DB_USER_QUIZ, DB_PASS_QUIZ);
                        $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch (Exception $e) {
                        $this->connect = "Could not connect to database";
                        echo "ERROR: ". $e;
                    }
                    break;
                
                default:
                    $connectionString = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
                    try{
                        $this->connect = new PDO($connectionString, DB_USER, DB_PASS);
                        $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch (Exception $e) {
                        $this->connect = "Could not connect to database";
                        echo "ERROR: ". $e;
                    }
                    break;
            }
            
        }

        public function connect(){
            return $this->connect;
        }
    }
?>