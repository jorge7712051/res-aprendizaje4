<?php
    class QuizStast extends Controllers{

        public function __construct(){
            parent::__construct();
        }

        public function StatsQuiz(){
            $result=$this->model->getResultQuiz();
            $total =$this->model->getTotal();
            if(count($result)>0){
                $data['page_title'] = "Resultado de la encuesta: ".$result[0]['quizName'];
                $data['quiz_result'] = $this->cleanResponse( $result);
                $data['quiz_name']= $result[0]['quizName'];
                $data['quiz_total'] = $total['total'] ;
                $data['date_response'] = $this->model->getLastResponse();
            }
            else{
                $data['page_title'] = "Resultado de la encuesta: sin resultados";
                $data['quiz_result'] = "";
                $data['quiz_name']= "sin resultado";
                $data['quiz_total'] = "sin resultado";
                $data['quiz_total'] = $total['total'] ;
                $data['date_response']="";
            }
            $data['page_tag'] = "Estadística Encuesta";         
            $data['page_functions_js'] = "functions_stats.js";
            
           
            $data['response']=$result;
          
            $this->views->getView($this,"QuizStast",$data);
        }

        public function cleanResponse($array){
            $response = array();
            $tmpId=0;
            foreach($array as $value){
                if($value['id']!= $tmpId){
                   array_push($response,$value);
                   $tmpId=$value['id'];
                }
                
            }

            return  $response;

        }
    }
?>