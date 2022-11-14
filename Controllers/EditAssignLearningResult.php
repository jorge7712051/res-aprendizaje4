<?php
    class EditAssignLearningResult extends Controllers{
        public function __construct(){
            parent::__construct();
        }

        public function EditAssignLearningResult(){
            if($_POST && !empty($_POST['txtUser']) && !empty($_POST['txtPassword'])){
                $strUser = strtolower(strClean($_POST['txtUser']));
                if(strlen($_POST['txtPassword']) < 64){
                    $strPassword = hash("SHA256", strClean($_POST['txtPassword']));
                } else{
                    $strPassword = strClean($_POST['txtPassword']);
                }
                $requestUser = $this->model->validateSession($strUser, $strPassword);
                if(!empty($requestUser)){
                    $data['page_tag'] = "Modificar Asignación de Resultados de Aprendizaje";
                    $data['page_title'] = "Modificación Asignación de Resultados de Aprendizaje";
                    $data['page_functions_js'] = "functions_assign_lr.js";
                    $data['user'] = $strUser;
                    $data['pass'] = $strPassword;
                    $this->views->getView($this,"EditAssignLearningResult",$data);
                } else {
                    echo "<script>window.location.href='".baseUrl()."Login'</script>";
                }
            }else {
                echo "<script>window.location.href='".baseUrl()."Login'</script>";
            }
        }

        public function getAssignLearningResultById(int $idALR){
            $id = intval(strClean($idALR));
            if($id > 0){
                $arrData = $this->model->searchAssignLearningResultById($idALR);
                $this->getByIdALRMessage($arrData);
            }
            die();
        }

        public function getAssignLearningResult(){
            $arrData = $this->model->searchAssignLearningResult();
            for($i=0; $i<count($arrData); $i++){
                $arrData[$i]['acciones'] = '<div class="text-center">
                <button class="btn btn-outline-secondary btn-sm" id="btnEditLR" onclick="editAssignLerningResultModal(this)" title="Editar" alr="'.$arrData[$i]['id'].'"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-outline-danger btn-sm" id="btnDeleteLR" onclick="deleteAssignLearningResult(this) "title="Eliminar" alr="'.$arrData[$i]['id'].'"><i class="far fa-trash-alt"></i></button>
                </div>';
            };
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function postAssignLearningResult(){
            if($_POST){
                if(empty($_POST['listLearningResult']) || empty($_POST['listTeacher']) || empty($_POST['listSubject'])){
                    $arrResponse = array("status" => false, "msg" => "Datos incorrectos.");
                } else {
                    $intLearningResult = intval(strClean($_POST['listLearningResult']));
                    $intTeacher = intval(strClean($_POST['listTeacher']));
                    $intSubject = intval(strClean($_POST['listSubject']));
                    $requestALR = $this->model->saveAssignLearningResult($intTeacher, $intSubject, $intLearningResult);
                    $arrResponse = $this->postPutAssignLRMessage($requestALR);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function putAssignLearningResult(int $intId){
            $intLearningResult = intval(strClean($_POST['listEditLearningResult']));
            $intTeacher = intval(strClean($_POST['listEditTeacher']));
            $intSubject = intval(strClean($_POST['listEditSubject']));
            $requestALR = $this->model->updateAssignLearningResult($intTeacher, $intSubject, $intLearningResult, $intId);
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