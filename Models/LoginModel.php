<?php
    class LoginModel extends Mysql{

        private $intIdUser;
        private $strUser;
        private $strPassword;
        private $strToken;

        public function __construct(){
            parent::__construct();
        }

        public function loginUser(string $user, string $password){
            $sql = "SELECT cedula,clave FROM res_profesor WHERE 
                    cedula = '$user' and 
                    clave = '$password'";
            $request = $this->select($sql);
            return $request;
        }
    }
?>