<?php
session_start();
require_once dirname(__FILE__, 2) . '/vendor/autoload.php';
require_once dirname(__FILE__, 2) . '/Models/UserQuizModel.php';

class LoginQuiz extends Controllers
{

    public function __construct()
    {
        parent::__construct();
    }

    public function LoginQuiz()
    {
        if (isset($_SESSION['access_token'])) {
            echo "<script> window.location= '".baseUrl()."ResolveQuiz/ResolveQuiz'
            </script>";

        } else {
            $loginUrl = $this->LoginFacebookUrl();
            $loginUrlGoogle = $this->LoginGoogleUrl();

            $data['page_tag'] = 'Iniciar sesión - Resultados de aprendizaje';
            $data['page_title'] = 'Iniciar sesión';
            $data['url_facebook'] =  $loginUrl;
            $data['url_google'] =  $loginUrlGoogle;
            $data['page_functions_js'] = "functions_login_quiz.js";
            $this->views->getView($this, "LoginQuiz", $data);
        }
    }

    public function LoginFacebookUrl()
    {
        $fb = new \Facebook\Facebook([
            'app_id' => ID_FACEBOOK,
            'app_secret' => SECRET_FACEBOOK,
            'default_graph_version' => GRAPH_VERSION,
        ]);
        $permissions = ['email']; // Permisos opcionales
        $helper = $fb->getRedirectLoginHelper();
        return $helper->getLoginUrl(baseUrl() . 'ResolveQuiz/ResolveQuiz/', $permissions);
    }

    public function LoginGoogleUrl()
    {
        $client = new Google\Client();
        $client->setClientId(ID_GOOGLE);
        $client->setClientSecret(SECRET_GOOGLE);
        $client->setRedirectUri(REDIRECT_URI);
        $client->addScope("email");
        $client->addScope("profile");


        $loginUrl = $client->createAuthUrl();
        return $loginUrl . '&app=google';
    }

    public function loginFacebook()
    {
        $fb = new \Facebook\Facebook([
            'app_id' => ID_FACEBOOK,
            'app_secret' => SECRET_FACEBOOK,
            'default_graph_version' => GRAPH_VERSION,
        ]);
        $helper = $fb->getRedirectLoginHelper();
        $helper->getPersistentDataHandler()->set('state', $_GET['state']);

        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            echo "<script>window.location.href='" . baseUrl() . "LoginQuiz'</script>";

            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            echo "<script>window.location.href='" . baseUrl() . "LoginQuiz'</script>";
            exit;
        }
        if (!isset($accessToken)) {
            echo "<script>window.location.href='" . baseUrl() . "LoginQuiz'</script>";
        } else {

            $this->auth2TokenFacebook($fb, (string) $accessToken);
        }
    }

    public function loginGoogle()
    {
        $client = new Google\Client();
        $client->setClientId(ID_GOOGLE);
        $client->setClientSecret(SECRET_GOOGLE);
        $client->setRedirectUri(REDIRECT_URI);
        $client->addScope("email");
        $client->addScope("profile");
        $client->createAuthUrl();

        $this->auth2TokenGoogle($client);
    }

    public function auth2TokenGoogle($client)
    {
        if (!isset($_SESSION['access_token'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token);

            $userObj = [];
            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();

            $_SESSION['access_token'] = $token;


            if (!isset($_SESSION['email'])) {

                $_SESSION['email'] = $google_account_info->email;
                $_SESSION["userName"] = $google_account_info->name;
                $_SESSION["userEmail"] = "(" . $_SESSION['email'] . ")";
                $_SESSION["userPassword"] = '';
                $_SESSION["displayName"]= $_SESSION["userName"] ." ".   $_SESSION["userEmail"] ;
            }

            if (!isset($_SESSION['photo'])) {

                $_SESSION['photo'] = $google_account_info->picture;
            }

            if (!isset($_SESSION['logueo'])) {

                $_SESSION['logueo'] = true;
            }
        }
    }



    public function auth2TokenFacebook($fb, $token)
    {
        if (!isset($_SESSION['access_token'])) {
            $userObj = [];
            $_SESSION['access_token'] = $token;
            if (!isset($_SESSION['email'])) {
                $response = $fb->get('/me?fields=name,first_name,last_name,email', $_SESSION['access_token']);
                $userInfo = $response->getGraphUser();
                $_SESSION['email'] = $userInfo['email'];
                $_SESSION["userName"] = $userInfo['name'];
                $_SESSION["userEmail"] = "(" . $userInfo['email'] . ")";
                $_SESSION["userPassword"] = '';
                $_SESSION["displayName"]= $_SESSION["userName"] ." ".  $_SESSION["userEmail"] ;
            }

            if (!isset($_SESSION['photo'])) {

                $requestPicture = $fb->get('/me/picture?redirect=false&height=200', $_SESSION['access_token']);
                $photoInfo = $requestPicture->getGraphUser();
                $_SESSION['photo'] = $photoInfo['url'];
            }

            if (!isset($_SESSION['logueo'])) {
                $_SESSION['logueo'] = true;
            }
        }

        //$user = new User;
        //$user->createUser($userObj);

    }
}
