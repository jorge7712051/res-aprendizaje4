<div class="modal fade" id="UpdateQuestionModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title">Creación preguntas de encuestas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formUpdateQuestionResult" name="formUpdateQuestionResult">
                    <input type="hidden" id="idQuestionId" disabled>
                    <div class="mb-3">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Encuesta</label>
                        <select class="form-select" id="editListQuiz" name="editListQuiz" required>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="questionName" class="col-form-label">Pregunta</label>
                        <input autocomplete="off" class="form-control" id="editQuestionName" name="editQuestionName" type="text" aria-label="default input example" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Tipo de control</label>
                        <select class="form-select" onchange="showEditDomain()" id="editType" name="editType" required>
                            <option value="" selected>Seleccione un control</option>
                            <option value="text">Text</option>
                            <option value="textarea">TextArea</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="select">Select</option>
                            <option value="number">Number</option>
                            <option value="radio">Radio</option>
                            <option value="email">Email</option>
                        </select>
                    </div>
                    <div id="editDominio" class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Opciones</label>
                        <textarea class="form-control" id="editDomain" name="editDomain" rows="3" aria-describedby="HelpDomain"></textarea>
                        <div id="HelpDomain" class="form-text">
                            Escriba cada opcion separada po una coma ","
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="listLearningResult" class="col-form-label">Icono</label>
                        <input autocomplete="off" class="form-control" id="editIcon" name="editIcon" type="text" aria-label="default input example" aria-describedby="HelpIcon">
                        <div id="HelpIcon" class="form-text">
                            Consulte el listado de iconos <a href="https://icons.getbootstrap.com/" target="_blank"> Aqui</a>
                        </div>
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" checked type="checkbox" role="switch" id="editRequired" name="editRequired">
                        <label class="form-check-label" for="flexSwitchCheckDefault" required>Pregunta requerida</label>
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