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

    public function ChangePasword()
    {
        $UserQuiz = new UserQuizModel();

        if (isset($_POST["data"])) {
            $data = base64_decode($_POST["data"]);
            $data = explode("&",$data);
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

                $password = password_hash($_POST["newpassword"], PASSWORD_DEFAULT);
                $result = $UserQuiz->updatePassword($password, $data[0]);

                echo "<script> alert('Actualizacion realizada');
                window.location= '" . baseUrl() . "LoginQuiz'
                </script>";
                
            } else {
                echo "<script> alert('Error en el captcha');
                window.location= '" . baseUrl() . "LoginQuiz'
                </script>";
            }
        } else {
            echo "<script> alert('Acceso denegado');
                window.location= '" . baseUrl() . "LoginQuiz'
                </script>";
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

        $arrResponse = array('status' => true, 'msg' => 'Usuario creado. Se ha enviado un correo electronico para que se confirme la cuenta', 'title' => 'Usuario Creado');
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }

    public function resetPassword()
    {
        $UserQuiz = new UserQuizModel();
        if ($_POST["resetEmail"] == "") {

            $arrResponse = array('status' => false, 'msg' => 'Existen campos sin llenar');
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            return;
        }


        $userEmail = strClean($_POST["resetEmail"]);
        $respuesta = $UserQuiz->searchQuizByEmail($userEmail);
        if (is_array($respuesta)) {
            if (count($respuesta) > 0) {
                $this->sendMailResetPassword($respuesta);
            }
        }


        $arrResponse = array('status' => true, 'msg' => 'Se ha enviado un correo con las instrucciones para recuperar su clave de acceso', 'title' => 'Recuperacion de Contraseña');
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }

    function ActiveUser()
    {

        if (isset($_GET["token"])) {
            $UserQuiz = new UserQuizModel();
            $response = $UserQuiz->updateUser(strClean($_GET["token"]));
            if ($response) {
                $data['page_tag'] = "Responder encuesta";
                $data['page_title'] = "Responder encuesta";
                $data['page_functions_js'] = "functions_assign_quiz.js";
                $this->views->getView($this, "ActiveUser", $data);
            } else {
                echo "<script> window.location= '" . baseUrl() . "LoginQuiz'
            </script>";
            }
        } else {
            echo "<script> window.location= '" . baseUrl() . "LoginQuiz'
            </script>";
        }
    }


    function sendMail($destination)
    {
        $id = base64_encode($_SESSION['iduser']);
        $mail = new PHPMailer(true);

        try {
           
            $mail->isSMTP();                                            
            $mail->Host       = SMTP_SERVER;              
            $mail->SMTPAuth   = true;                
            $mail->Username   = USER_MAIL;                  
            $mail->Password   = USER_TOKEN;             
            $mail->Port       = PORT;               

            //Recipients
            $mail->setFrom('jlcorream@correo.udistrital.edu.co', 'Universidad Distrital Francisco Jose de Caldas');
            $mail->addAddress($destination, 'Universidad Distrital Francisco Jose de Caldas');     

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Activacion usuario plataforma encuestas';
            $mail->Body    = '<p>Por favor confirme y active su usuario a travez del siguiente boton </p></br>
            <a style="border: 1px solid lightgray;
            text-decoration: none;
            padding: 10px;
            color: black;
            background: linear-gradient(to right, rgba(255,255,255,1) 2%, rgba(255,218,106,1) 35%, rgba(253,122,67,1) 100%);" 
            href="' . baseUrl() . "ResolveQuiz/ActiveUser?token=" . $id . '" > Activar Usuario</a>
            <p></p>';


            $mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    function sendMailResetPassword($destination)
    {
        $date = date('d-m-y H:i:s');
        $id = base64_encode($destination['id'] . "&" . $destination['userEmail'] . "&" . $date);
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();                                            
            $mail->Host       = SMTP_SERVER;              
            $mail->SMTPAuth   = true;                
            $mail->Username   = USER_MAIL;                  
            $mail->Password   = USER_TOKEN;             
            $mail->Port       = PORT;               
            $mail->CharSet = 'UTF-8';
            //Recipients
            $mail->setFrom('jlcorream@correo.udistrital.edu.co', 'Universidad Distrital Francisco Jose de Caldas');
            $mail->addAddress($destination['userEmail'], 'Universidad Distrital Francisco Jose de Caldas');     //Add a recipient




            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Solicitud recuperacion de clave de ingreso';
            $body  = '<p>Para restablecer su contraseña por favor ingrese en el siguiente enlace, el cual sera valido solo por 2 horas. </p></br>
            <a style="border: 1px solid lightgray;
            text-decoration: none;
            padding: 10px;
            background-color: #88A7EA;
            color: black;
            background: linear-gradient(to right, rgba(255,255,255,1) 2%, rgba(255,218,106,1) 35%, rgba(253,122,67,1) 100%);" 
            href="' . baseUrl() . "LoginQuiz/NewPassword?token=" . $id . '" >Recuperacion de clave</a>
            <p></p>
            <p></p>
            <p></p>
            <h3>Cordialmente,</h3><p></p>';
            $firma = '<table style="border:none;border-collapse:collapse">
            <colgroup><col width="127"><col width="350"></colgroup>
            <tbody>
            <tr style="height:156.75pt">
            <td style="border-left:solid #ffffff 1pt;border-right:solid #cccccc 1pt;border-bottom:solid #ffffff 1pt;border-top:solid #ffffff 1pt;vertical-align:top;padding:5pt 5pt 5pt 5pt;overflow:hidden">
            <span style="border:none;display:inline-block;overflow:hidden;width:110px;height:149px"><img style="margin-top:0px" width="110" height="149" src="https://lh3.googleusercontent.com/GUiSHBzF_hM2rmOsck99DYTeGMZSPmi3YzKQZ9nZWkUK9f_JqcRicJmSP200KVv8CYmXOAP6u12Z4PIdyNkzsJT47whrE_OX-aMSLRu1yaxYCu_gfnl0zT_XcdJccXgL8utI3Lbr" class="CToWUd" data-bit="iit"></span></td>
            <td style="border-left:solid #cccccc 1pt;border-right:solid #ffffff 1pt;border-bottom:solid #ffffff 1pt;border-top:solid #ffffff 1pt;vertical-align:top;padding:5pt 5pt 5pt 5pt;overflow:hidden">
           
            <p dir="ltr" style="line-height:1.2;margin-top:0pt;margin-bottom:0pt"><span style="font-size:9pt;font-family:Calibri,sans-serif;color:#000000;font-weight:700">Tecnología en Sistematización de Datos</span><span style="font-size:9pt;font-family:Calibri,sans-serif;color:#000000">,
             SNIES 8675</span></p>
            <p dir="ltr" style="line-height:1.2;margin-top:0pt;margin-bottom:0pt"><span style="font-size:9pt;font-family:Calibri,sans-serif;color:#000000">Registro Calificado Resolución M.E.N. 4270 de 25 de abril de 2019.</span></p>
            <p dir="ltr" style="line-height:1.2;margin-top:0pt;margin-bottom:0pt"><span style="font-size:9pt;font-family:Calibri,sans-serif;color:#000000;font-weight:700">Web Page</span><span style="font-size:9pt;font-family:Calibri,sans-serif;color:#000000">:
            </span><a href="http://tecsistematizaciondatos.udistrital.edu.co:8080/" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://tecsistematizaciondatos.udistrital.edu.co:8080/&amp;source=gmail&amp;ust=1681072119763000&amp;usg=AOvVaw2SsCymzvJsEvWP9MxmL6TE"><span style="font-size:9pt;font-family:Calibri,sans-serif;color:#1155cc;text-decoration:underline">http://<wbr>tecsistematizaciondatos.<wbr>udistrital.edu.co:8080/</span></a></p>
            <p dir="ltr" style="line-height:1.2;margin-top:0pt;margin-bottom:0pt"><span style="font-size:9pt;font-family:Calibri,sans-serif;color:#000000">Ingeniería en Telemática, SNIES 9766</span></p>
            <p dir="ltr" style="line-height:1.2;margin-top:0pt;margin-bottom:0pt"><span style="font-size:9pt;font-family:Calibri,sans-serif;color:#000000">Registro Calificado Resolución M.E.N. 2733 de 18 de marzo de 2019.</span></p>
            <p dir="ltr" style="line-height:1.2;margin-top:0pt;margin-bottom:0pt"><span style="font-size:9pt;font-family:Calibri,sans-serif;color:#000000;font-weight:700">Web Page</span><span style="font-size:9pt;font-family:Calibri,sans-serif;color:#000000">:
            </span><a href="http://ingtelematica.udistrital.edu.co:8080/" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://ingtelematica.udistrital.edu.co:8080/&amp;source=gmail&amp;ust=1681072119763000&amp;usg=AOvVaw0NH2J9apMIWZahBw4L6xed"><span style="font-size:9pt;font-family:Calibri,sans-serif;color:#1155cc;text-decoration:underline">http://ingtelematica.<wbr>udistrital.edu.co:8080/</span></a></p>
            <p dir="ltr" style="line-height:1.2;margin-top:0pt;margin-bottom:0pt"><span style="font-size:9pt;font-family:Calibri,sans-serif;color:#000000;font-weight:700">PBX</span><span style="font-size:9pt;font-family:Calibri,sans-serif;color:#000000">: 3239300, Ext.
             5008 - 5009</span></p>
            <p dir="ltr" style="line-height:1.2;margin-top:0pt;margin-bottom:0pt"><span style="font-size:9pt;font-family:Calibri,sans-serif;color:#000000">Calle 68 D Bis A Sur No 49 F 70 Piso 2 Bloque 6 Bogotá D. C.</span></p>
            <p dir="ltr" style="line-height:1.2;margin-top:0pt;margin-bottom:0pt"><a href="http://www.facebook.com/Tecnolog%C3%ADa-en-Sistematizaci%C3%B3n-de-Datos-104393158544354" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://www.facebook.com/Tecnolog%25C3%25ADa-en-Sistematizaci%25C3%25B3n-de-Datos-104393158544354&amp;source=gmail&amp;ust=1681072119763000&amp;usg=AOvVaw2SIKAQ_dCMeXqc_vrMoGTU"><span style="font-size:11pt;font-family:Arial;color:#1155cc;text-decoration:underline"><span style="border:none;display:inline-block;overflow:hidden;width:37px;height:42px"><img style="margin-top:0px" width="37" height="42" src="https://lh5.googleusercontent.com/Vrw4txW7WJNogsBHgl6nNUPSIzsmifxSqU44J5j7ZZ2VTJCEivPC8YvO2aQqrtJb0d_R9osctqQhuYHhzVEqyA-cjqvU3jQjCZ1fRL3061nChDaV2DQmQ2y6ZGHpztc8SmrajNli" class="CToWUd" data-bit="iit"></span></span></a><span style="font-size:11pt;font-family:Arial;color:#000000">&nbsp;
            </span><a href="http://www.facebook.com/Ingenier%C3%ADa-Telem%C3%A1tica-101855005469854" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://www.facebook.com/Ingenier%25C3%25ADa-Telem%25C3%25A1tica-101855005469854&amp;source=gmail&amp;ust=1681072119763000&amp;usg=AOvVaw05GqJQkv2UJK-IyitwLGQo"><span style="font-size:11pt;font-family:Arial;color:#1155cc;text-decoration:underline"><span style="border:none;display:inline-block;overflow:hidden;width:37px;height:43px"><img style="margin-top:0px" width="37" height="43" src="https://lh6.googleusercontent.com/yZvQ7o82XC-Udpsfa4sn4M7A5AH4QU9syP1EHzjtJPLpgaNU3QcirZ5bnAZFoSbG0dbvn1cbQqYqPHBl0gZsV5krASArbeZcOK-U97roy47jEUZ_U537BzYnVt8n-gftOUR-lsJq" class="CToWUd" data-bit="iit"></span></span></a><span style="font-size:11pt;font-family:Arial;color:#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></p>
            </td>
            </tr>
            </tbody>
            </table>';
            $mail->Body= $body.$firma;

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

    function saveQuiz()
    {

        if (isset($_SESSION['access_token'])) {

            if (isset($_POST["response"])) {
                $this->model->save($_POST["response"]);
                echo true;
            }
        }
    }
}
