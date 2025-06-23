@extends('errors.main')

@section('title', '401 Página no encontrada')

@section('content')
  <div>
    <div class="container mt-60">
      <div class="row justify-content-center">
        <div class="col-lg-9">
          <div class="uc-card card-bg--gray" id="error-404">
            <div class="uc-card_body--xl">
              <div class="uc-subtitle">Error 404</div>
              <div class="h1 mb-24">Lo sentimos, no pudimos llevarte a la página que querías.</div>
              <p>Al parecer, la pagina a la cual intentas acceder, no existe o no se encuentra disponible</p>
              <a href="/" class="uc-link text-weight--medium">
                Volver a la página de inicio <i class="uc-icon">keyboard_arrow_right</i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
