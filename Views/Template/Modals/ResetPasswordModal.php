<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title">Restablecimiento de contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formResetPassword" name="formResetPassword">
                <div class="mb-3">
                        <label class="form-check-label" for="resetEmail">Correo Electronico</label>
                        <input type="email" class="form-control" id="resetEmail" name="resetEmail" aria-describedby="HelpDomain" autocomplete="off" required placeholder="example@email.com">
                </div>
                <div id="HelpDomain" class="form-text">
                    Si el correo se encuentra resgistado se le enviara un Email con un enlace de restablecimiento de contraseña                    
                </div>
                <br>
                 <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnReset" class="btn btn-success">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>