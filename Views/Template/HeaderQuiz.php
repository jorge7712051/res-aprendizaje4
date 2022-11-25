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
            <a class="navbar-brand" href="<?= baseUrl(); ?>"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div >
                <ul class="nav justify-content-end">
                    <li class="nav-item">
                   
                    </li>
                    <li class="nav-item" >
                        <a id="menuBtns" class="nav-link" href=""> <img src="<?= $_SESSION['photo']; ?>"  style="height: 40px;" class="rounded-circle"> <?=  $_SESSION["userName"] ." ". $_SESSION["userEmail"] ?></a>
                    </li>
                  
                    <li class="nav-item">
                        <a  id="menuBtns" class="nav-link" href="<?= baseUrl(); ?>Logout" style="margin-top: 6px;">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <content>