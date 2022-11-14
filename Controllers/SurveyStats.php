<?php
    class SurveyStats extends Controllers{

        public function __construct(){
            parent::__construct();
        }

        public function SurveyStats($idLR){
            $data['page_tag'] = "Estadísticas";
            $data['page_title'] = "Resultados obtenidos en la encuesta";
            $data['page_functions_js'] = "functions_survey_stats.js";
            $data['chart_title'] = $this->lRTitle($idLR);
            $data['survey'] = $this->getSurveyStatInfo($idLR);
            $this->views->getView($this,"SurveyStats",$data);
        }

        public function lRTitle(int $idLR){
            $arrData = $this->model->lRTitleData($idLR);
            return $arrData['name_lr'];
        }

        public function getSurveyStatInfo(int $idLR){
            if($idLR < 10){
                $idConverted = "varRes_0".strClean($idLR);
            } else {
                $idConverted = "varRes_".strClean($idLR);
            }
            $arrData = $this->model->survey($idConverted);
            $arrData = $this->prueba($arrData);
            return $arrData;
        }

        private function prueba($arrDataYo){
            $semesters = intval(end($arrDataYo)['semester']);
            for($index = 0; $index < $semesters; $index++){
                $arr = array();
                foreach($arrDataYo as $kintern=>$vintern){
                    if($vintern['semester'] == $index){
                        array_push($arr, $vintern);
                    }                
                }
            
                for($i = 0; $i < count($arr); $i++){
                    if(count($arr) < 5){
                        $num = $i + 1;
                    if($num != $arr[$i]['l_result']){
                            array_push($arr, array('semester' => $arr[0]['semester'], 'l_result' => $num, 'students' => 0));
                            $columnsArr = array_column($arr, 'semester');
                            array_multisort($columnsArr, SORT_ASC, $arr);
                            array_push($arrDataYo, array('semester' => $arr[0]['semester'], 'l_result' => $num, 'students' => 0));
                    } else if (count($arr) != 5) {
                            array_push($arr, array('semester' => $arr[0]['semester'], 'l_result' => $num+1, 'students' => 0));
                            $columnsArr = array_column($arr, 'semester');
                            array_multisort($columnsArr, SORT_ASC, $arr);
                            array_push($arrDataYo, array('semester' => $arr[0]['semester'], 'l_result' => $num, 'students' => 0));
                    }
                    }
                    
                }
            }
            $columns = array_column($arrDataYo, 'semester');
            array_multisort($columns, SORT_ASC, $arrDataYo);
            return $arrDataYo;
        }
    }
?>