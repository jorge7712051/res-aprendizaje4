<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title">Registro de usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRegister" name="formRegister">
                <div class="mb-3">
                        <label class="form-check-label" for="userEmail">Correo Electronico</label>
                        <input type="email" class="form-control" id="userEmail" name="userEmail" autocomplete="off" required>
                </div>
                <div class="mb-3">
                        <label class="form-check-label" for="password">Password</label>
                        <input type="password" id="userPassword" name="userPassword" class="form-control" required>
                </div>
                <div class="mb-3">
                        <label class="form-check-label" for="userPassword2">Confirmar Password</label>
                        <input type="password" id="userPassword2" name="userPassword2" class="form-control" required>
</div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnRegister" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>