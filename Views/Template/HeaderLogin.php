<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $data['page_tag']; ?></title>
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/@jarstone/dselect/dist/css/dselect.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<body class="d-flex flex-column min-vh-100" OnLoad="noBack();">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= baseUrl(); ?>"><img src="<?= media(); ?>/images/uploads/logo_ud.png" alt="Logo" style="height: 60px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <form name="ELR" id="ELR" action="<?= baseUrl() ?>EditLearningResult" method="post">
                            <input type="hidden" id="txtUser" name="txtUser" class="form-control" value="<?= $data['user'] ?>" />
                            <input type="hidden" id="txtPassword" name="txtPassword" class="form-control" value="<?= $data['pass'] ?>" />
                            <button id="menuBtns" class="btn btn-link" aria-current="page" type="submit">Resultados de aprendizaje</button>
                        </form>
                    </li>
                    <li class="nav-item">
                        <form name="EALR" id="EALR" action="<?= baseUrl() ?>EditAssignLearningResult" method="post">
                            <input type="hidden" id="txtUser" name="txtUser" class="form-control" value="<?= $data['user'] ?>" />
                            <input type="hidden" id="txtPassword" name="txtPassword" class="form-control" value="<?= $data['pass'] ?>" />
                            <button id="menuBtns" class="btn btn-link" aria-current="page" type="submit">Asignación de resultados de aprendizaje</button>
                        </form>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Administracion Encuesta Egresados
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <form name="EALR" id="EALR" action="<?= baseUrl() ?>ManagementQuiz/viewQuiz" method="post">
                                    <input type="hidden" id="txtUser" name="txtUser" class="form-control" value="<?= $data['user'] ?>" />
                                    <input type="hidden" id="txtPassword" name="txtPassword" class="form-control" value="<?= $data['pass'] ?>" />
                                    <button class="dropdown-item" id="menuBtns" class="btn btn-link" aria-current="page" type="submit">Creación de encuestas egresados</button>
                                </form>
                            </li>
                            <li>
                                <form name="EALR" id="EALR" action="<?= baseUrl() ?>ManagementQuestion/viewQuestion" method="post">
                                    <input type="hidden" id="txtUser" name="txtUser" class="form-control" value="<?= $data['user'] ?>" />
                                    <input type="hidden" id="txtPassword" name="txtPassword" class="form-control" value="<?= $data['pass'] ?>" />
                                    <button class="dropdown-item" id="menuBtns" class="btn btn-link" aria-current="page" type="submit">Creación de preguntas de encuestas</button>
                                </form>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= baseUrl(); ?>Logout">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <content>