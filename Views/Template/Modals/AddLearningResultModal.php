<div class="modal fade" id="addLearningResultModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title">Nuevo Resultado de Aprendizaje</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAddLearningResult" name="formAddLearningResult">
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Nombre:</label>
                    <input type="text"
                    class="form-control" 
                    id="txtNameAdd" 
                    name="txtNameAdd" 
                    placeholder="Nombre del resultado de aprendizaje" 
                    require="">
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Descripción:</label>
                    <textarea class="form-control" 
                    id="txtDescriptionAdd" 
                    name="txtDescriptionAdd" 
                    placeholder="Detalle del resultado de aprendizaje" 
                    require=""
                    rows="3"></textarea>
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