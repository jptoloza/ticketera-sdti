@extends('layout.main_admin')

@section('content')
  <div class="pt-2">
    <ol class="uc-breadcrumb">
    <li class="uc-breadcrumb_item">
      <a href="/" class="mr-0"><i class="uc-icon">home</i></a>
      <i class="uc-icon">keyboard_arrow_right</i>
    </li>
    <li class="uc-breadcrumb_item">
      <a href="/admin">Herramientas Administrativas</a>
      <i class="uc-icon">keyboard_arrow_right</i>
    </li>
    <li class="uc-breadcrumb_item current bc-siga">Colas</li>
    </ol>

    <div class="d-flex align-items-center">
    <h1>Colas</h1>
    <span class="uc-heading-decoration"></span>
    </div>


    <div class="mt-2 bg-white p-2 border border-gray rounded-1">
    <div class="p-2 p-size--lg">
      Esta sección permite administrar la información base de las colas de usuarios del sistema, facilitando un
      registro
      claro y organizado.
    </div>




    <div class="p-2 mb-2 pl-0">
      <a href="{{ route('admin_queues') }}" class="uc-btn d-block fw-bold text-decoration-none">
      <i class="uc-icon icon-shape--rounded">arrow_back</i>
      Volver
      </a>
    </div>

    <hr class="uc-hr" />

    <div class="mx-2">
      <form name="actionForm" id="actionForm" method="POST" action="{{ route('admin_queues_users_add') }}">
      @csrf
      <input type="hidden" name="queue_id" value="{{ $queue->id }}" />
      <h4>Asignar Usuarios a Cola: {{ $queue->queue }}</h4>
      <div class="uc-text-divider divider-primary mt-16 mb-4"></div>
      <div class="p-size--sm p-text--condensed p-color--gray mb-4 mt-2">
        <span class="text-danger">*</span> Campo obligatorio.
      </div>
      <div class="uc-form-group">
        <label for="first_name">Usuario <span class="text-danger">*</span></label>
        <select id="user_id" name="user_id" class="select2 uc-input-style " required>
        <option value="">Seleccione un usuario</option>
        @foreach ($users as $key => $user)
        @if (!array_key_exists($key, $data))
        <option value="{{ $key }}">
        {{ $user }}
        </option>
        @endif
      @endforeach
        </select>
      </div>

      <div id="error-flash" style="display:none">
        <div class="uc-alert error mb-12" style="display:block">
        <div class="flex d-flex justify-content-between">
          <div class="uc-alert_content">
          <i class="uc-icon icon-size--sm">cancel</i> Error.
          </div>
          <div>
          <div class="uc-alert_close" data-id="error-flash-login" style="cursor: pointer;">
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
      <div class="uc-form-group mt-5">
        <button type="submit" class="uc-btn btn-secondary text-uppercase">
        Guardar
        <i class="uc-icon icon-shape--rounded ms-4">arrow_forward</i>
        </button>
      </div>
      </form>



      <div class="table-responsive">
      <table class="table table-bordered table-hover uc-table_datatable" id="data" style="width:100%">
        <thead>
        <tr>
          <th>Acción</th>
          <th>Usuario</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $key => $value)
      <tr>
        <td class="datatable_col_action">
        <a href="{{ route('admin_queues_users_delete', $key) }}" class="btnDelete" title="Eliminar"><i
        class="uc-icon">delete</i></a>
        </td>
        <td>{{ $value }}</td>
      </tr>
      @endforeach
        </tbody>
      </table>
      </div>
    </div>
    </div>
  </div>




  <script>
    $().ready(function () {
    $('#data').DataTable({
      pageLength: 10,
      lengthChange: false,
      processing: true,
      responsive: true,
      language: {
      info: '_START_ al _END_ de _TOTAL_ registros.',
      search: 'Búsqueda rápida',
      zeroRecords: '',
      paginate: {

      },
      infoEmpty: 'No hay datos para publicar.',
      infoFiltered: '(filtrado de _MAX_).',
      emptyTable: '',
      loadingRecords: ''
      },
      paging: true,
      scrollCollapse: false,
      ordering: false,
      columns: [{
      className: 'align_top dt-col-50px'
      },
      {
      className: 'align_top'
      }
      ]
    });
    $('#data tbody').on('click', '.btnDelete', function (e) {
      e.preventDefault();
      url = $(this).attr('href');
      var modal = `<div id="message" class="modal">
        <div class="modal-dialog">
          <div class="modal-content">
          <div class="uc-message warning siga-message">
            <a href="#" class="uc-message_close-button" data-bs-dismiss="modal"><i class="uc-icon">close</i></a>
            <div class="uc-message_body">
            <h2 class="mb-24">
              <i class="uc-icon warning-icon">warning</i> Eliminar Registro
            </h2>
            <p class="no-margin">
              Está seguro de eliminar el registro ?
            </p>
            </div>
          </div>
          <div class="modal-footer modal-footer-confirm">
            <button type="button" class="uc-btn btn-cta btn-cancel" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="uc-btn btn-cta" id="btnNext">Sí, Continuar</button>
          </div>
          </div>
        </div>
        </div>`;
      $('body').append(modal);
      $('#message').modal('show');
      $('#btnNext').click(function () {
      ajaxGet(url);
      });
    });
    });
  </script>

  {!! $ajaxAdd !!}
  {!! $ajaxGet !!}

@endsection