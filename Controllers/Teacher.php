<?php
    class Teacher extends Controllers{
        public function __construct(){
            parent::__construct();
        }

        public function getTeacher(){
            $htmlOptions = "";
            $arrData = $this->model->searchAllTeacher();
            if(count($arrData) > 0){
                for($i = 0; $i <count($arrData); $i++){
                    $htmlOptions .= '<option value="'.$arrData[$i]['codigo'].'">'.$arrData[$i]['nombre']." ".$arrData[$i]['apellido'].'</option>';
                }
            }
            echo $htmlOptions;
            die();
        }
    }
?>