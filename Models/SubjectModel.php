<?php
    class SubjectModel extends Mysql{
        public function __construct(){
            parent::__construct();
        }

        public function searchAllSubject(){
            $querySelect = "SELECT codigo, nombre FROM res_espacio";
            $request = $this->selectAll($querySelect);
            return $request;
        }

	public function searchLRTitleById(int $codeLR){
            $querySelect = "SELECT descripcion FROM res_resultados_de_aprendizaje WHERE codigo = $codeLR";
            $request = $this->select($querySelect);
            return $request;
        }

        public function searchAllSubjectByLR(int $codeLR){
            $querySelect = "SELECT esp.codigo, esp.nombre AS name_subject, prof.nombre AS name_teacher, prof.apellido AS lastname_teacher
                            FROM res_asignacion_resultados_de_aprendizaje ara
                            INNER JOIN res_espacio esp ON ara.codigo_espacio = esp.codigo
                            INNER JOIN res_profesor prof ON ara.codigo_profesor = prof.codigo
                            INNER JOIN res_resultados_de_aprendizaje ra ON ara.codigo_resultados = ra.codigo 
                            WHERE ra.codigo = $codeLR;";
            $request = $this->selectAll($querySelect);
            return $request;
        }
    }
?>