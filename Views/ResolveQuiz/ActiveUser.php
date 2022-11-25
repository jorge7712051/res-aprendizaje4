<?php pageHeader($data);?>


<div class="row justify-content-center" id="card-content-page">
  <div class="col-4">
    <div class="card text-center">
      <img src="<?= media(); ?>/images/uploads/logo_ud_sin_texto.png" class="card-img-top img-quiz">
      <div class="card-body">
        <h5 class="card-title">Activacion de Usuario</h5>
        <p class="card-text">Muchas gracias su usuario ha sido<strong> ¡activado! </strong>  </p>
        <a href="<?= baseUrl(); ?>LoginQuiz" class="btn bd-yellow-300">Iniciar sesion</a>
      </div>
    </div>
  </div>
</div>



<?php footer($data);?>