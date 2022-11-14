<?php
    class TeacherModel extends Mysql{
        public function __construct(){
            parent::__construct();
        }

        public function searchAllTeacher(){
            $querySelect = "SELECT codigo, nombre, apellido FROM res_profesor";
            $request = $this->selectAll($querySelect);
            return $request;
        }
    }
?>