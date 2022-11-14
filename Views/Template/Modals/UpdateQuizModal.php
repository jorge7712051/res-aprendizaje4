<div class="modal fade" id="updateQuizModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title">Actualización encuesta egresados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formUpdateQuizResult" name="formUpdateQuizResult" >
                    <div class="mb-3">
                        <label for="listLearningResult" class="col-form-label">Nombre de la encuesta</label>
                        <input autocomplete="off" class="form-control" id="editQuizName" name="quizName" type="text" aria-label="default input example" required>
                        <input type="hidden" id="idQuizId" disabled>
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" checked type="checkbox" role="switch" id="editActive" name="editActive">
                        <label class="form-check-label" for="flexSwitchCheckDefault" required>Activar encuesta</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>