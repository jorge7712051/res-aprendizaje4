<?php pageHeaderLogin($data);?>
<?php getModal('AddQuizModal', $data);?>
<?php getModal('UpdateQuizModal', $data);?>

<div class="row justify-content-center" id="card-content-page">
  <div class="col-lg-10 col-md-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row  justify-content-between">
              <h3><?= $data['page_title'];?></h3>
          <button class="btn btn-success" type="button" onclick="addQuizModal()"><i class="fas fa-plus-circle"></i> Agregar</button>
      </div>
      <div class="card-body row justify-content-center" id="card-body-page">
            <div class="col-11">
              <div class="tile">
                <div class="tile-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-centered table-bordered mb-0" id="assignQuizTable" style="width:100%">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Nombre Encuesta</th>
                          <th>Activa</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
  </div>
</div>


<?php footer($data);?>