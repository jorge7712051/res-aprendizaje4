<?php
    class ResetPassword extends Controllers{

        public function __construct(){
            parent::__construct();
        }

        public function ResetPassword(){
            $data['page_tag'] = 'Recuperar contraseña';
            $data['page_title'] = 'Recuperar contraseña';
            $data['page_functions_js'] = "functions_reset_password.js";
            $this->views->getView($this,"ResetPassword",$data);
        }
    }
?>