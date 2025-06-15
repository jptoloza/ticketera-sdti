@extends('layout.main')

@section('content')
    <ol class="uc-breadcrumb">
        <li class="uc-breadcrumb_item">
            <a href="/"><i class="uc-icon">home</i></a>
            <i class="uc-icon">keyboard_arrow_right</i>
        </li>
        <li class="uc-breadcrumb_item current">Nuevo ticket</li>
    </ol>


    <div class="row mt-32 container-fluid">
        <div class="col-12">
            <div class="d-flex align-items-center mb-3">
                <h1>Nuevo Ticket</h1>
                <span class="uc-heading-decoration"></span>
            </div>

            <div class="p-size--sm p-text--condensed p-color--gray mt-0 mb-32">
                (*) Campos obligatorios necesarios para procesar tu suscripción en
                la lista correcta.
            </div>

            <form name="actionForm" id="actionForm" method="POST" action="{{ route('tickets_add') }}">
                @csrf
                <input type="hidden" name="files" id="files" />

                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="uc-form-group mb-3">
                            <label>Solicitante <span class="text-warning">*</span></label>
                            <input id="name" name="name" type="text" class="uc-input-style"
                                placeholder="Ingrese nombre del solicitante" autocomplete="off" />
                            <input id="userId" name="userId" type="hidden" value="" />
                            <p class="p-color--gray mb-16">
                                <a href="#" type="button" class="" data-bs-toggle="modal" data-bs-target="#newUser">
                                    <span class="uc-icon"
                                        style="margin-right:0px !important;margin-left:0px !important">add</span>
                                    Crear nuevo usuario
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="uc-form-group mb-3">
                            <label>Asignar al Equipo <span class="text-warning">*</span></label>
                            <select name="queue" id="queue" class="uc-input-style select2">
                                <option value="" selected="">Seleccionar</option>
                                @foreach ($queues as $queue)
                                    <option value="{{ $queue->id }}">
                                        {{ $queue->queue }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="uc-form-group mb-3">
                            <label>Asunto <span class="text-warning">*</span></label>
                            <input id="subject" name="subject" type="text" class="uc-input-style"
                                placeholder="Ingrese asunto" />
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="uc-form-group mb-3">
                            <label>Descripción <span class="text-warning">*</span></label>
                            <textarea id="message" name="messaje" class="uc-input-style" placeholder="Ingrese descripción"
                                style="min-height:200px"></textarea>
                            <div>
                                <ul id="file_list"></ul>

                            </div>
                            <p class="p-color--gray mb-16">
                                <a href="#" type="button" class="" data-bs-toggle="modal" data-bs-target="#newUser">
                                    <span class="uc-icon"
                                        style="margin-right:0px !important;margin-left:0px !important">add</span>
                                    Adjuntar archivo
                                </a>
                            </p>
                        </div>
                    </div>


                    @if (in_array(App\Http\Helpers\UtilHelper::globalKey('ROLE_AGENT'), Session::all()['roles']))

                        <hr class="uc-hr" />
                        <div class="col-12 col-lg-6">
                            <div class="uc-form-group mb-3">
                                <label>Asignar a <span class="text-warning">*</span></label>
                                <select name="assigned_agent" id="assigned_agent" class="uc-input-style select2">
                                    <option value="" selected="">Seleccionar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="uc-form-group mb-3">
                                <label>Estado <span class="text-warning">*</span></label>
                                <select name="status" id="status" class="uc-input-style select2">
                                    <option value="" selected="">Seleccionar</option>
                                    @foreach ($status as $state)
                                        <option value="{{ $state->id }}">
                                            {{ App\Http\Helpers\UtilHelper::ucTexto($state->status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="uc-form-group mb-3">
                                <label>Prioridad <span class="text-warning">*</span></label>
                                <select name="priority" id="priority" class="uc-input-style select2">
                                    <option value="" selected="">Seleccionar</option>
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority->id }}">
                                            {{ App\Http\Helpers\UtilHelper::ucTexto($priority->priority) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    @endif
                </div>

                <div class="uc-form-group mt-3 mb-5">
                    <button type="submit" class="uc-btn btn-secondary text-uppercase">
                        Guardar
                        <i class="uc-icon icon-shape--rounded ms-4">arrow_forward</i>
                    </button>
                </div>


            </form>

        </div>
    </div>







    <!-- Modal -->
    <div id="newUser" class="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="uc-message warning">
                    <a href="#" class="uc-message_close-button" data-bs-dismiss="modal"><i class="uc-icon">close</i></a>
                    <div class="uc-message_body">
                        <form name="actionFormNU" id="actionFormNU" method="POST" action="{{ route('tickets_newUser') }}">
                            @csrf
                            <h4>Nuevo Usuario</h4>
                            <div class="uc-text-divider divider-primary mt-16 mb-4"></div>
                            <div class="p-size--sm p-text--condensed p-color--gray mb-4 mt-2">
                                <span class="text-danger">*</span> Campo obligatorio.
                            </div>
                            <div class="uc-form-group">
                                <label for="first_name">Nombre <span class="text-danger">*</span></label>
                                <input id="name" name="name" type="text" class="uc-input-style" placeholder="Ingrese nombre"
                                    required />
                            </div>
                            <div class="uc-form-group">
                                <label for="run">R.U.T. <span class="text-danger">*</span></label>
                                <input id="rut" name="rut" type="text" class="uc-input-style" placeholder="Ingrese RUT"
                                    required />
                            </div>
                            <div class="uc-form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input id="email" name="email" type="email" class="uc-input-style"
                                    placeholder="Ingrese email" required />
                            </div>
                            <div class="uc-form-group">
                                <label for="usuario">Usuario UC <span class="text-danger">*</span></label>
                                <input id="login" name="login" type="text" class="uc-input-style"
                                    placeholder="Ingrese usuario" required />
                            </div>
                            <div id="error-flash-modal" style="display:none">
                                <div class="uc-alert error mb-12" style="display:block">
                                    <div class="flex d-flex justify-content-between">
                                        <div class="uc-alert_content">
                                            <i class="uc-icon icon-size--sm">cancel</i> Error.
                                        </div>
                                        <div>
                                            <div class="uc-alert_close" data-id="error-flash-login-modal"
                                                style="cursor: pointer;">
                                                <i class="uc-icon icon-size--sm">close</i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div style="display:block; width: 100% !important">
                                        <span class="p p-size--sm bold" id="error-flash-message-modal"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer modal-footer-confirm">
                    <button type="button" class="uc-btn btn-cta btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="uc-btn btn-cta" id="btnNext">Crear</button>
                </div>
            </div>
        </div>
    </div>




    <script>
        $().ready(function () {
            $("#name").autocomplete({
                source: '{{ route('tickets_userSearch') }}',
                minLength: 3,
                select: function (event, ui) {
                    $('#userId').val(ui.item.id);
                    console.log("Selected: " + ui.item.value + " / " + ui.item.id);
                }
            });

            $('#queue').change(function () {
                const id = $(this).val();
                const url = `{{route('tickets_agentsQueue') }}?queue_id=${id}`;
                $.ajax({
                    url: `${url}`,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        start();
                    },
                    success: function (data) {
                        console.log(data);
                        let options = data.map(item => new Option(item.text, item.id, false, false));
                        $('#assigned_agent').empty().append('<option value="" selected>Seleccionar</option>').append(options).trigger('change');
                    },
                    complete: function () {
                        stop();
                    },

                });
            });



            $('#btnNext').click(function () {
                const form = $('#actionFormNU');
                $('#name').val('');
                $('#userId').val('');                
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: form.serialize(),
                    timeout: 1200000,
                    beforeSend: function () {
                        start();
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                        $('#error-flash-message-modal').html(xhr.responseJSON.message || xhr.statusText);
                        $('#error-flash-modal').show('slow');
                        $('#ok-flash-modal').hide();
                    },
                    success: function (response) {
                        try {
                            if (response.success == 'ok') {
                                console.log(response.url)
                                // Actualizar valores de los inputs con los datos recibidos
                                $('#ok-flash-modal input[name="folio"]').val(response.data.invoice);
                                $('#ok-flash-modal input[name="tipo"]').val(response.data.type_card);
                                $('#ok-flash-modal input[name="estado"]').val(response.status.status_card);
                                $('#ok-flash-modal input[name="run"]').val(response.studentData.run);
                                $('#ok-flash-modal input[name="nombre"]').val(response.studentData.social_name);
                                $('#ok-flash-modal input[name="date"]').val(response.data.updated_at);
                                $('#ok-flash-modal a[id="pdfDownload"]').attr('href', response.url);
                                $('#ok-flash-message_modal').html(response.message || 'Success');
                                $('#ok-flash-modal').show('slow');
                                $('#error-flash-modal').hide();
                            } else {
                                throw new Error(response.message || 'Error');
                            }
                        } catch (e) {
                            $('#error-flash-message-modal').html(e.message);
                            $('#error-flash-modal').show('slow');
                            $('#ok-flash-modal').hide();
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
@endsection