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
                <input type="hidden" name="files" id="files" value="" />

                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="uc-form-group mb-3">
                            <label>Solicitante <span class="text-danger">*</span></label>
                            @if (
                                !in_array(App\Http\Helpers\UtilHelper::globalKey('ROLE_AGENT'), Session::all()['roles']) &&
                                    !in_array(App\Http\Helpers\UtilHelper::globalKey('ROLE_ADMINISTRATOR'), Session::all()['roles']))
                                <input id="name2" name="name2" type="text" class="uc-input-style"
                                    value="{{ Session::all()['name'] }}" disabled />
                                <input id="name" name="name" type="hidden" value="{{ Session::all()['name'] }}" />
                                <input id="userId" name="userId" type="hidden" value="{{ Session::all()['id'] }}" />
                            @else
                                <input id="name" name="name" type="text" class="uc-input-style"
                                    placeholder="Ingrese nombre del solicitante" required />
                                <input id="userId" name="userId" type="hidden" value="" required />
                            @endif
                            @if (in_array(App\Http\Helpers\UtilHelper::globalKey('ROLE_AGENT'), Session::all()['roles']))
                                <p class="p-color--gray mb-16">
                                    <a href="#" id="btnNewUser">
                                        <span class="uc-icon"
                                            style="margin-right:0px !important;margin-left:0px !important">add</span>
                                        Crear nuevo usuario
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="uc-form-group mb-3">
                            <label>Asignar al Equipo <span class="text-danger">*</span></label>
                            <select name="queue" id="queue" class="uc-input-style select2" required>
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
                            <label>Asunto <span class="text-danger">*</span></label>
                            <input id="subject" name="subject" type="text" class="uc-input-style"
                                placeholder="Ingrese asunto" required />
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="uc-form-group mb-3">
                            <label>Descripción <span class="text-danger">*</span></label>
                            <textarea id="message" name="message" class="uc-input-style" placeholder="Ingrese descripción"
                                style="min-height:200px" required></textarea>
                            <div>
                                <ul id="file_list" style="list-style-type: none;padding-left: 0;"></ul>

                            </div>
                            <p class="p-color--gray mb-16">
                                <a href="#" id="btnAddFile">
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
                                <label>Asignar a <span class="text-danger">*</span></label>
                                <select name="assigned_agent" id="assigned_agent" class="uc-input-style select2">
                                    <option value="" selected="">Seleccionar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="uc-form-group mb-3">
                                <label>Estado <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="uc-input-style select2" required>
                                    <option value="" selected="">Seleccionar</option>
                                    @foreach ($status as $state)
                                        <option value="{{ $state->id }}"
                                            @if (App\Http\Helpers\UtilHelper::globalKey('STATUS_OPEN') == $state->id) selected="selected" @endif>
                                            {{ App\Http\Helpers\UtilHelper::ucTexto($state->status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="uc-form-group mb-3">
                                <label>Prioridad <span class="text-danger">*</span></label>
                                <select name="priority" id="priority" class="uc-input-style select2" required>
                                    <option value="" selected="">Seleccionar</option>
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority->id }}"
                                            @if (App\Http\Helpers\UtilHelper::globalKey('PRIORITY_HALF') == $priority->id) selected="selected" @endif>
                                            {{ App\Http\Helpers\UtilHelper::ucTexto($priority->priority) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                </div>




                <div id="error-flash" style="display:none">
                    <div class="uc-alert error mb-12" style="display:block">
                        <div class="flex d-flex justify-content-between">
                            <div class="uc-alert_content">
                                <i class="uc-icon icon-size--sm">cancel</i> Error.
                            </div>
                            <div>
                                <div class="uc-alert_close" data-id="error-flash" style="cursor: pointer;">
                                    <i class="uc-icon icon-size--sm">close</i>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div style="display:block; width: 100% !important">
                            <span class="p p-size--sm bold" id="error-flash-message"></span>
                        </div>
                    </div>
                </div>


                <div class="uc-form-group mt-3 mb-5">
                    <button type="submit" class="uc-btn btn-secondary text-uppercase">
                        Enviar
                        <i class="uc-icon icon-shape--rounded ms-4">arrow_forward</i>
                    </button>
                </div>

            </form>


            <form action="{{ route('tickets_addFile') }}" method="POST" name="addFileForm" id="addFileForm"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="pdf,jpg,gif,png,docx,xlsx">
                <div class="form-group">
                    <input type="file" id="uploadFile" name="file" class="d-none">
                </div>
            </form>


        </div>
    </div>






    @if (in_array(App\Http\Helpers\UtilHelper::globalKey('ROLE_AGENT'), Session::all()['roles']))
        <!-- Modal -->
        <div id="newUser" class="modal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="uc-message warning">
                        <a href="#" class="uc-message_close-button" data-bs-dismiss="modal"><i
                                class="uc-icon">close</i></a>
                        <div class="uc-message_body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif



    <script>
        function modalError(message) {
            var modal = `<div id="messageError" class="modal">
      <div class="modal-dialog">
      <div class="modal-content">
      <div class="uc-message error siga-message">
      <a href="#" class="uc-message_close-button" data-bs-dismiss="modal"><i class="uc-icon">close</i></a>
      <div class="uc-message_body">
      <h2 class="mb-24">
        <i class="uc-icon warning-icon">error</i> Error
      </h2>
      <p class="no-margin">
        ${message}
      </p>
      </div>
      </div>
      <div class="modal-footer modal-footer-confirm">
      <button type="button" class="uc-btn btn-cta btn-cancel" data-bs-dismiss="modal">Continuar</button>
      </div>
      </div>
      </div>
      </div>
      `;

            $('body').append(modal);
            $('#messageError').modal('show');
            $('#messageError').on('hidden.bs.modal', function(event) {
                $('#messageError').remove();
            });
        }

        const TS_AJAX_FORM = {
            beforeSubmitHandler: function(arr, form, options) {
                let isValid = true;
                const maxSize = {{ App\Http\Helpers\UtilHelper::convertToBytes(ini_get('upload_max_filesize')) }};
                const fileInput = document.getElementById('uploadFile');
                const file = fileInput.files[0];
                if (file.name === "") {
                    modalError('Seleccione Archivo');
                    isValid = false;
                }
                if (file.size > maxSize) {
                    modalError('El archivo no puede superar los {{ ini_get('upload_max_filesize') }}.');
                    isValid = false;
                }
                if (isValid) start();
                return isValid;
            },
            successHandler: function(response, statusText, xhr, form) {
                try {
                    if (response.success == 'ok') {
                        let files = $('#files').val();
                        if (files.length == 0) {
                            files = [];
                        } else {
                            files = JSON.parse(files);
                            i = files.length;
                        }
                        files.push(response.data);
                        $('#files').val(JSON.stringify(files));
                        $('#file_list').empty();
                        files.forEach(element => {
                            let li =
                                `<li><a href="#" class="btnDelete" data-id="${element.fileName}"><i class="uc-icon" style="margin: 0px !important">delete</i></a> ${element.name}</li>`;
                            $('#file_list').append(li);
                        });
                    } else {
                        throw new Error($response.message);
                    }
                } catch (e) {
                    modalError(e);
                } finally {
                    stop();

                }
            },
            errorHandler: function(response, status, error) {
                var message = response.responseJSON.message || response.statusText;
                stop();
                modalError(message);
            },
            initMyAjaxForm: function() {
                $("#addFileForm").ajaxForm({
                    beforeSubmit: this.beforeSubmitHandler,
                    success: this.successHandler,
                    clearForm: true,
                    error: this.errorHandler,
                });
            }
        };

        $().ready(function() {
            $("#name").autocomplete({
                source: '{{ route('tickets_userSearch') }}',
                minLength: 1,
                select: function(event, ui) {
                    $('#userId').val(ui.item.id);
                    console.log("Selected: " + ui.item.value + " / " + ui.item.id);
                },
                change: function(event, ui) {
                    if (ui.item === null) {
                        $(this).val(""); // Clear the input if no item was selected            
                    }
                }

            });

            @if (in_array(App\Http\Helpers\UtilHelper::globalKey('ROLE_AGENT'), Session::all()['roles']))
                $('#queue').change(function() {
                    const id = $(this).val();
                    const url = `{{ route('tickets_agentsQueue') }}?queue_id=${id}`;
                    $.ajax({
                        url: `${url}`,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function() {
                            start();
                        },
                        success: function(data) {
                            let options = data.map(item => new Option(item.text,
                                item.id, false, false));
                            $('#assigned_agent').empty().append(
                                '<option value="" selected>Seleccionar</option>'
                            ).append(
                                options).trigger('change');
                        },
                        complete: function() {
                            stop();
                        },
                    });
                });
            @endif

            $('#btnAddFile').click(function(e) {
                e.preventDefault();
                $('#uploadFile').click();
            });

            TS_AJAX_FORM.initMyAjaxForm();
            $('#uploadFile').change(function() {
                $('#addFileForm').submit();
            });

            @if (in_array(App\Http\Helpers\UtilHelper::globalKey('ROLE_AGENT'), Session::all()['roles']))
                $('#btnNewUser').click(function() {
                    var modal = new bootstrap.Modal($('#newUser')[0]);
                    var modalBody = $('#newUser .uc-message_body');
                    start();
                    modal.show();
                    $.ajax({
                        url: '{{ route('tickets_newUser_form') }}',
                        method: 'GET',
                        success: function(data) {
                            modalBody.html(data);
                        },
                        error: function() {},
                        complete: function() {
                            stop();
                        }
                    });
                });

                $('#newUser').on('hidden.bs.modal', function() {
                    $('#newUser .uc-message_body').html('');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                });
            @endif

        });

        $(document).on('click', '.btnDelete', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id');
            let files = $('#files').val();
            if (files.length == 0) {
                files = [];
            } else {
                files = JSON.parse(files);
            }
            newFiles = files.filter(e => e.fileName != id);
            $('#files').val(JSON.stringify(newFiles));
            $('#file_list').empty();
            newFiles.forEach(element => {
                let li =
                    `<li><a href="#" class="btnDelete" data-id="${element.fileName}"><i class="uc-icon" style="margin: 0px !important">delete</i></a> ${element.name}</li>`;
                $('#file_list').append(li);
            });
        });
    </script>

    {!! $ajaxPost !!}
@endsection
