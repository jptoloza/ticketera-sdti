@extends('layout.main')

@section('content')
  <ol class="uc-breadcrumb">
    <li class="uc-breadcrumb_item">
      <a href="/"><i class="uc-icon">home</i></a>
      <i class="uc-icon">keyboard_arrow_right</i>
    </li>
    <li class="uc-breadcrumb_item current">Mis tickets</li>
  </ol>


  <div class="row mt-32 container-fluid">
    <div class="col-12">
      <div class="d-flex align-items-center mb-3">
        <h1>Mis Tickets</h1>
        <span class="uc-heading-decoration"></span>
      </div>


      <div class="table-responsive">
        <table class="table table-striped uc-datatable" id="data" style="width:100% !important">
          <thead class="bg-uc-blue-1">
            <tr>
              <th>#ID</th>
              <th>Equipo</th>
              <th>Estado</th>
              <th>Solicitante</th>
              <th>Asunto</th>
              <th>Fecha<br />Solicitud</th>
              <th>Fecha<br />Actualización</th>
            </tr>
          </thead>
          <tbody>

            @foreach ($tickets as $ticket)
              <tr data-id="{{ route('tickets_view', ['id' => $ticket->id]) }}">
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->queue }}</td>
                @php
                  $status_color = '';
                  $status_bg = '';

                  switch($ticket->global_key):
                    case 'STATUS_OPEN':
                      $status_color = 'bg-uc-feedback-blue';
                      $status_bg = 'text-white';
                      
                    break;
                    case 'STATUS_CLOSED':
                      $status_color = 'bg-uc-feedback-green';
                      $status_bg = 'text-white';
                    break;
                    case 'STATUS_CANCELLED':
                      $status_color = 'bg-uc-feedback-red';
                      $status_bg = 'text-white';
                    break;
                    default:
                      $status_color = 'bg-uc-feedback-yellow';
                      $status_bg = 'text-white';
                    break;
                endswitch;
                @endphp
                <td><span class="badge {{ $status_color }} {{ $status_bg }} text-white text-uppercase">{{ $ticket->status }}</span></td>
                <td>{{ App\Http\Helpers\UtilHelper::ucTexto($ticket->name) }}<br/>({{ $ticket->email }})</td>
                <td>{{ $ticket->subject }}</td>
                <td>{{ $ticket->created_at }}</td>
                <td>{{ $ticket->updated_at }}</td>
              </tr>
            @endforeach

          </tbody>
        </table>
      </div>


    </div>
  </div>






  <script>
    $().ready(function() {

      $('#data').DataTable({
        pageLength: 10,
        lengthChange: false,
        processing: true,
        responsive: false,
        language: {
          info: '_START_ al _END_ de _TOTAL_ registros.',
          search: 'Búsqueda rápida',
          zeroRecords: '',
          paginate: {},
          infoEmpty: 'No hay datos para publicar.',
          infoFiltered: '(filtrado de _MAX_).',
          emptyTable: '',
          loadingRecords: '',
          paginate: {
            previous: '<span class="uc-icon">navigate_before</span>',
            next: '<span class="uc-icon">keyboard_arrow_right</span>'
          }
        },
        paging: true,
        scrollX: true,
        ordering: false,
        columns: [{
            className: 'text-left align-top dt-col-50px'
          },
          {
            className: 'align-top text-center dt-col-100px'
          },
          {
            className: 'align-top text-center dt-col-80px'
          },
          {
            className: 'align-top dt-col-200px'
          },
          {
            className: 'align-top'
          },
          {
            className: 'align-top text-center dt-col-100px'
          },
          {
            className: 'align-top text-center dt-col-80px'
          },
        ],
        createdRow: function(row, data, dataIndex) {
          //row.cells[0].classList.add('text-right');
          //console.log(row.cells[0].classList);
        }
      });

      $('#data tbody').on('click', 'tr', function() {
        const url = $(this).data('id');
        window.location.href = `${url}`;
      });

    });
  </script>
@endsection
