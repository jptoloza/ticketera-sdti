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
            <li class="uc-breadcrumb_item current bc-siga">Roles</li>
        </ol>

        <div class="d-flex align-items-center">
            <h1>Roles</h1>
            <span class="uc-heading-decoration"></span>
        </div>


        <div class="mt-2 bg-white p-2 border border-gray rounded-1">
            <div class="p-2 p-size--lg">
                En esta sección podrá gestionar y asignar los roles del sistema.
            </div>

            <div class="p-2 mt-4 mb-0">
                <a href="{{ route('admin_roles_add') }}" class="uc-btn btn-primary btn-inline">
                    <i class="uc-icon">add_circle</i>
                    Nuevo Rol
                </a>
            </div>

            <div class="mx-2">
                <div class="table-responsive-md">
                    <table class="table table-bordered table-hover uc-table_datatable" id="data" style="width:100%">
                        <thead>
                            <tr>
                                <th>Acción</th>
                                <th>Activo</th>
                                <th>Global Key</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
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
                ajax: "{{ route('admin_roles_get') }}",
                language: {
                    info: '_START_ al _END_ de _TOTAL_ registros.',
                    search: 'Búsqueda rápida',
                    zeroRecords: '',
                    infoEmpty: 'No hay datos para publicar.',
                    infoFiltered: '(filtrado de _MAX_).',
                    emptyTable: '',
                    loadingRecords: '',
                },
                paging: true,
                scrollCollapse: false,
                ordering: false,
                columns: [{
                    className: 'align-top dt-col-80px'
                },
                {
                    className: 'align-top dt-col-50px'
                },
                {
                    className: 'align-top dt-col-50px'
                },

                {
                    className: 'align-top'
                },
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
                            <i class="uc-icon warning-icon uc-icon-modal">warning</i> Eliminar Registro
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
    {!! $ajaxGet !!}
@endsection