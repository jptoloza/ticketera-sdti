<!DOCTYPE html>
<html lang="es">

  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" type="image/png" href="/assets/img/favicon.png" />
    <title>@yield('title', 'Error')</title>
    <!--  -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto" />
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
    <!--  -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"
      integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://kit-digital-uc-prod.s3.amazonaws.com/uc-kitdigital/css/uc-kitdigital.css" />
    <script src="https://kit-digital-uc-prod.s3.amazonaws.com/uc-kitdigital/js/uc-kitdigital.js"></script>
    <!--  -->
    <link href="/assets/css/loading.css" rel="stylesheet" />
    <link href="/assets/css/layout.css" rel="stylesheet" />
    <link href="/assets/css/app.css" rel="stylesheet" />
    <script src="/assets/js/app.js"></script>
  </head>

  <body>
    <!-- navbar desktop -->
    <nav class="navbar navbar-expand-lg bg-uc-blue-1 sticky-top">
      <div class="container-fluid mx-0">
        <a class="navbar-brand" href="/">
          <img src="https://kit-digital-uc-prod.s3.amazonaws.com/assets/uc_sm.svg" alt="Logo UC" class="img-fluid"
            style="height: 30px;">
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item text-white" style="padding-left:40px; font-size: 2em !important;">
              Mesa de Servicios SDTI
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- end navbar desktop -->
    <!-- navbar mobile -->
    <nav class="navbar d-lg-none d-xl-none d-xxl-none bg-white">
      <div class="container-fluid mx-0">
        <div style="justify-content: start;">

          <div class="navbar-brand">
            <a class="color-uc-blue-1 d-inline-block" style="text-decoration:none" href="/">
              <span style="font-size:1.3rem">Mesa de Servicios SDTI</span>
            </a>
          </div>
        </div>
      </div>
    </nav>
    <!-- end navbar mobile -->
    <div class="clearfix"></div>
    <!-- main -->
    <div class="container-fluid h-100">
      <div class="row h-100">
        <div class="col-12 mt-2 pb-2">
          @yield('content')
        </div>
      </div>
    </div>

  </body>

</html>
