<?php
    class StatisticsModel extends Mysql{
        public function __construct(){
            parent::__construct();
        }
        
        public function amountLearningResult(){
            $querySelect = "SELECT count(*) as amount FROM res_resultados_de_aprendizaje";
            $request = $this->selectAll($querySelect);
            $amount = $request[0]['amount'];
            return $amount;
        }

        public function amountSubject(){
            $querySelect = "SELECT COUNT(*) as amount FROM res_espacio";
            $request = $this->selectAll($querySelect);
            $amount = $request[0]['amount'];
            return $amount;
        }

        public function amountTeacher(){
            $querySelect = "SELECT COUNT(*) as amount FROM res_profesor";
            $request = $this->selectAll($querySelect);
            $amount = $request[0]['amount'];
            return $amount;
        }

        public function amountAssignLearningResult(){
            $querySelect = "SELECT COUNT(*) as amount FROM res_asignacion_resultados_de_aprendizaje";
            $request = $this->selectAll($querySelect);
            $amount = $request[0]['amount'];
            return $amount;
        }

        public function learningResultComponent(){
            $querySelect = "SELECT c.nombre, count(ara.id) AS amount FROM res_asignacion_resultados_de_aprendizaje ara
                            LEFT JOIN res_espacio e ON e.codigo = ara.codigo_espacio
                            LEFT JOIN res_componente c ON c.codigo = e.codigo_componente
                            GROUP BY c.codigo;";
            $request = $this->selectAll($querySelect);
            return $request;
        }

        public function learningResultTeacherSubject(){
            $querySelect = "SELECT ra.descripcion, COUNT(distinct ara.codigo_espacio) AS amount_subject, 
                            COUNT(distinct ara.codigo_profesor) AS amount_teacher 
                            FROM res_asignacion_resultados_de_aprendizaje ara
                            INNER JOIN res_resultados_de_aprendizaje ra ON ara.codigo_resultados = ra.codigo
                            GROUP BY ra.descripcion";
            $request = $this->selectAll($querySelect);
            return $request;
        }

        public function learningResultSubject(){
            $querySelect = "SELECT esp.nombre, count(ara.codigo_resultados) as amount 
                            FROM res_asignacion_resultados_de_aprendizaje ara
                            INNER JOIN res_espacio esp ON ara.codigo_espacio = esp.codigo
                            INNER JOIN res_resultados_de_aprendizaje ra ON ara.codigo_resultados = ra.codigo 
                            GROUP BY ara.codigo_espacio ORDER BY amount DESC";
            $request = $this->selectAll($querySelect);
            return $request;
        }

        public function learningResultSubjectComponent(){
            $querySelect = "SELECT com.nombre as compo, esp.nombre, count(ara.codigo_resultados) as amount FROM res_asignacion_resultados_de_aprendizaje ara
                            INNER JOIN res_espacio esp ON ara.codigo_espacio = esp.codigo
                            INNER JOIN res_resultados_de_aprendizaje ra ON ara.codigo_resultados = ra.codigo 
                            INNER JOIN res_componente com ON com.codigo = esp.codigo_componente
                            GROUP BY esp.codigo_componente, ara.codigo_espacio ORDER BY com.nombre DESC;";
            $request = $this->selectAll($querySelect);
            return $request;
        }

        public function subjectComponent(){
            $querySelect = "SELECT c.nombre, count(e.codigo) AS amount FROM res_espacio e
                            LEFT JOIN res_componente c ON c.codigo = e.codigo_componente
                            GROUP BY c.codigo ORDER BY amount DESC;";
            $request = $this->selectAll($querySelect);
            return $request;
        }

        public function survey(string $idLR){
            $querySelect = "SELECT Permanencia_en_Semestres AS semester, $idLR AS l_result, COUNT(codigo) AS students FROM res_encuesta_resultados rer
                        GROUP BY $idLR, Permanencia_en_Semestres
                        ORDER BY Permanencia_en_Semestres, $idLR;";
            $request = $this->selectAll($querySelect);
            return $request;
        }
    }
?>