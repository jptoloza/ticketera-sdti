@extends('layout.main')

@section('content')
  <ol class="uc-breadcrumb">
    <li class="uc-breadcrumb_item">
      <a href="/"><i class="uc-icon">home</i></a>
      <i class="uc-icon">keyboard_arrow_right</i>
    </li>
    <li class="uc-breadcrumb_item current">Perfil de Usuario</li>
  </ol>


  <div class="row mt-32 container-fluid">
    <div class="col-12">
      <div class="d-flex align-items-center mb-3">
        <h1>Perfil de Usuario</h1>
        <span class="uc-heading-decoration"></span>
      </div>



      <form name="actionForm" id="actionForm" method="POST" action="{{ route('user_update') }}">
        @csrf
        <div class="p-size--sm p-text--condensed p-color--gray mb-4 mt-2">
          <span class="text-danger">*</span> Campo obligatorio.
        </div>
        <div class="uc-form-group">
          <label for="first_name">Nombre <span class="text-danger">*</span></label>
          <input id="name" name="name" type="text" class="uc-input-style" placeholder="Ingrese nombre" required
            value="{{ $user->name }}" />
        </div>
        <div class="uc-form-group">
          <label for="run">R.U.T. <span class="text-danger">*</span></label>
          <input id="rut" name="rut" type="text" class="uc-input-style" placeholder="Ingrese RUT" required
            value="{{ $user->rut }}" />
        </div>
        <div class="uc-form-group">
          <label for="email">Email <span class="text-danger">*</span></label>
          <input type="email" class="uc-input-style" placeholder="Ingrese email" value="{{ $user->email }}" disabled />
          <input id="email" name="email" type="hidden" required value="{{ $user->email }}" />
        </div>
        <div class="uc-form-group">
          <label for="usuario">Usuario UC <span class="text-danger">*</span></label>
          <input type="text" class="uc-input-style" placeholder="Ingrese usuario" value="{{ $user->login }}"
            disabled />
          <input id="login" name="login" type="hidden" required value="{{ $user->login }}" />
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
            <option value="other">Otra</option>
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










  {!! $ajaxUpdate !!}
@endsection
