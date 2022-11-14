<?php
    class SurveyStatsModel extends Mysql{
        public function __construct(){
            parent::__construct();
        }

        public function lRTitleData(int $idLR){
            $querySelect = "SELECT descripcion AS name_lr FROM res_resultados_de_aprendizaje WHERE codigo = $idLR";;
            $request = $this->select($querySelect);
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