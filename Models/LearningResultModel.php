<?php
    class LearningResultModel extends Mysql{
        public function __construct(){
            parent::__construct();
        }
        
        public function searchAllLearningResult($offset){
            $querySelect = "SELECT * FROM res_resultados_de_aprendizaje LIMIT 12 OFFSET $offset";
            $request = $this->selectAll($querySelect);
            return $request;
        }

        public function searchAllLearningResultSelect(){
            $querySelect = "SELECT * FROM res_resultados_de_aprendizaje";
            $request = $this->selectAll($querySelect);
            return $request;
        }

        public function searchLearningResultById(int $id){
            $querySelect = "SELECT * FROM res_resultados_de_aprendizaje WHERE codigo = $id";;
            $request = $this->select($querySelect);
            return $request;
        }

        public function searchLearningResultAmount(){
            $querySelect = "SELECT count(codigo) AS amount FROM res_resultados_de_aprendizaje";
            $request = $this->selectAll($querySelect);
            return $request;
        }

        public function searchLastCode(){
            $querySelect = "SELECT max(codigo) AS code FROM res_resultados_de_aprendizaje";
            $request = $this->selectAll($querySelect);
            return $request;
        }

        public function searchBarQuery(string $words){
            $querySelect = "SELECT * FROM res_resultados_de_aprendizaje 
                            WHERE descripcion LIKE '%$words%' 
                            OR detalle LIKE '%$words%'";
            $request = $this->selectAll($querySelect);
            return $request;
        }
    }
?>