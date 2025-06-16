<div class="">
    <form name="actionFormNewUser" id="actionFormNewUser" method="POST" action="{{ route('tickets_newUser') }}">
        @csrf
        <h4>Nuevo Usuario</h4>
        <div class="uc-text-divider divider-primary mt-16 mb-4"></div>
        <div class="p-size--sm p-text--condensed p-color--gray mb-4 mt-2">
            <span class="text-danger">*</span> Campo obligatorio.
        </div>
        <div class="uc-form-group">
            <label for="first_name">Nombre <span class="text-danger">*</span></label>
            <input id="name" name="name" type="text" class="uc-input-style" placeholder="Ingrese nombre" required />
        </div>
        <div class="uc-form-group">
            <label for="run">R.U.T. <span class="text-danger">*</span></label>
            <input id="rut" name="rut" type="text" class="uc-input-style" placeholder="Ingrese RUT" required />
        </div>
        <div class="uc-form-group">
            <label for="email">Email UC <span class="text-danger">*</span></label>
            <input id="email" name="email" type="email" class="uc-input-style" placeholder="Ingrese email" required />
        </div>
        <div id="error-flash-modal" style="display:none">
            <div class="uc-alert error mb-12" style="display:block">
                <div class="flex d-flex justify-content-between">
                    <div class="uc-alert_content">
                        <i class="uc-icon icon-size--sm">cancel</i> Error.
                    </div>
                    <div>
                        <div class="uc-alert_close" data-id="error-flash-modal" style="cursor: pointer;">
                            <i class="uc-icon icon-size--sm">close</i>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div style="display:block; width: 100% !important">
                    <span class="p p-size--sm bold" id="error-flash-modal-message"></span>
                </div>
            </div>
        </div>
        <div class="uc-form-group mt-5 modal-footer modal-footer-confirm border-top-0">
            <button type="button" class="uc-btn btn-primary text-uppercase uc-alert_close" data-bs-dismiss="modal">
                Cancelar
            </button>
            <button type="submit" class="uc-btn btn-secondary btn-cta text-uppercase">
                Guardar
                <i class="uc-icon icon-shape--rounded ms-4">arrow_forward</i>
            </button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $().ready(function () {
        $(".uc-alert_close").click(function () {
            id = $(this).attr("data-id");
            $("#" + id).hide("slow");
        });
        $('#actionFormNewUser').submit(function (e) {
            e.preventDefault();
            var response;
            var msg;
            var url;
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                timeout: 1200000,
                beforeSend: function () {
                    start();
                },
                error: function (response) {
                    console.log(response);
                    const message = response.responseJSON.message || response.statusText;
                    $('#error-flash-modal-message').html(message);
                    $('#error-flash-modal').show('slow');
                },
                success: function (response) {
                    console.log(response);
                    var response = response;
                    try {
                        if (response.success == 'ok') {
                            const data = response.data; 
                            $('#name').val(data.name);
                            $('#userId').val(data.id);
                            $('#newUser').modal('hide');
                            
                        } else {
                            throw new Error();
                        }
                    } catch (e) {
                        $('#error-flash-modal-message').html(e);
                        $('#error-flash-modal').show('slow');
                    }
                },
                complete: function () {
                    stop();
                }
            });
            return false;
        });
    });
</script>