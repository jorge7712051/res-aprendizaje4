<?php
    class Logout{
        public function __construct(){
            session_start();
            session_unset();
            session_destroy();
            echo "<script>window.location.href='".baseUrl()."'</script>";
        }
    }
?>