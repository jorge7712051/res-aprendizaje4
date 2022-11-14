<div class="modal fade" id="editLearningResultModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualizar Resultado de aprendizaje</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditLearningResult" name="formEditLearningResult">
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Código:</label>
                    <input type="text"
                    class="form-control" 
                    id="txtCodeEdit" 
                    name="txtCodeEdit"
                    disabled>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Nombre:</label>
                    <input type="text"
                    class="form-control" 
                    id="txtNameEdit" 
                    name="txtNameEdit" 
                    placeholder="Nombre del resultado de aprendizaje" 
                    required="">
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Detalle:</label>
                    <textarea class="form-control" 
                    id="txtDescriptionEdit" 
                    name="txtDescriptionEdit" 
                    placeholder="Detalle del resultado de aprendizaje" 
                    required=""
                    rows="5"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" >Actualizar</button>
                </div>
                </form>
            </div>
            
        </div>
    </div>
</div>