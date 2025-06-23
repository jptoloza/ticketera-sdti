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
            <li class="uc-breadcrumb_item current bc-siga">Estados</li>
        </ol>

        <div class="d-flex align-items-center">
            <h1>Estados</h1>
            <span class="uc-heading-decoration"></span>
        </div>


        <div class="mt-2 bg-white p-2 border border-gray rounded-1">
            <div class="p-2 p-size--lg">
                Esta sección permite administrar la información base de los estados de los tickets del sistema, facilitando un
                registro claro y organizado.
            </div>




            <div class="p-2 mb-2 pl-0">
                <a href="{{ route('admin_status') }}" class="uc-btn d-block fw-bold text-decoration-none">
                    <i class="uc-icon icon-shape--rounded">arrow_back</i>
                    Volver
                </a>
            </div>

            <hr class="uc-hr" />

            <div class="mx-2">
                <form name="actionForm" id="actionForm" method="POST" action="{{ route('admin_status_add') }}">
                    @csrf
                    <h4>Nuevo Estado</h4>
                    <div class="uc-text-divider divider-primary mt-16 mb-4"></div>
                    <div class="p-size--sm p-text--condensed p-color--gray mb-4 mt-2">
                        <span class="text-danger">*</span> Campo obligatorio.
                    </div>
                    <div class="uc-form-group">
                        <label for="first_name">Estado <span class="text-danger">*</span></label>
                        <input id="name" name="name" type="text" class="uc-input-style" placeholder="Ingrese nombre estado"
                            required />
                    </div>
                    <div class="uc-form-group">
                        <label for="first_name">Global Key <span class="text-danger">*</span></label>
                        <input id="global_key" name="global_key" type="text" class="uc-input-style" placeholder="Ingrese global key"
                            required />
                    </div>
                    <div class="uc-form-group">
                        <div>
                            <label for="active">Estado Activo <span class="text-danger">*</span></label>
                        </div>
                        <div>
                            <input type="radio" name="active" value="1" />
                            <label class="fw-normal">Si</label>
                        </div>
                        <div>
                            <input type="radio" name="active" value="0" />
                            <label class="fw-normal">No</label>
                        </div>
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
            </div>
        </div>
    </div>

    {!! $ajaxAdd !!}
@endsection