<?php
    class Mysql extends Connection{
        private $conecction;
        private $strquery;
        private $arrValues;

        function __construct($typeConnection='default'){
            $this->connection = new Connection($typeConnection);
            $this->connection = $this->connection->connect();
        }

        public function insert(string $query, array $arrValues){
            $this->strquery = $query;
            $this->arrValues = $arrValues;
            $insert = $this->connection->prepare($this->strquery);
            $resInsert = $insert->execute($this->arrValues);
            $lastInsert = ($resInsert == 1) ? 1 : 0;
            return $lastInsert;
        }

        public function select(string $query){
            $this->strquery = $query;
            $result = $this->connection->prepare($this->strquery);
            $result->execute();
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data;
        }

        public function selectAll(string $query){
            $this->strquery = $query;
            $result = $this->connection->prepare($this->strquery);
            $result->execute();
            $data = $result->fetchall(PDO::FETCH_ASSOC);
            return $data;
        }

        public function update(string $query, array $arrValues){
            $this->strquery = $query;
            $this->arrValues = $arrValues;
            $update = $this->connection->prepare($this->strquery);
            $result = $update->execute($this->arrValues);
            return $result;
        }

        public function delete(string $query){
            $this->strquery = $query;
            $result = $this->connection->prepare($this->strquery);
            $delete = $result->execute();
            return $delete;
        }
    }
?>