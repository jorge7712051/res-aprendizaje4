<?php
    class Statistics extends Controllers{

        public function __construct(){
            parent::__construct();
        }

        public function Statistics($idLR){
            $data['page_tag'] = "Estadísticas";
            $data['page_title'] = "Tratamiento estadístico";
            $data['page_functions_js'] = "functions_stats.js";
            $data['amount_learning_result'] = $this->model->amountLearningResult();
            $data['amount_subject'] = $this->model->amountSubject();
            $data['amount_teacher'] = $this->model->amountTeacher();
            $data['amount_assign_learning_result'] = $this->model->amountAssignLearningResult();
            $data['learning_result_component'] = $this->model->learningResultComponent();
            $data['learning_result_teacher_subject'] = $this->model->learningResultTeacherSubject();
            $data['learning_result_subject'] = $this->model->learningResultSubject();
            $data['learning_result_subject_component'] = $this->model->learningResultSubjectComponent();
            $data['subject_component'] = $this->model->subjectComponent();
            $this->views->getView($this,"Statistics",$data);
        }
    }
?>