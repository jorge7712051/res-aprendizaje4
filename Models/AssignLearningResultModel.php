<?php
    class AssignLearningResultModel extends Mysql{
        public function __construct(){
            parent::__construct();
        }

        public function searchAssignLearningResultById(int $id){
            $querySelect = "SELECT prof.nombre AS teacher_name, prof.apellido AS teacher_lastname,
            esp.nombre AS academic_area 
            FROM res_asignacion_resultados_de_aprendizaje ara
            LEFT JOIN res_espacio esp ON ara.codigo_espacio = esp.codigo
            LEFT JOIN res_profesor prof ON ara.codigo_profesor = prof.codigo
            LEFT JOIN res_resultados_de_aprendizaje ra ON ara.codigo_resultados = ra.codigo WHERE ara.codigo_resultados = $id";
            $request = $this->selectAll($querySelect);
            return $request;
        }

        public function saveAssignLearningResult(int $codeTeacher, int $codeAcademicArea, int $codeLearningResult){
            $queryInsert = "INSERT INTO res_asignacion_resultados_de_aprendizaje(codigo_profesor,codigo_espacio,codigo_resultados) VALUES(?,?,?)";
            $arrData = array($codeTeacher, $codeAcademicArea, $codeLearningResult);
            $resInsert = $this->insert($queryInsert, $arrData);
            return $resInsert;
        }

        public function updateAssignLearningResult(array $arrData){
            $queryUpdate = "UPDATE res_asignacion_resultados_de_aprendizaje SET codigo_profesor = ?, codigo_espacio = ?, codigo_resultados = ? WHERE id = ?";
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