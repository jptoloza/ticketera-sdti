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

      <div class="p-2 mb-2 pl-0">
        <a href="{{ route('admin_users') }}" class="uc-btn d-block fw-bold text-decoration-none">
          <i class="uc-icon icon-shape--rounded">arrow_back</i>
          Volver
        </a>
      </div>

      <hr class="uc-hr" />

      <div class="mx-2">
        <form name="actionForm" id="actionForm" method="POST" action="{{ route('admin_users_edit') }}">
          @csrf
          <input type="hidden" name="id" value="{{ $user->id }}" />
          <h4>Editar Usuario</h4>
          <div class="uc-text-divider divider-primary mt-16 mb-4"></div>
          <div class="p-size--sm p-text--condensed p-color--gray mb-4 mt-2">
            <span class="text-danger">*</span> Campo obligatorio.
          </div>
          <div class="uc-form-group">
            <label for="first_name">Nombre <span class="text-danger">*</span></label>
            <input id="name" name="name" type="text" class="uc-input-style" placeholder="Ingrese nombre"
              required value="{{ $user->name }}" />
          </div>
          <div class="uc-form-group">
            <label for="run">R.U.T. <span class="text-danger">*</span></label>
            <input id="rut" name="rut" type="text" class="uc-input-style" placeholder="Ingrese RUT" required
              value="{{ $user->rut }}" />
          </div>
          <div class="uc-form-group">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input id="email" name="email" type="email" class="uc-input-style" placeholder="Ingrese email"
              required value="{{ $user->email }}" />
          </div>
          <div class="uc-form-group">
            <label for="usuario">Usuario UC <span class="text-danger">*</span></label>
            <input id="login" name="login" type="text" class="uc-input-style" placeholder="Ingrese usuario"
              required value="{{ $user->login }}" />
          </div>

          <div class="uc-form-group mb-3">
            <label>Unidad <span class="text-danger">*</span></label>
            <select name="unit" id="unit" class="uc-input-style select2" required>
              <option value="" selected="">Seleccionar</option>
              @foreach ($units as $unit)
                <option value="{{ $unit->id }}" @if ($user->unit_id == $unit->id) selected="selected" @endif>
                  {{ $unit->unit }}
                </option>
              @endforeach
            </select>
          </div>


          @php
            $array_perfil = explode(',', $user->profile);
          @endphp
          <div class="uc-form-group">
            <div>
              <label for="active">Perfil <span class="text-danger">*</span></label>
            </div>
            <div class="uc-form-check">
              <input id="checkbox-1" name="profile[]" type="checkbox" value="Académico"
                @if (in_array('Académico', $array_perfil)) checked @endif />
              <label for="checkbox-1">Académico</label>
              <input id="checkbox-2" name="profile[]" type="checkbox" value="Estudiante"
                @if (in_array('Estudiante', $array_perfil)) checked @endif />
              <label for="checkbox-2">Estudiante</label>
              <input id="checkbox-3" name="profile[]" type="checkbox" value="Funcionario"
                @if (in_array('Funcionario', $array_perfil)) checked @endif />
              <label for="checkbox-3">Funcionario</label>
              <input id="checkbox-4" name="profile[]" type="checkbox" value="Otro"
                @if (in_array('Otro', $array_perfil)) checked @endif />
              <label for="checkbox-4">Otro</label>
            </div>
          </div>

          <div class="uc-form-group">
            <div>
              <label for="active">Usuario Activo <span class="text-danger">*</span></label>
            </div>
            <div>
              <input type="radio" name="active" value="1" @if ($user->active) checked @endif />
              <label class="fw-normal">Si</label>
            </div>
            <div>
              <input type="radio" name="active" value="0" @if (!$user->active) checked @endif />
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


  {!! $ajaxUpdate !!}
@endsection
