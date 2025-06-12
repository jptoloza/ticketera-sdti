@extends('layout.main')

@section('content')



    <div class="container-fluid bg-white p-0 m-0">
        <ol class="uc-breadcrumb">
            <li class="uc-breadcrumb_item">
                <a href="/">Inicio</a>
                <i class="uc-icon">keyboard_arrow_right</i>
            </li>
            <li class="uc-breadcrumb_item current">Dashboard</li>
        </ol>
    </div>
    <div class="clearfix"></div>



    <div class="container-fluid bg-white p-0 m-0">


        <h1>Mis tickets abiertos</h1>


        <div class="d-flex justify-content-center align-items-center">
            <button type="button" class="uc-btn btn-primary" data-mtarget="mddalSearch">
                <i class="uc-icon icon-size--sm">search</i> Buscar
            </button>
        </div>

        <div class="clearfix"></div>



        <div class="row mt-4">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-hover uc-table_datatable" id="data">
                        <thead>
                            <tr>
                                <th class="align-top" style="width: 80px">ID</th>
                                <th class="align-top">Cola</th>
                                <th class="align-top">Estado</th>
                                <th class="align-top">Solicitante</th>
                                <th class="align-top">Asunto</th>
                                <th class="align-top" style="width: 100px">Fecha<br />Solicitud</th>
                                <th class="align-top" style="width: 100px">Fecha<br />Actualización</th>
                            </tr>
                        </thead>
                        

                        <tbody>
                            <tr>
                                <td class="align-top" style="width: 80px">ID</td>
                                <td class="align-top">Cola1</td>
                                <td class="align-top"><span class="badge rounded-pill bg-primary">Asignado</span></td>
                                <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
                                <td class="align-top">Este es el asunto del mensaje</td>
                                <td class="align-top" style="width: 100px">2025-01-01<br/>00:00</td>
                                <td class="align-top" style="width: 100px">2025-01-01<br/>00:00</td>
                            </tr>

                            <tr>
                                <td class="align-top" style="width: 80px">ID</td>
                                <td class="align-top">Cola1</td>
                                <td class="align-top"><span class="badge rounded-pill bg-primary">En progreso</span></td>
                                <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
                                <td class="align-top">Este es el asunto del mensaje</td>
                                <td class="align-top" style="width: 100px">2025-01-01<br/>00:00</td>
                                <td class="align-top" style="width: 100px">2025-01-01<br/>00:00</td>
                            </tr>
                            <tr>
                                <td class="align-top" style="width: 80px">ID</td>
                                <td class="align-top">Cola1</td>
                                <td class="align-top"><span class="badge rounded-pill bg-primary">Asignado</span></td>
                                <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
                                <td class="align-top">Este es el asunto del mensaje</td>
                                <td class="align-top" style="width: 100px">2025-01-01<br/>00:00</td>
                                <td class="align-top" style="width: 100px">2025-01-01<br/>00:00</td>
                            </tr>
                            <tr>
                                <td class="align-top" style="width: 80px">ID</td>
                                <td class="align-top">Cola1</td>
                                <td class="align-top"><span class="badge rounded-pill bg-primary">En progreso</span></td>
                                <td class="align-top">Juan Pere< (juanperes@uc.cl)</td>
                                <td class="align-top">Este es el asunto del mensaje</td>
                                <td class="align-top" style="width: 100px">2025-01-01<br/>00:00</td>
                                <td class="align-top" style="width: 100px">2025-01-01<br/>00:00</td>
                            </tr>


                        </tbody>


                    </table>
                </div>
            </div>
        </div>



    </div>

















    <div data-modal="mddalSearch" class="uc-modal" open>
        <div class="uc-modal_content uc-message info mb-32">
            <button class="uc-message_close-button" data-mclosed>
                <i class="uc-icon">close</i>
            </button>
            <div class="uc-message_body">
                <h2 class="mb-24">
                    <i class="uc-icon warning-icon">info</i> Buscar
                </h2>
                <div class="container mt-4" style="">
                    <div class="row">
                        <div class="col-12">
                            <div class="has-search position-relative">
                                <span class="uc-icon form-control-feedback"
                                    style="display:inline-block !important">search</span>
                                <input type="text" class="form-control" placeholder="Buscar..."
                                    style="display:inline-block !important;max-width:500px">
                                <button type="submit" class="uc-btn btn-cta"
                                    style="display:inline-block !important">Submit</button>
                            </div>
                        </div>
                    </div>
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
                    infoEmpty: 'No hay datos para publicar.',
                    infoFiltered: '(filtrado de _MAX_).',
                    emptyTable: '',
                    loadingRecords: ''
                },
                paging: true,
                scrollCollapse: false,
                ordering: false,
            });
        });
    </script>




@endsection