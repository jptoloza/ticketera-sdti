@extends('layout.main_admin')

@section('content')
    <div class="pt-2">
        <ol class="uc-breadcrumb">
            <li class="uc-breadcrumb_item">
                <a href="/" class="mr-0"><i class="uc-icon">home</i></a>
                <i class="uc-icon">keyboard_arrow_right</i>
            </li>
            <li class="uc-breadcrumb_item current">Herramientas Administrativas</li>
        </ol>

        <div class="d-flex align-items-center">
            <h1>Herramientas Administrativas</h1>
            <span class="uc-heading-decoration"></span>
        </div>

        <div class="mt-2 bg-white p-2 border border-gray rounded-1">

            <div class="p-2 p-size--lg">
                En esta sección de <b>Herramientas Administrativas</b>, es posible gestionar usuarios, asignar permisos y
                configurar diversos aspectos del sistema.
            </div>

            <div class="uc-table-list p-2">
                <ul class="uc-table-list_content" style="border-top:0 !important;padding-left:0 !important">
                    <li>
                        <a href="{{ route('admin_users') }}" class="uc-btn btn-listed">
                            Usuarios
                            <i class="uc-icon icon-small">chevron_right</i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin_roles') }}" class="uc-btn btn-listed">
                            Roles
                            <i class="uc-icon icon-small">chevron_right</i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin_queues') }}" class="uc-btn btn-listed">
                            Colas
                            <i class="uc-icon icon-small">chevron_right</i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin_status') }}" class="uc-btn btn-listed">
                            Estados
                            <i class="uc-icon icon-small">chevron_right</i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
