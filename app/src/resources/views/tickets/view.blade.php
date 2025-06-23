@extends('layout.main')

@section('content')
  <ol class="uc-breadcrumb">
    <li class="uc-breadcrumb_item">
      <a href="/"><i class="uc-icon">home</i></a>
      <i class="uc-icon">keyboard_arrow_right</i>
    </li>
    <li class="uc-breadcrumb_item current">
      <a href="{{ route('tickets') }}">Mis Tickets</a>
      <i class="uc-icon">keyboard_arrow_right</i>
    </li>
    <li class="uc-breadcrumb_item current">Ticket #{{ $ticket->id }}: {{ $ticket->subject }}</li>
  </ol>



  <div class="row mt-32 container-fluid">
    <div class="col-12">
      <div class="d-flex align-items-center mb-3">
        <h1>{{ $ticket->subject }}</h1>
        <span class="uc-heading-decoration"></span>
      </div>

      @php
        $created_at = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ticket->created_at);
        $updated_at = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ticket->updated_at);
        $isAdmin = false;
        if (in_array(App\Http\Helpers\UtilHelper::globalKey('ROLE_AGENT'), Session::all()['roles'])) {
            $isAdmin = true;
        }

      @endphp

      <div class="row">
        <div class="col-12 @if ($isAdmin) col-lg-8 @endif pb-4">
          <div class="uc-tabpanel" data-tabpanel>
            <!-- Tabs mobile se muestran como Select -->
            <div class="uc-card card-bg--gray card-radius--none card-border--none d-block d-lg-none mb-32">
              <div class="uc-card_body">
                <label for="tabSelect"><strong>Seleccione</strong></label>
                <select name="tabSelect" id="tabSelect" class="uc-input-style" data-tabselect>
                  <option value="tab-01">Detalles</option>
                  <option value="tab-02">Actividad</option>
                </select>
              </div>
            </div>
            <!-- Tabs en desktop se muestran como botones -->
            <ul class="uc-tabs d-none d-lg-flex">
              <li class="uc-tabs_item">
                <a href="javascript:void(0);" class="uc-tabs_item-link" data-tabtarget="tab-01"
                  data-tabactive>Detalles</a>
              </li>
              <li class="uc-tabs_item">
                <a href="javascript:void(0);" class="uc-tabs_item-link" data-tabtarget="tab-02">Actividad</a>
              </li>
            </ul>
            <div class="uc-tab-body" style="min-height:400px !important">
              <div data-tab="tab-01">

                <div class="table-responsive">
                  <table class="uc-table w-100">
                    <tbody>
                      <tr>
                        <td class="border-top-ticket dt-col-200px fw-bold">Estado</td>
                        <td class="border-top-ticket">
                          @php
                            $statusTicket = '';
                            foreach ($status as $state) {
                                if ($state->id == $ticket->status_id) {
                                    $statusTicket = App\Http\Helpers\UtilHelper::ucTexto($state->status);
                                    break;
                                }
                            }
                            echo $statusTicket;
                          @endphp
                        </td>
                      </tr>

                      <tr>
                        <td class="fw-bold">Solicitante</td>
                        <td>{{ App\Http\Helpers\UtilHelper::ucTexto($requesterBy->name) }}</td>
                      </tr>

                      <tr>
                        <td class="fw-bold">Fecha de creación</td>
                        <td>{{ $created_at->format('Y-m-d H:i') }}</td>
                      </tr>

                      <tr>
                        <td class="fw-bold">Última Actualización</td>
                        <td>{{ $updated_at->format('Y-m-d H:i') }}</td>
                      </tr>

                      <tr>
                        <td class="fw-bold">Asignado al Equipo</td>
                        <td>
                          @foreach ($queues as $queue)
                            @if ($queue->id == $ticket->queue_id)
                              {{ $queue->queue }}
                            @endif
                          @endforeach
                        </td>
                      </tr>


                      <tr>
                        <td class="@if ($files) border-bottom-0 @endif" colspan="2">
                          <div class="mb-2 fw-bold">Mensaje</div>
                          <div>{!! $ticket->message !!}</div>
                          @if ($files)
                            <div class="mt-2 mb-2 fw-bold">Archivos adjuntos</div>
                            <div>
                              <ul id="file_list_download">
                                @foreach ($files as $file)
                                  <li><a
                                      href="{{ route('tickets_downloadFile', ['type' => 1, 'id' => $ticket->id, 'file' => $file->fileName]) }}">{{ $file->name }}</a>
                                  </li>
                                @endforeach
                              </ul>
                            </div>
                          @endif

                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>


                <div class="d-flex align-items-center mt-5 mb-3">
                  <h3>Conversación</h3>
                </div>

                @if ($messages->count())
                  @foreach ($messages as $message)
                    <div class="d-flex justify-content-start align-items-top pt-2 pb-4 border-bottom mb-2">
                      <div class="me-2 pt-3">
                        <span class="nav-link navbar-nav-user-img bg-uc-blue-3 text-white"
                          style="padding-left:8px;padding-top:8px">{{ App\Http\Helpers\UtilHelper::navbarName($message->name) }}</span>
                      </div>
                      <div class="w-100 ps-2">
                        @php
                          $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $message->created_at);
                        @endphp
                        <div class="w-100" style="font-size:10px">{{ $date->format('Y-m-d h:i') }}</div>
                        <div class="w-100 fw-bold mb-2">{{ $message->name }}</div>
                        <div>
                          {!! $message->message !!}
                        </div>

                        <div class="mt-1">
                          <ul id="file_list_download_messages" style="padding-left:10px;">
                            @if ($message->files)
                              @php
                                $files = json_decode($message->files);
                              @endphp
                              @foreach ($files as $file)
                                <li><a
                                    href="{{ route('tickets_downloadFile', ['type' => 2, 'id' => $message->id, 'file' => $file->fileName]) }}">{{ $file->name }}</a>
                                </li>
                              @endforeach
                            @endif
                          </ul>
                        </div>

                      </div>
                    </div>
                  @endforeach
                @endif

                <div class="mt-4">
                  <div class="mb-3">
                    <h4>Nuevo Mensaje</h4>
                  </div>

                  <form name="actionFormNM" id="actionFormNM" method="POST" action="{{ route('tickets_addMessage') }}">
                    @csrf
                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}" />
                    <input type="hidden" name="files" id="files" value="" />
                    <div class="">
                      <div class="uc-form-group mb-3">


                        <div id="toolbar-container">
                          <span class="ql-formats">
                            <button class="ql-bold"></button>
                            <button class="ql-italic"></button>
                            <button class="ql-underline"></button>
                            <button class="ql-strike"></button>
                          </span>
                          <span class="ql-formats">
                            <button class="ql-list" value="ordered"></button>
                            <button class="ql-list" value="bullet"></button>
                          </span>
                          <span class="ql-formats">
                            <button class="ql-link"></button>
                            <button class="ql-image"></button>
                          </span>
                        </div>
                        <div id="editor">
                        </div>

                        <input type="hidden" id="message" name="message" value="" required />
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


              <div data-tab="tab-02">
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th style="width:50px">#</td>
                        <th style="width:90px">Fecha</th>
                        <th>Registro</th>
                    </thead>
                    <tbody>
                      @php
                        $count = $logs->count();
                      @endphp
                      @foreach ($logs as $log)
                        @php
                          $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $log->created_at);
                        @endphp
                        <tr>
                          <td>{{ $count }} @php $count--;@endphp <!--{{ $log->id }}--></td>
                          <td>{{ $date->format('Y-m-d h:i') }}</td>
                          <td>{!! $log->action !!}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>


        @if ($isAdmin)
          <div class="bg--gray col-12 col-lg-4 pb-4 p-4">
            <form class="p-4" name="actionForm" id="actionForm" method="POST"
              action="{{ route('tickets_update') }}">
              @csrf
              <input type="hidden" name="id" value="{{ $ticket->id }}" />
              <div class="uc-form-group mb-3">
                <label>Asignar a <span class="text-danger">*</span></label>
                <select name="assigned_agent" id="assigned_agent" class="uc-input-style select2">
                  <option value="">Seleccionar</option>
                  @foreach ($agents as $agent)
                    <option value="{{ $agent['id'] }}" @if ($agent['id'] == $ticket->assigned_agent) selected="selected" @endif>
                      {{ $agent['name'] }}</option>
                  @endforeach
                </select>
              </div>
              <div class="uc-form-group mb-3">
                <label>Estado <span class="text-danger">*</span></label>
                <select name="status" id="status" class="uc-input-style select2" required>
                  <option value="" selected="">Seleccionar</option>
                  @foreach ($status as $state)
                    <option value="{{ $state->id }}" @if ($state->id == $ticket->status_id) selected="selected" @endif>
                      {{ App\Http\Helpers\UtilHelper::ucTexto($state->status) }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="uc-form-group mb-3">
                <label>Prioridad <span class="text-danger">*</span></label>
                <select name="priority" id="priority" class="uc-input-style select2" required>
                  <option value="" selected="">Seleccionar</option>
                  @foreach ($priorities as $priority)
                    <option value="{{ $priority->id }}" @if ($priority->id == $ticket->priority_id) selected="selected" @endif>
                      {{ App\Http\Helpers\UtilHelper::ucTexto($priority->priority) }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div id="error-flash-update" style="display:none">
                <div class="uc-alert error mb-12" style="display:block">
                  <div class="flex d-flex justify-content-between">
                    <div class="uc-alert_content">
                      <i class="uc-icon icon-size--sm">cancel</i> Error.
                    </div>
                    <div>
                      <div class="uc-alert_close" data-id="error-flash-update" style="cursor: pointer;">
                        <i class="uc-icon icon-size--sm">close</i>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div style="display:block; width: 100% !important">
                    <span class="p p-size--sm bold" id="error-flash-update-message"></span>
                  </div>
                </div>
              </div>

              <div class="uc-form-group mt-3">
                <button type="submit" class="uc-btn btn-secondary text-uppercase">
                  Actualizar
                  <i class="uc-icon icon-shape--rounded ms-4">arrow_forward</i>
                </button>
              </div>
          </div>
          </form>

      </div>
      @endif





    </div>
  </div>
  </div>









  <script>
    const quill = new Quill('#editor', {
      modules: {
        syntax: true,
        toolbar: '#toolbar-container',
      },
      placeholder: 'Ingrese mensaje',
      theme: 'snow',
    });
  </script>

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
    $().ready(function() {
      $('#collapseData').on('shown.bs.collapse', function() {
        $('#btnShowDetails').text('Ocultar Detalles');
      }).on('hidden.bs.collapse', function() {
        $('#btnShowDetails').text('Mostrar detalles');
      });

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



      $('#btnAddFile').click(function(e) {
        e.preventDefault();
        $('#uploadFile').click();
      });



      TS_AJAX_FORM.initMyAjaxForm();
      $('#uploadFile').change(function() {
        $('#addFileForm').submit();
      });
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

  {!! App\Http\Helpers\Jquery::ajaxPostEditor('actionFormNM', 'message', '/tickets/' . $ticket->id) !!}
  {!! App\Http\Helpers\Jquery::ajaxPostError('actionForm', 'error-flash-update', '/tickets/' . $ticket->id) !!}

@endsection
