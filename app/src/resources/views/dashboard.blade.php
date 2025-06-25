@extends('layout.main')

@section('content')
  <ol class="uc-breadcrumb">
    <li class="uc-breadcrumb_item">
      <a href="/"><i class="uc-icon">home</i></a>
      <i class="uc-icon">keyboard_arrow_right</i>
    </li>
    <li class="uc-breadcrumb_item current">Mis ticket abiertos</li>
  </ol>
  <div class="row mt-32 container-fluid">
    <div class="col-12">

      <div class="d-flex align-items-center mb-3">
        <h1>Mis Tickets Abiertos</h1>
        <span class="uc-heading-decoration"></span>
      </div>
      <div class="table-responsive">
        <table class="table table-hover" id="data" style="width:100% !important">
          <thead class="bg-uc-blue-1">
            <tr>
              <th>ID</th>
              <th>Cola</th>
              <th>Estado</th>
              <th>Solicitante</th>
              <th>Asunto</th>
              <th>Fecha<br />Solicitud</th>
              <th>Fecha<br />Actualización</th>
            </tr>
          </thead>
          <tbody>
            <tr data-id="/agent/request/2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-info text-dark text-uppercase">Asignado</span>
              </td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>

            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-primary">En progreso</span></td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>
            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-primary">Asignado</span></td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>
            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-primary">En progreso</span></td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>

            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-info text-dark text-uppercase">Asignado</span>
              </td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>

            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-primary">En progreso</span></td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>
            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-primary">Asignado</span></td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>
            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-primary">En progreso</span></td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>
            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-info text-dark text-uppercase">Asignado</span>
              </td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>

            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-primary">En progreso</span></td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>
            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-primary">Asignado</span></td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>
            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-primary">En progreso</span></td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>
            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-info text-dark text-uppercase">Asignado</span>
              </td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>

            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-primary">En progreso</span></td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>
            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-primary">Asignado</span></td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>
            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-primary">En progreso</span></td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>
            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-info text-dark text-uppercase">Asignado</span>
              </td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>

            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-primary">En progreso</span></td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>
            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-primary">Asignado</span></td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>
            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-primary">En progreso</span></td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>
            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-info text-dark text-uppercase">Asignado</span>
              </td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>

            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-primary">En progreso</span></td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>
            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-primary">Asignado</span></td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>
            <tr data-id="2">
              <td class="align-top" style="width: 80px">ID</td>
              <td class="align-top">Cola1</td>
              <td class="align-top"><span class="badge bg-primary">En progreso</span></td>
              <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
              <td class="align-top">Este es el asunto del mensaje</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
              <td class="align-top" style="width: 100px">2025-01-01<br />00:00</td>
            </tr>
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
            className: 'align-top dt-col-80px'
          },
          {
            className: 'align-top dt-col-100px'
          },
          {
            className: 'align-top dt-col-80px'
          },
          {
            className: 'align-top'
          },
          {
            className: 'align-top'
          },
          {
            className: 'align-top dt-col-100px'
          },
          {
            className: 'align-top dt-col-80px'
          },
        ]
      });
      $('#data tbody').on('click', 'tr', function() {
        const id = $(this).data('id');
        window.location.href = `${id}`;
      });
    });
  </script>
@endsection
