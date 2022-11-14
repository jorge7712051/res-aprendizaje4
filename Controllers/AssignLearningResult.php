<?php
    class AssignLearningResult extends Controllers{
        public function __construct(){
            parent::__construct();
        }

        public function getAssignLearningResultById($id){
            $data = $this->model->searchAssignLearningResultById($id);
        }

        public function postLearningResult($codeTeacher, $codeAcademicArea, $codeLearningResult){
            $data = $this->model->saveAssignLearningResult($teacherCode, $codeAcademicArea, $codeLearningResult);
        }

        public function putAssignLearningResult($codeTeacher, $codeAcademicArea, $codeLearningResult, $id){
            $arrData = array($codeTeacher, $codeAcademicArea, $codeLearningResult, $id);
            $data = $this->model->updateAssignLearningResult($arrData);
        }

        public function deleteAssignLearningResult($id){
            $data = $this->model->deleteAssignLearningResult($id);
        }
    }
?>