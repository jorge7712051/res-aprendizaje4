<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Laura Ahumada - Santiago Leon" content="Abel OSH">
    <meta name="theme-color" content="#009688">
    <link rel="shortcut icon" href="<?= media();?>/images/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/style.css">
    
    <title><?= $data['page_tag']; ?></title>
  </head>
  <body>

  <section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-10">
            <div class="card rounded-3 text-black">
            <div class="row g-0">
                <div class="col-lg-6">
                <div class="card-body p-md-5 mx-md-4">

                    <div class="text-center">
                    <img src="<?= media();?>/images/uploads/logo_ud_sin_texto.png"
                        style="width: 50px;" alt="logo">
                    <h4 class="mt-1 mb-5 pb-1"><?= $data['page_title']; ?></h4>
                    </div>

                    <form name="formLogin" id="formLogin" action="<?= baseUrl() ?>EditLearningResult" method="post">
                        <div class="form-outline mb-4">
                            <input type="text" id="txtUser" name="txtUser" class="form-control"
                            placeholder="Usuario" />
                            <br>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="password" id="txtPassword" name="txtPassword" class="form-control" 
                            placeholder="Contraseña"/>
                            <br>
                        </div>

                        <div class="text-center pt-1 mb-5 pb-1">
                            <button class="btn btn-block gradient-custom-2 mb-3" type="submit" id="ButtonLogin">Ingresar</button>
                            <a class="text-muted" href="<?= baseUrl(); ?>ResetPassword">¿Olvidaste tu contraseña?</a>
                        </div>
                    </form>

                </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                <div class="px-3 py-4 p-md-5 mx-md-4">
                <h3 class="mb-4">Sistema de Gestión de Resultados de Aprendizaje</h3>
                    <p class="small mb-0">Mediante este sistema los docentes del proyecto curricular de Tecnología en 
                        Sistematización de Datos e Ingeniería en Telemática 
                        podrán adicionar, actualizar y/o eliminar los resultados de aprendizaje que esperan de sus 
                        asignaturas, así como la respectiva asignación a cada una de ellas</p>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    <script>
        const baseUrl = "<?= baseUrl(); ?>";
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