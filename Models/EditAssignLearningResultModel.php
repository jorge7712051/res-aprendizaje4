<?php
    class EditAssignLearningResultModel extends Mysql{
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

        public function searchAssignLearningResult(){
            $querySelect = "SELECT ara.id, ra.descripcion AS learning_result,
             prof.nombre AS teacher_firstname,
             prof.apellido AS teacher_lastname,
            esp.nombre as subject 
            from res_asignacion_resultados_de_aprendizaje ara
            LEFT JOIN res_espacio esp ON ara.codigo_espacio = esp.codigo
            LEFT JOIN res_profesor prof ON ara.codigo_profesor = prof.codigo
            LEFT JOIN res_resultados_de_aprendizaje ra ON ara.codigo_resultados = ra.codigo";
            $request = $this->selectAll($querySelect);
            return $request;
        }

        public function searchAssignLearningResultById(int $id){
            $querySelect = "SELECT * FROM res_asignacion_resultados_de_aprendizaje WHERE id = $id";
            $request = $this->select($querySelect);
            return $request;
        }

        public function saveAssignLearningResult(int $codeTeacher, int $codeSubject, int $codeLearningResult){
            $queryInsert = "INSERT INTO res_asignacion_resultados_de_aprendizaje(codigo_profesor,codigo_espacio,codigo_resultados) VALUES(?,?,?)";
            $arrData = array($codeTeacher, $codeSubject, $codeLearningResult);
            $resInsert = $this->insert($queryInsert, $arrData);
            return $resInsert;
        }

        public function updateAssignLearningResult(int $intTeacher, int $intSubject, int $intLearningResult, int $intId){
            $queryUpdate = "UPDATE res_asignacion_resultados_de_aprendizaje SET codigo_profesor = ?, codigo_espacio = ?, codigo_resultados = ? WHERE id = ?";
            $arrData = array($intTeacher, $intSubject, $intLearningResult, $intId);
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