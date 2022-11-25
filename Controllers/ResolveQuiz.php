<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once dirname(__FILE__, 2) . '/vendor/autoload.php';
require_once dirname(__FILE__, 2) . '/Models/UserQuizModel.php';
require_once   'LoginQuiz.php';

class ResolveQuiz extends Controllers
{

    public function __construct()
    {
        parent::__construct();
        $obj = new LoginQuiz();
        if (isset($_GET['code'])) {
            if (isset($_GET['state'])) {
                $obj->loginFacebook();
            } else {
                $obj->loginGoogle();
            }
        }
    }

    public function ResolveQuiz()
    {
        $UserQuiz = new UserQuizModel();
        if (isset($_SESSION['access_token'])) {

            $charaters = array("(", ")");
            $email = str_replace($charaters, "", $_SESSION["userEmail"]);
            $userData = array($_SESSION["userName"],  $email, $_SESSION["userPassword"], true);
            $UserQuiz->createUser($userData);
            $resolve = $UserQuiz->searchUserQuiz();

            $data['page_tag'] = "Responder encuesta";
            $data['page_title'] = "Responder encuesta";
            $data['page_functions_js'] = "functions_save_quiz.js";
            if (count($resolve) > 0) {
                $this->views->getView($this, "ResolveQuiz", $data);
            } else {
                $data['form'] = $this->mapQuestion();
                $this->views->getView($this, "NotResolveQuiz", $data);
            }
        } else {

            if (isset($_POST['email']) && $_POST['email']) {
                $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
            } else {
                echo "<script> alert('Acceso denegado');
                window.location= '" . baseUrl() . "LoginQuiz'
                </script>";
            }

            $token = $_POST['token'];
            $action = $_POST['action'];
            // validacion captcha
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => RECAPTCHA_V3_SECRET_KEY, 'response' => $token)));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $arrResponse = json_decode($response, true);

            if ($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5) {
                $result = $UserQuiz->loginUser(strClean($_POST['email']), strClean($_POST['password']));

                if ($result) {
                    $resolve = $UserQuiz->searchUserQuiz();
                    $data['page_tag'] = "Responder encuesta";
                    $data['page_title'] = "Responder encuesta";
                    $data['page_functions_js'] = "functions_save_quiz.js";

                    if (count($resolve) > 0) {
                        $this->views->getView($this, "ResolveQuiz", $data);
                    } else {
                        $data['form'] = $this->mapQuestion();
                        $this->views->getView($this, "NotResolveQuiz", $data);
                    }
                } else {
                    echo "<script> alert('Credenciales incorrectas');
                    window.location= '" . baseUrl() . "LoginQuiz'
                    </script>";
                }
            } else {
                echo "<script> alert('Error en el captcha');
                window.location= '" . baseUrl() . "LoginQuiz'
                </script>";
            }
        }
    }



    public function createUser()
    {
        $UserQuiz = new UserQuizModel();
        if ($_POST["userEmail"] == "" || $_POST["userPassword"] == "" ||  $_POST["userPassword2"] == "") {

            $arrResponse = array('status' => false, 'msg' => 'Existen campos sin llenar');
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            return;
        }
        if ($_POST["userPassword"] != $_POST["userPassword2"]) {
            $arrResponse = array('status' => false, 'msg' => 'Las contraseñas no coinciden');
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

            return;
        }

        $respuesta['userName'] = strClean($_POST["userEmail"]);
        $respuesta['userEmail'] = strClean($_POST["userEmail"]);
        $respuesta['userPassword'] = password_hash($_POST["userPassword"], PASSWORD_DEFAULT);

        $userData = array($respuesta['userName'],  $respuesta['userEmail'], $respuesta['userPassword'], true);

        $UserQuiz->createUser($userData);
        if ($_SESSION['validate']) {

            $arrResponse = array('status' => false, 'msg' => 'El correo electronico ya existe');
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }

        $this->sendMail($respuesta['userEmail']);

        $arrResponse = array('status' => true, 'msg' => 'Usuario creado. Se ha enviado un correo electronico para que se confirme la cuenta');
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }

    function ActiveUser()
    {

        if (isset($_GET["token"])) {
            $UserQuiz = new UserQuizModel();
            $UserQuiz->updateUser(strClean($_GET["token"]));
            $data['page_tag'] = "Responder encuesta";
            $data['page_title'] = "Responder encuesta";
            $data['page_functions_js'] = "functions_assign_quiz.js";
            $this->views->getView($this, "ActiveUser", $data);
        }
    }

    function sendMail($destination)
    {
        $id = base64_encode($_SESSION['iduser']);
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'jorge7712051@gmail.com';                     //SMTP username
            $mail->Password   = 'xymdrxmsoruyznsv';                               //SMTP password
            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('jlcorream@correo.udistrital.edu.co', 'Universidad Distrital Francisco Jose de Caldas');
            $mail->addAddress($destination, 'Joe User');     //Add a recipient




            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Activacion usuario plataforma encuestas';
            $mail->Body    = '<p>Por favor confirme su usuario siguiendo el siguiente enlace 
            <a href="' . baseUrl() . "ResolveQuiz/ActiveUser?token=" . $id . '" > Activar Usuario</a></p>';


            $mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    function mapQuestion()
    {
        $html = '';

        foreach ($this->model->getQuestions() as $value) {

            $html .= $this->CreateInput($value);




            if ($value['type'] == 'checkbox') {
            }

            if ($value['type'] == 'select') {
            }
        }
        return $html;
    }

    function mapDomain($id, $type, $required = false)
    {
        $html = '';

        foreach ($this->model->getDomain() as $value) {
            if ($value['idQuestion'] == $id) {
                if ($type == 'checkbox') {
                    if ($required) {
                        $html .= '<div class="form-check form-check-inline">
                        <input  class="form-check-input" data-required="true" id="' . $id . '" type="checkbox" value="' . $value['domain'] . '" />
                        <label class="form-check-label">' . $value['domain'] . '</label>
                        </div>';
                    } else {
                        $html .= '  <div class="form-check form-check-inline">
                        <input class="form-check-input" data-required="false" id="' . $id . '" type="checkbox" value="' . $value['domain'] . '" />
                        <label class="form-check-label">' . $value['domain'] . '</label>
                        </div>';
                    }
                }
                if ($type == 'radio') {
                    if ($required) {
                        $html .= '<div class="form-check form-check-inline">
                        <input  class="form-check-input" data-required="true" name="' . $id . '"  id="' . $id . '" type="radio" value="' . $value['domain'] . '" />
                        <label class="form-check-label">' . $value['domain'] . '</label>
                        </div>';
                    } else {
                        $html .= '  <div class="form-check form-check-inline">
                        <input class="form-check-input" data-required="false" id="' . $id . '" name="' . $id . '" type="radio" value="' . $value['domain'] . '" />
                        <label class="form-check-label">' . $value['domain'] . '</label>
                        </div>';
                    }
                }
                if ($type == 'select') {
                    $html .= '<option value="' . $value['domain'] . '">' . $value['domain'] . '</option>';
                }
            }
        }



        return $html;
    }

    public function CreateInput($value)
    {
        $html = '';
        switch ($value['type']) {
            case 'text':
                $html .= '<div class="mb-3"><label class="col-form-label" for="' . $value["id"] . '"><i class="' . $value["icon"] . '"></i> ' . $value["question"] . '</label>';

                $required = ($value["required"]) ? '<input id="' . $value["id"] . '" data-required="true" type="text" class="validate form-control" required><small class="form-text text-muted" data-error="Campo requerido" data-success="respuesta guardada">Pregunta Obligatoria <span style="color:red;">*</span></small>' : '<input id="' . $value["id"] . '" type="text" data-required="false" class="validate form-control">';

                $html .=  $required . '</div>';
                break;

            case 'number':
                $html .= '<div class="mb-3"><label class="col-form-label" for="' . $value["id"] . '"><i class="' . $value["icon"] . '"></i> ' . $value["question"] . '</label>';


                $required = ($value["required"]) ? '<input id="' . $value["id"] . '" data-required="true" type="number" class="validate form-control" required><small class="form-text text-muted" data-error="Campo requerido" data-success="respuesta guardada">Pregunta Obligatoria <span style="color:red;">*</span></small>' : '<input id="' . $value["id"] . '" type="number" data-required="false" class="validate form-control">';

                $html .=  $required . '</div>';
                break;

            case 'email':
                $html .= '<div class="mb-3"><label class="col-form-label" for="' . $value["id"] . '"><i class="' . $value["icon"] . '"></i> ' . $value["question"] . '</label>';


                $required = ($value["required"]) ? '<input id="' . $value["id"] . '" data-required="true" type="email" class="validate form-control" required><small class="form-text text-muted" data-error="Campo requerido" data-success="respuesta guardada">Pregunta Obligatoria <span style="color:red;">*</span></small>' : '<input id="' . $value["id"] . '" type="number" data-required="false" class="validate form-control">';

                $html .=  $required . '</div>';
                break;

            case 'textarea':
                $html .= '<div class="mb-3"><label class="col-form-label" for="' . $value["id"] . '"><i class="' . $value["icon"] . '"></i> ' . $value["question"] . '</label>';

                $required = ($value["required"]) ? '<textarea rows="3" id="' . $value["id"] . '" data-required="true" class="validate form-control" required></textarea><small class="form-text text-muted" data-error="Campo requerido" data-success="respuesta guardada">Pregunta Obligatoria <span style="color:red;">*</span></small>' : '<textarea rows="3" id="' . $value["id"] . '"  data-required="false" class="validate form-control"></textarea>';

                $html .=  $required . '</div>';
                break;

            case 'checkbox':
                $html .= '<div class="mb-3"><div><label class="form-check-label" for="' . $value["id"] . '"><i class="' . $value["icon"] . '"></i> ' . $value["question"] . '</label></div> ';
                if ($value["required"]) {
                    $resp = $this->mapDomain($value["id"], 'checkbox', true);
                    $required =  '<div><small class="form-text text-muted" data-error="Campo requerido" data-success="respuesta guardada">Pregunta Obligatoria <span style="color:red;">*</span></small></div>';
                } else {
                    $resp = $this->mapDomain($value["id"], 'checkbox');
                    $required =  '';
                }

                $html .= $resp . $required . '</div>';
                break;

            case 'radio':
                $html .= '<div class="mb-3"><div><label class="form-check-label" for="' . $value["id"] . '"><i class="' . $value["icon"] . '"></i> ' . $value["question"] . '</label></div> ';
                if ($value["required"]) {
                    $resp = $this->mapDomain($value["id"], 'radio', true);
                    $required =  '<div><small class="form-text text-muted" data-error="Campo requerido" data-success="respuesta guardada">Pregunta Obligatoria <span style="color:red;">*</span></small></div>';
                } else {
                    $resp = $this->mapDomain($value["id"], 'radio');
                    $required =  '';
                }

                $html .= $resp . $required . '</div>';
                break;

            case 'select':
                $html .= '<div class="mb-3"><label class="col-form-label" for="' . $value["id"] . '"><i class="' . $value["icon"] . '"></i> ' . $value["question"] . '</label>';
                $resp = $this->mapDomain($value["id"], 'select');

                if ($value["required"]) {
                    $html .= '<select data-required="true" required class="form-control" id="' . $value["id"] . '">
                            <option value="" disabled selected>Seleccione un opcion</option>';
                    $html .= $resp;
                    $html .= ' </select><small class="form-text text-muted" data-error="Campo requerido" data-success="respuesta guardada">Pregunta Obligatoria <span style="color:red;">*</span></small></div>';
                } else {
                    $html .= '<select data-required="false" class="form-control">
                            <option value="" disabled selected>Seleccione un opcion</option>';
                    $html .= $resp;
                    $html .= ' </select></div>';
                }
                break;

            default:
                # code...
                break;
        }

        return $html;
    }

    function saveQuiz(){

        if (isset($_SESSION['access_token'])) {

            if (isset($_POST["response"])) {
                $this->model->save($_POST["response"]);
                echo true;
            }

        }

        
    }
}
