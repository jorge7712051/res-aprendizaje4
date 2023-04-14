<?php
session_start();
    class ManagementQuiz extends Controllers{
        public function __construct(){
            parent::__construct();
        }

        public function viewQuiz(){
            if(isset($_SESSION['user'])){
                              
                    $data['page_tag'] = "Administración encuesta egresados";
                    $data['page_title'] = "Administración encuesta egresados";
                    $data['page_functions_js'] = "functions_assign_quiz.js";
                    $data['user'] = $_SESSION['user'];
                    $data['pass'] = $_SESSION['pass'];
                    $this->views->getView($this,"ManagementQuiz",$data);
               
            }else {
                echo "<script>window.location.href='".baseUrl()."Login'</script>";
            }
        }

        public function getQuizById(int $idALR){
            $id = intval(strClean($idALR));
            if($id > 0){
                $arrData = $this->model->searchQuizById($idALR);
                $this->getByIdALRMessage($arrData);
            }
            die();
        }

        public function getQuizResult(){
            $arrData = $this->model->searchQuizResult();
            for($i=0; $i<count($arrData); $i++){
                $arrData[$i]['acciones'] = '<div class="row">
                <div class="col-2">
                    <button class="btn btn-outline-secondary btn-sm" id="btnEditLR" onclick="editQuizModal(this)" title="Editar" alr="'.$arrData[$i]['id'].'"><i class="fas fa-pencil-alt"></i></button> 
                </div>
                <div class="col-10">
                    <form name="EALR" id="EALR" action="'.baseUrl().'ManagementQuestion/viewAnswer/?id='.$arrData[$i]['id'].'" method="post">
                        <button class="btn btn-danger btn-sm" id="btnEditLR" title="Editar" alr="'.$arrData[$i]['id'].'" type="submit"><i class="bi bi-cloud-arrow-down"></i> Descarga de respuestas</button>
                    </form>
                </div>       
                </div>';
            };
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getQuizSelect(){
            $htmlOptions = "";
            $arrData = $this->model->searchQuizResult();
            if(count($arrData) > 0){
                for($i = 0; $i <count($arrData); $i++){
                    $htmlOptions .= '<option value="'.$arrData[$i]['id'].'">'.$arrData[$i]['quizName'].'</option>';
                }
            }
            echo $htmlOptions;
            die();
        }

        public function postQuiz(){
            if($_POST){
                if(empty($_POST['quizName'])){
                    $arrResponse = array("status" => false, "msg" => "Datos incorrectos.");
                } else {
                    if (isset($_POST['active'])) {
                        $active = true;    
                        $this->model->activeQuiz();     
                    }
                    else{
                        $active = false;
                    }
                   
                    $quizName = strClean($_POST['quizName']);                
                    
                    $requestALR = $this->model->saveQuizResult($quizName, $active);
                    $arrResponse = $this->postPutAssignLRMessage($requestALR);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function putQuiz(int $intId){

            if (isset($_POST['editActive'])) {
                $active = true;    
                $this->model->activeQuiz();     
            }
            else{
                $active = false;
            }
            $quizName = strClean($_POST['quizName']); 
            $requestALR = $this->model->updateQuiz($active, $quizName, $intId);
            $arrResponse = $this->postPutAssignLRMessage($requestALR);
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function deleteAssignLearningResult($id){
            $data = $this->model->deleteAssignLearningResult($id);
            $this->deleteAssignLRMessage($data);
        }

        private function getByIdALRMessage($arrData){
            $arrResponse = "";
            if (empty($arrData)){
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
            } else {
                $arrResponse = array('status' => true, 'msg' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

            return $arrResponse;
        }

        private function postPutAssignLRMessage($arrData){
            $arrResponse = "";
            if($arrData > 0){
                $arrResponse = array('status' => true, 'msg' => 'Datos procesados correctamente.');
            } else if($arrData == 'exist'){
                $arrResponse = array('status' => false, 'msg' => '¡Advertencia! La asignación ya existe.');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
            }
            return $arrResponse;
        }

        private function deleteAssignLRMessage($arrData){
            $arrResponse = "";
            if (empty($arrData)){
                $arrResponse = array('status' => false, 'msg' => 'No es poisble eliminar los datos.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'El resultado de aprendizaje ha sido eliminado');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

            return $arrResponse;
        }
    }
?>