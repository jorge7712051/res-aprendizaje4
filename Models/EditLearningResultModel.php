<?php
    class EditLearningResultModel extends Mysql{
        public function __construct(){
            parent::__construct();
        }

        public function validateSession(string $user, string $password){
            $sql = "SELECT cedula,clave FROM res_profesor WHERE 
                    cedula = '$user' and 
                    clave = '$password'";
            $request = $this->select($sql);
            return $request;
        }
        
        public function searchAllLearningResult(){
            $querySelect = "SELECT * FROM res_resultados_de_aprendizaje";
            $request = $this->selectAll($querySelect);
            return $request;
        }

        public function searchLearningResultById(int $id){
            $querySelect = "SELECT * FROM res_resultados_de_aprendizaje WHERE codigo = $id";
            $request = $this->select($querySelect);
            return $request;
        }

        public function searchLastCode(){
            $querySelect = "SELECT max(codigo) AS code FROM res_resultados_de_aprendizaje";
            $request = $this->selectAll($querySelect);
            return $request;
        }

        public function saveLearningResult(int $code, string $name, string $description){
            $return = "";
            $requestSelect = $this->searchLearningResultByName($name);
            if(empty($requestSelect)){
                $queryInsert = "INSERT INTO res_resultados_de_aprendizaje(codigo,descripcion,detalle) VALUES(?,?,?)";
                $arrData = array($code, $name, $description);
                $request = $this->insert($queryInsert, $arrData);
                $return = $request;
            }else{
                $return = "exist";
            }        
            return $return;   
        }
        
        public function updateLearningResult(int $code, string $name, string $description){
            $queryUpdate = "UPDATE res_resultados_de_aprendizaje SET descripcion = ?, detalle = ?  WHERE codigo = ?";
            $arrData = array($name, $description, $code);
            $request = $this->update($queryUpdate, $arrData);
            return $request;
        }

        public function deleteLearningResult(int $code){
            $sql = "DELETE FROM res_resultados_de_aprendizaje WHERE codigo = $code";
            $request = $this->delete($sql);
            return $request;
        }

        private function searchLearningResultByName(string $name){
            $querySelect = "SELECT * FROM res_resultados_de_aprendizaje WHERE descripcion = '$name'";
            $request = $this->select($querySelect);
            return $request;
        }
    }
?>