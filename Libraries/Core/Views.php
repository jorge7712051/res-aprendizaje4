<?php
    class Views{
        function getView($controller, $view, $data=""){
            $strcontroller = get_class($controller);
            if($strcontroller == "Home"){
                $view = VIEWS.$view.".php";
            }else{
                $view = VIEWS.$strcontroller."/".$view.".php";
            }
            require_once($view);
        }
    }
?>