<!DOCTYPE html>
<html lang="es">

<head>
  <!-- End Google Tag Manager -->
  <meta charset="utf-8" />
  <meta name="robots" content="noindex, nofollow">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description"
    content="El Sistema Integrado de Gestión Académica (SiGA) moderniza y articula los procesos académicos en la Universidad, promoviendo eficiencia, trazabilidad y calidad en la atención estudiantil.">
  <meta name="author" content="DTFD UC" />
  <link rel="icon" type="image/png" href="https://web-uc-prod.s3.amazonaws.com/uc-cl/dist/images/favicon.png" />
  <title>@if(isset($title)) {{ $title }} @endif</title>
  <!--  -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto" />

  <!-- #Jquery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"
    integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>



  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>



  <!-- #Select 2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"
    integrity="sha384-d3UHjPdzJkZuk5H3qKYMLRyWLAQBJbby2yr2Q58hXXtAGF8RSNO9jpLDlKKPv5v3"
    crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">

  <script src="/assets/js/jquery.form.js"></script>



  <link rel="stylesheet" href="https://kit-digital-uc-prod.s3.amazonaws.com/uc-kitdigital/css/uc-kitdigital.css" />
  <script src="https://kit-digital-uc-prod.s3.amazonaws.com/uc-kitdigital/js/uc-kitdigital.js"></script>





  <!--  -->
  <link href="/assets/css/loading.css" rel="stylesheet" />
  <link href="/assets/css/layout.css" rel="stylesheet" />
  <link href="/assets/css/app.css" rel="stylesheet" />
  <script src="/assets/js/app.js"></script>

</head>

<body>
  <h1 class="uc-sr-only">[Mesa de Serivios Técnologicos DTFD]</h1>
  <!-- header -->
  @include('layout.header')

  <!-- main -->
  <div class="main-content">
    <aside class="aside d-none d-lg-block col-lg-3 bg-white p-0 ms-3">
      @include('layout.menu')
    </aside>

    <div class="main-column bg-white">
      <div class="row">
        <div class="col-12 main-dashboard">
          @yield('content')
        </div>
      </div>
    </div>

  </div>


  <!-- footer -->
  @include('layout.footer')


  @if(Session::has('message'))
    <div id="toast" role="alert" aria-live="assertive" aria-atomic="true"
    class="toast position-fixed top-0 start-50 translate-middle-x p-3 bg-white p-0 m-3" style="z-index:2000" ;>
    <div class="uc-alert success">
      <div class="uc-alert_content">
      <i class="uc-icon icon-size--sm">check_circle</i>
      <span class="p p-size--sm bold ml-8">{{Session::get('message')}}</span>
      </div>
      <div class="uc-alert_close">
      <button type="button" class="btn icon-size--sm" data-bs-dismiss="toast" aria-label="Close"><i
        class="uc-icon icon-size--sm">close</i></button>
      </div>
    </div>
    </div>
    <script>
    const toastEl = document.getElementById('toast');
    console.log(toastEl);
    const toast = bootstrap.Toast.getOrCreateInstance(toastEl);
    toast.show();
    </script>
    @php
    Session::forget('message');
    @endphp
  @endif


  <div id="loading-super"></div>
  <div id="loading-progress">
    <div id="capaprogress" class="cprogress"></div>
  </div>
</body>

</html>