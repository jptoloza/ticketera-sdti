@extends('layout.mainAdmin')

@section('content')
    <div class="mt-2 p-2">
        <ol class="uc-breadcrumb">
            <li class="uc-breadcrumb_item">
                <a href="/" class="mr-0"><i class="uc-icon">home</i></a>
                <i class="uc-icon">keyboard_arrow_right</i>
            </li>
            <li class="uc-breadcrumb_item">
                <a href="/admin">Herramientas Administrativas</a>
                <i class="uc-icon">keyboard_arrow_right</i>
            </li>
            <li class="uc-breadcrumb_item current bc-siga">Usuarios</li>
        </ol>

        <div class="d-flex align-items-center">
            <h1>Usuarios</h1>
            <span class="uc-heading-decoration"></span>
        </div>


        <div class="mt-2 bg-white p-2 border border-gray rounded-1">
            <div class="p-2 p-size--lg">
                Esta sección permite administrar la información base de los usuarios en el sistema, facilitando un registro
                claro y organizado.
            </div>

            <div class="p-2 mt-4 mb-0">
                <a href="/admin/users/add" class="uc-btn btn-primary btn-siga">
                    <i class="uc-icon">add_circle</i>
                    Nuevo Usuario
                </a>
            </div>

            <div class="table-responsive-md">
                <table class="table table-bordered table-hover uc-table_datatable" id="data" style="width:100%">
                    <thead>
                        <tr>
                            <th>Acción</th>
                            <th>Activo</th>
                            <th>Usuario</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
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
                responsive: true,
                ajax: "{{ route('admin-users-get') }}",
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
                        className: 'datatable_col_action'
                    },
                    {
                        className: 'datatable_col_active'
                    },
                    {
                        className: 'datatable_col_active'
                    },
                    {
                        className: 'datatable_col_w150'
                    },
                ]
            });
        });
    </script>
    {!! $ajaxGet !!}
@endsection
