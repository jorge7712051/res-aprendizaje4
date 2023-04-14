<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Laura Ahumada - Santiago Leon" content="Abel OSH">
    <meta name="theme-color" content="#009688">
    <link rel="shortcut icon" href="<?= media(); ?>/images/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/style.css">

    <script src="https://www.google.com/recaptcha/api.js?render=6LfITyAjAAAAAIhE6Leitd7I_jwQ3H6Q-GCf4S9l"></script>
    <title><?= $data['page_tag']; ?></title>
</head>

<body>

    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-12 col-sm-12">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6 col-sm-12">
                                <div class="card-body p-md-5 mx-md-4">
                                    <form name="formResetPass" class="p-2 shadow" id="formResetPass" action="<?= baseUrl() ?>ResolveQuiz/ChangePasword" method="post">
                                        <br>
                                        <div class="form-outline">

                                            <input type="password" id="newpassword" name="newpassword" class="form-control" placeholder="Nueva contraseña" autocomplete="off" required />
                                            <br>
                                        </div>

                                        <div class="form-outline">
                                            <input type="password" id="repetpassword" name="repetpassword" class="form-control" placeholder="Confirmacion de contraseña" required />
                                            <br>
                                        </div>

                                        <div class="text-center pt-1  pb-1">
                                            <button class="btn btn-block gradient-custom-2 mb-3" type="submit" id="ButtonLogin">Cambiar Contraseña</button>

                                        </div>
                                        <div class="alert alert-danger" role="alert">
                                            <h6 class="alert-heading">Tenga en cuenta que la contraseña debe tener:</h6>
                                            <ul>
                                                <li>Minimo 8 caracteres</li>
                                                <li>Maximo 15</li>
                                                <li>Al menos una letra mayúscula</li>
                                                <li>Al menos una letra minucula</li>
                                                <li>Al menos un dígito</li>
                                                <li>No espacios en blanco</li>
                                                <li>Al menos 1 caracter especial</li>
                                            </ul>

                                        </div>
                                    </form>

                                </div>

                            </div>
                            <div class="col-lg-6 col-sm-12 d-flex align-items-center gradient-custom-2">
                                <div class="px-3 py-4 p-md-5 mx-md-4 " style="text-align: justify;">
                                    <h4 class="mb-4">Politica de privacidad y tratamiento de datos</h4>
                                    <p class="small mb-0">Según la legislación colombiana, el responsable del tratamiento de tus datos en este sitio web y demás aplicaciones móviles, email, textos u otros mensajes electrónicos es la Universidad Distrital Francisco José de Caldas identificada con N.I.T. 899.999.230-7. En cumplimiento con la Ley 1581 de 2012 “Ley de protección de datos personales” y el Decreto 1377 de 2013, informamos que somos responsables de la administración de dichos datos. Según nuestras políticas de tratamiento de datos personales, los mecanismos a través de los cuales hacemos uso de éstos son seguros y confidenciales. Esto se logra mediante el uso de medios tecnológicos idóneos para asegurar que sean almacenados evitando el acceso indeseado por parte de terceras personas, y en ese mismo orden garantizamos la confidencialidad de los datos suministrados por los usuarios.</p>
                                    <p class="small mb-0"><strong>Qué datos recogemos sobre ti:</strong> Nuestro compromiso fundamental garantizar la protección de la privacidad de los datos que nos suministras a través de la página web y demás aplicaciones promueve, emails, textos, u otros mensajes electrónicos entre tú y nuestra web. Para registrarte en nuestra página web, deberás suministrar información personal la cual puede incluir datos como tu nombre completo, ocupación, email y foto de perfil lo cual se hace uso para acceder a la web. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <script>
            const base_url = "<?= baseUrl(); ?>";
        </script>
    </section>
    <!-- Essential javascripts for application to work-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js" integrity="sha512-nnzkI2u2Dy6HMnzMIkh7CPd1KX445z38XIu4jG1jGw7x5tSL3VBjE44dY4ihMU1ijAQV930SPM12cCFrB18sVw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="<?= media(); ?>/js/fontawesome.js"></script>
    <script src="<?= media(); ?>/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.2.4/pace.min.js" integrity="sha512-2cbsQGdowNDPcKuoBd2bCcsJky87Mv0LEtD/nunJUgk6MOYTgVMGihS/xCEghNf04DPhNiJ4DZw5BxDd1uyOdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/sweetalert.min.js"></script>
    <script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>
</body>

</html>