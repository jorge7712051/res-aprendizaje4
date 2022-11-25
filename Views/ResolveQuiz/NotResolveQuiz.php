<?php pageHeaderQuiz($data); ?>


<div class="row justify-content-center" id="card-content-page">
  <div class="col-lg-8 col-md-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row  justify-content-between">
        <h3><?= $data['page_title']; ?></h3>       
      </div>
      <div class="card-body row justify-content-center" id="card-body-page">
        <form class="col l12 formQuiz purple lighten-5 formQuiz "   style="width:100%;">
          <?= $data['form']; ?>

          <button type="submit" id="btnRegister" class="btn btn-block gradient-custom-2 mb-3">Guardar Respuestas</button>
        </form>
      </div>
    </div>
  </div>
</div>


<?php footer($data); ?>