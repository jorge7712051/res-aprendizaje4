<?php pageHeaderQuiz($data); ?>


<div class="row justify-content-center" id="card-content-page">
  <div class="col-4">
    <div class="card text-center">
      <img src="<?= media(); ?>/images/uploads/logo_ud_sin_texto.png" class="card-img-top img-quiz">
      <div class="card-body">
        <h5 class="card-title">Encuesta enviada</h5>
        <p class="card-text">Muchas gracias por responder nuestra encuesta. Todas sus respuestas fueron guardadas con <strong> ¡éxito! </strong>  </p>
        <a href="<?= baseUrl(); ?>Logout" class="btn bd-yellow-300">Cerrar Sesión</a>
      </div>
    </div>
  </div>
</div>


  <?php footer($data); ?>