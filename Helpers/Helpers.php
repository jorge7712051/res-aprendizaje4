<?php
    
    function baseUrl(){
        return BASE_URL;
    }

    function media(){
        return BASE_URL."Assets";
    }

    function dep($data)
    {
        $format  = print_r('<pre>');
        $format .= print_r($data);
        $format .= print_r('</pre>');
        return $format;
    }

    function pageHeader($data=""){
        
        $viewHeader = "Views/Template/Header.php";
        require_once($viewHeader);
    }

    function pageHeaderLogin($data=""){
        $viewHeader = "Views/Template/HeaderLogin.php";
        require_once($viewHeader);
    }

    function pageHeaderQuiz($data=""){
        $viewHeader = "Views/Template/HeaderQuiz.php";
        require_once($viewHeader);
    }

    function footer($data=""){
        $viewFooter = "Views/Template/Footer.php";
        require_once($viewFooter);
    }

    function searchbar($data=""){
        $viewSearchbar = "Views/Template/SearchBar.php";
        require_once($viewSearchbar);
    }

    function getModal(string $nameModal, $data){
        $viewModal = "Views/Template/Modals/{$nameModal}.php";
        require_once($viewModal);
    }

    function strClean($strChain){
        $string = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''], $strChain);
        $string = trim($string);
        $string = stripslashes($string);
        $string = str_ireplace("<script>","",$string);
        $string = str_ireplace("</script>","",$string);
        $string = str_ireplace("<script src>","",$string);
        $string = str_ireplace("<script type=>","",$string);
        $string = str_ireplace("SELECT * FROM","",$string);
        $string = str_ireplace("DELETE FROM","",$string);
        $string = str_ireplace("INSERT INTO","",$string);
        $string = str_ireplace("SELECT COUNT(*) FROM","",$string);
        $string = str_ireplace("DROP TABLE","",$string);
        $string = str_ireplace("OR '1'='1","",$string);
        $string = str_ireplace('OR "1"="1"',"",$string);
        $string = str_ireplace('OR ´1´=´1´',"",$string);
        $string = str_ireplace("IS NULL; --","",$string);
        $string = str_ireplace("LIKE '","",$string);
        $string = str_ireplace('LIKE "',"",$string);
        $string = str_ireplace("LIKE ´","",$string);
        $string = str_ireplace("OR 'a'='a","",$string);
        $string = str_ireplace('OR "a"="a',"",$string);
        $string = str_ireplace("OR ´a´=´a","",$string);
        $string = str_ireplace("--","",$string);
        $string = str_ireplace("^","",$string);
        $string = str_ireplace("[","",$string);
        $string = str_ireplace("]","",$string);
        $string = str_ireplace("==","",$string);
        return $string;
    }
?>
    
    