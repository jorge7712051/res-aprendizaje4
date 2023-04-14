<?php
session_start();
class ManagementQuestion extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function viewQuestion()
    {
        if (isset($_SESSION['user'])) {

            $data['page_tag'] = "Administración preguntas egresados";
            $data['page_title'] = "Administración preguntas egresados";
            $data['page_functions_js'] = "functions_assign_question.js";
            $data['user'] = $_SESSION['user'];
            $data['pass'] = $_SESSION['pass'];
            $this->views->getView($this, "ManagementQuestion", $data);
        } else {
            echo "<script>window.location.href='" . baseUrl() . "Login'</script>";
        }
    }

    public function viewAnswer()
    {
        if (isset($_SESSION['user'])) {
            if(isset($_GET['id'])){
                $resultado = $this->model->getAnswer($_GET['id']);
        
                $filename = "answers_".date('Ymd') . ".xls";	
          
                header( "Content-type: application/vnd.ms-excel; charset=utf-8" );
                header('Content-Transfer-Encoding: binary');
                header("Content-Disposition: attachment; filename=\"$filename\"");


                    $mostrar_columnas = false;

                    foreach ($resultado as $libro) {
                    if (!$mostrar_columnas) {
                        echo implode("\t", array_keys($libro)) . "\n";
                        $mostrar_columnas = true;
                    }
                    echo utf8_decode(implode("\t", array_values($libro)))  . "\n";
            }
            }
            
        } else {
            echo "<script>window.location.href='" . baseUrl() . "Login'</script>";
        }
    }

    public function headerTable()
    {
        $results = $this->model->getQuestion();

        $html = "";
        foreach ($results as $result) {
            $html .= "<th>" . $result['question'] . "</th>";
        }
        return $html;
    }

    public function bodyTable()
    {
        $questions = $this->model->getQuestion();
        $answers = $this->model->getAnswer();
        $total = count($questions);
        $tmp = 0;
        $userTmp = 0;
        $i = 0;
        $response = array();
        for ($i = 0; $i <  $total; $i++) {
            for ($j = 0; $j < count($answers); $j++) {
                if ($questions[$i]["id"] == $answers[$j]["id"]) {
                    $q = $questions[$i]["question"];
                    $response[$i][$q] .= $answers[$j]["answer"] . ",";
                }
            }
        }
    }

    public function getQuestionById(int $idALR)
    {
        $id = intval(strClean($idALR));
        $domain = "";
        if ($id > 0) {
            $arrData = $this->model->searchQuestionById($idALR);
            $arrData2 = $this->model->searchDomainResultById($idALR);
            if (count($arrData2) > 0) {
                if ($arrData['type'] == "select" || $arrData['type'] == "checkbox" || $arrData['type'] == "radio") {
                    for ($j = 0; $j < count($arrData2); $j++) {
                        if ($arrData['id'] == $arrData2[$j]['idQuestion']) {
                            $domain .= $arrData2[$j]['domain'] . ", ";
                        }
                    }
                }

                $arrData['domain'] = rtrim($domain, ", ");
                $domain = "";

                $this->getByIdALRMessage($arrData);
            } else {
                $this->getByIdALRMessage($arrData);
            }
        }
        die();
    }

    public function getQuestionResult()
    {
        $arrData = $this->model->searchQuestionResult();
        $arrData2 = $this->model->searchDomainResult();
        $domain = "";
        for ($i = 0; $i < count($arrData); $i++) {
            if ($arrData[$i]['type'] == "select" || $arrData[$i]['type'] == "checkbox" || $arrData[$i]['type'] == "radio") {
                for ($j = 0; $j < count($arrData2); $j++) {
                    if ($arrData[$i]['id'] == $arrData2[$j]['idQuestion']) {
                        $domain .= $arrData2[$j]['domain'] . ", ";
                    }
                }
            } else {
                $domain = "Sin opciones";
            }
            $arrData[$i]['domain'] = rtrim($domain, ", ");
            $arrData[$i]['icon'] = '<i class="' . $arrData[$i]['icon'] . '"></i>';
            $arrData[$i]['acciones'] = '<div class="text-center">
                <button class="btn btn-outline-secondary btn-sm" id="btnEditLR" onclick="editQuestionModal(this)" title="Editar" alr="' . $arrData[$i]['id'] . '"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-outline-danger btn-sm" id="btnDeleteLR" onclick="deleteQuestion(this) "title="Eliminar" lr="' . $arrData[$i]['id'] . '"><i class="far fa-trash-alt"></i></button>
                </div>';
            $domain = "";
        };
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function postQuestion()
    {
        $domain = "";
        if ($_POST) {
            if (empty($_POST['type']) || empty($_POST['listQuiz']) || empty($_POST['questionName'])) {
                $arrResponse = array("status" => false, "msg" => "Datos incorrectos.");
            } else {
                $required = (isset($_POST['required'])) ? true : false;
                $type = strClean($_POST['type']);
                $icon = strClean($_POST['icon']);
                $questionName = strClean($_POST['questionName']);
                $listQuiz = strClean($_POST['listQuiz']);

                if ($type == "checkbox" || $type == "select" || $type == "radio") {
                    $domain = (isset($_POST['domain'])) ? strClean($_POST['domain']) : "";
                }

                if ($domain == "") {
                    $requestALR = $this->model->saveQuestionResult($required, $type, $icon, $questionName, $listQuiz);
                    $arrResponse = $this->postPutAssignLRMessage($requestALR);
                } else {
                    $domains = explode(",", $domain);
                    $requestALR = $this->model->saveQuestionResult($required, $type, $icon, $questionName, $listQuiz, $domains);
                    $arrResponse = $this->postPutAssignLRMessage($requestALR);
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function putQuestion(int $intId)
    {
        $domain = "";
        if ($_POST) {
            if (empty($_POST['editType']) || empty($_POST['editListQuiz']) || empty($_POST['editQuestionName'])) {
                $arrResponse = array("status" => false, "msg" => "Datos incorrectos.");
            } else {
                $required = (isset($_POST['editRequired'])) ? true : false;
                $arrrayUpdate = array(
                    strClean($_POST['editQuestionName']),
                    strClean($_POST['editType']),
                    $required,
                    strClean($_POST['editIcon']),
                    strClean($_POST['editListQuiz']),
                    $intId
                );

                if ($_POST['editType'] == "checkbox" || $_POST['editType'] == "select" || $_POST['editType'] == "radio") {
                    $domain = (isset($_POST['editDomain'])) ? strClean($_POST['editDomain']) : "";
                }

                if ($domain == "") {
                    $requestALR = $this->model->updateQuestion($arrrayUpdate);
                    $arrResponse = $this->postPutAssignLRMessage($requestALR);
                } else {
                    $domains = explode(",", $domain);
                    $requestALR = $this->model->updateQuestion($arrrayUpdate, $domains);
                    $arrResponse = $this->postPutAssignLRMessage($requestALR);
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }




    public function deleteQuestion($id)
    {
        $data = $this->model->deleteQuestion($id);
        $this->deleteAssignLRMessage($data);
    }

    private function getByIdALRMessage($arrData)
    {
        $arrResponse = "";
        if (empty($arrData)) {
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
        } else {
            $arrResponse = array('status' => true, 'msg' => $arrData);
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

        return $arrResponse;
    }

    private function postPutAssignLRMessage($arrData)
    {
        $arrResponse = "";
        if ($arrData > 0) {
            $arrResponse = array('status' => true, 'msg' => 'Datos procesados correctamente.');
        } else if ($arrData == 'exist') {
            $arrResponse = array('status' => false, 'msg' => '¡Advertencia! La asignación ya existe.');
        } else {
            $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
        }
        return $arrResponse;
    }

    private function deleteAssignLRMessage($arrData)
    {
        $arrResponse = "";
        if (empty($arrData)) {
            $arrResponse = array('status' => false, 'msg' => 'No es poisble eliminar los datos.');
        } else {
            $arrResponse = array('status' => true, 'msg' => 'El resultado de aprendizaje ha sido eliminado');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

        return $arrResponse;
    }
}
