@extends('layout.main')

@section('content')
  <div class="container-fluid bg-white p-0 m-0">
    <ol class="uc-breadcrumb">
    <li class="uc-breadcrumb_item">
      <a href="/">Inicio</a>
      <i class="uc-icon">keyboard_arrow_right</i>
    </li>
    <li class="uc-breadcrumb_item current">Ticket: SUBJECT</li>
    </ol>
  </div>
  <div class="clearfix"></div>



  <div class="row mt-3">
    <div class="col-12 col-lg-8">

    </div>
    <div class="col-12 col-lg-4">
    <div class="pt-3">
      <label class="form-label">Nro. Ticket</label>
      <input type="email" class="uc-input-style" id="inputEmail4">
    </div>
    <div class="pt-3">
      <label class="form-label">Fecha</label>
      <input type="password" class="uc-input-style" id="inputPassword4">
    </div>
    <div class="pt-3">
      <label class="form-label">Estado</label>
      <select name="status" id="status" class="select2 uc-input-style">
        <option value="" selected="selected"></selected>
      </select>
    </div>




    </div>
  </div>


@endsection