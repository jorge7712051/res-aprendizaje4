<?php
    class Login extends Controllers{

        public function __construct(){
            parent::__construct();
        }

        public function Login(){
            $data['page_tag'] = 'Iniciar sesión - Resultados de aprendizaje';
            $data['page_title'] = 'Iniciar sesión';
            $data['page_functions_js'] = "functions_login.js";
            $this->views->getView($this,"Login",$data);
        }
    }
?>