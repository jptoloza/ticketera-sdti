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
    <li class="uc-breadcrumb_item current">Ticket #{{ $ticket->id }}</li>
  </ol>


  <div class="row mt-32 container-fluid">
    <div class="col-12">
      <div class="d-flex align-items-center mb-3">
        <h1>{{ $ticket->subject }}</h1>
        <span class="uc-heading-decoration"></span>
      </div>



      <div class="d-flex justify-content-between align-items-center mb-3">
        @php
          $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ticket->created_at);
        @endphp
        <h4>Ticket creado por {{ $createdBy->name }} ({{ $date->format('Y-m-d H:i') }})</h4>
        <a href="javascript:void(0)" id="btnShowDetails" data-bs-toggle="collapse" data-bs-target="#collapseData">Ocultar
          Detalles</a>
      </div>

      <div class="collapse show" id="collapseData">
        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="uc-form-group mb-3">
              <label>Solicitante <span class="text-danger">*</span></label>
              <input id="name2" name="name2" type="text" class="uc-input-style"
                value="{{ Session::all()['name'] }}" disabled />
            </div>
          </div>

          <div class="col-12 col-lg-6">
            <div class="uc-form-group mb-3">
              <label>Asignar al Equipo <span class="text-danger">*</span></label>
              <select name="queue" id="queue" class="uc-input-style select2" disabled>
                @foreach ($queues as $queue)
                  @if ($queue->id == $ticket->queue_id)
                    <option value="{{ $queue->id }}" selected="selected">{{ $queue->queue }}</option>
                  @endif
                @endforeach

              </select>
            </div>
          </div>

          <div class="col-12">
            <div class="uc-form-group mb-3">
              <label>Asunto <span class="text-danger">*</span></label>
              <input id="subject" name="subject" type="text" class="uc-input-style" value="{{ $ticket->subject }}"
                disabled />
            </div>
          </div>

          <div class="col-12">
            <div class="uc-form-group mb-3">
              <label>Descripción <span class="text-danger">*</span></label>
              <div class="p-3 border rounded-1" style="background:#f6f6f6">
                {{ $ticket->message }}
              </div>
              <div>
                <ul id="file_list_download">
                  @if ($ticket->files)
                    @php
                      $files = json_decode($ticket->files);
                    @endphp
                    @foreach ($files as $file)
                      <li><a
                          href="{{ route('tickets_downloadFile', ['type' => 1, 'id' => $ticket->id, 'file' => $file->fileName]) }}">{{ $file->name }}</a>
                      </li>
                    @endforeach
                  @endif
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

      <hr class="uc-hr" />
      <div class="uc-tabpanel" data-tabpanel>
        <!-- Tabs mobile se muestran como Select -->
        <div class="uc-card card-bg--gray card-radius--none card-border--none d-block d-lg-none mb-32">
          <div class="uc-card_body">
            <label for="tabSelect"><strong>Seleccione</strong></label>
            <select name="tabSelect" id="tabSelect" class="uc-input-style" data-tabselect>
              <option value="tab-01">Actividad</option>
              <option value="tab-02">Registros</option>
            </select>
          </div>
        </div>
        <!-- Tabs en desktop se muestran como botones -->
        <ul class="uc-tabs d-none d-lg-flex">
          <li class="uc-tabs_item">
            <a href="javascript:void(0);" class="uc-tabs_item-link" data-tabtarget="tab-01" data-tabactive>Actividad</a>
          </li>
          <li class="uc-tabs_item">
            <a href="javascript:void(0);" class="uc-tabs_item-link" data-tabtarget="tab-02">Registros</a>
          </li>
        </ul>
        <div class="uc-tab-body" style="min-height:400px !important">
          <div data-tab="tab-01">


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
                    {{ $message->message }}
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







            <hr class="uc-hr" />

            <form name="actionFormNM" id="actionFormNM" method="POST" action="{{ route('tickets_addMessage') }}">
              @csrf
              <input type="hidden" name="ticket_id" value="{{ $ticket->id }}" />
              <input type="hidden" name="files" id="files" value="" />
              <div class="mt-3">
                <div class="uc-form-group mb-3">
                  <label>Nuevo Mensaje <span class="text-danger">*</span></label>
                  <textarea id="message" name="message" class="uc-input-style" placeholder="Ingrese mensaje"
                    style="min-height:200px" required></textarea>
                  <div>
                    <ul id="file_list"></ul>

                  </div>
                  <p class="p-color--gray mb-16">
                    <a href="#" id="btnAddFile">
                      <span class="uc-icon" style="margin-right:0px !important;margin-left:0px !important">add</span>
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





            @if (in_array(App\Http\Helpers\UtilHelper::globalKey('ROLE_AGENT'), Session::all()['roles']))
              <form name="actionForm" id="actionForm" method="POST" action="{{ route('tickets_update') }}">
                @csrf
                <input type="hidden" name="id" value="{{$ticket->id}}"/>
                <hr class="uc-hr" />
                <div class="row mt-3">
                  <div class="col-12 col-lg-6">
                    <div class="uc-form-group mb-3">
                      <label>Asignar a <span class="text-danger">*</span></label>
                      <select name="assigned_agent" id="assigned_agent" class="uc-input-style select2">
                        <option value="">Seleccionar</option>
                        @foreach ($agents as $agent)
                          <option value="{{ $agent['id'] }}"
                            @if ($agent['id'] == $ticket->assigned_agent) selected="selected" @endif>{{ $agent['name'] }}</option>
                        @endforeach
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
                             @if ($state->id == $ticket->status_id) selected="selected" @endif>
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
                            @if ($priority->id == $ticket->priority_id) selected="selected" @endif>
                            {{ App\Http\Helpers\UtilHelper::ucTexto($priority->priority) }}
                          </option>
                        @endforeach
                      </select>
                    </div>
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


                  <div class="uc-form-group mt-3 mb-5">
                    <button type="submit" class="uc-btn btn-secondary text-uppercase">
                      Actualizar
                      <i class="uc-icon icon-shape--rounded ms-4">arrow_forward</i>
                    </button>
                  </div>
                </div>
              </form>
            @endif


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
                  @foreach ($logs as $log)
                    @php
                      $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $log->created_at);
                    @endphp
                    <tr>
                      <td>{{ $log->id }}</td>
                      <td>{{ $date->format('Y-m-d h:i') }}</td>
                      <td>{{ $log->action }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

            </div>


          </div>
        </div>
      </div>









    </div>

  </div>


  <hr class="uc-hr" />






  <script>
    $().ready(function() {
      $('#collapseData').on('shown.bs.collapse', function() {
        $('#btnShowDetails').text('Ocultar Detalles');
      }).on('hidden.bs.collapse', function() {
        $('#btnShowDetails').text('Mostrar detalles');
      });



      const TS_AJAX_FORM = {
        beforeSubmitHandler: function(arr, form, options) {
          var isValid = true;
          $.each(arr, function(index, aField) {
            if (aField.name === 'uploadFile' && aField.value === "") {
              modalError('Seleccione Archivo');
              isValid = false;
            }
          });
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
                let li = `<li>${element.name}</li>`;
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
  </script>

  {!! App\Http\Helpers\Jquery::ajaxPost('actionFormNM', '/tickets/' . $ticket->id) !!}
  {!! App\Http\Helpers\Jquery::ajaxPostError('actionForm','error-flash-update', '/tickets/' . $ticket->id) !!}

@endsection
