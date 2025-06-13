<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout Bootstrap 5</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Sistema de ticketera para la SDTI.">
    <meta name="author" content="SDTI - DTFD UC" />
    <link rel="icon" type="image/png" href="https://web-uc-prod.s3.amazonaws.com/uc-cl/dist/images/favicon.png" />
    <title>@if(isset($title)) {{ $title }} @endif</title>



    <!-- #Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto" />

    <!-- #Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"
        integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
    <script src="/assets/js/jquery.form.js"></script>

    <!-- #Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>

    <!-- #DataTables JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <!-- #Select 2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"
        integrity="sha384-d3UHjPdzJkZuk5H3qKYMLRyWLAQBJbby2yr2Q58hXXtAGF8RSNO9jpLDlKKPv5v3"
        crossorigin="anonymous"></script>

    <!-- #Kit Digital UC -->
    <link rel="stylesheet" href="https://kit-digital-uc-prod.s3.amazonaws.com/uc-kitdigital/css/uc-kitdigital.css" />
    <script src="https://kit-digital-uc-prod.s3.amazonaws.com/uc-kitdigital/js/uc-kitdigital.js"></script>

    <!-- #Css style -->
    <link href="/assets/css/loading.css" rel="stylesheet" />
    <link href="/assets/css/layout.css" rel="stylesheet" />
    <link href="/assets/css/app.css" rel="stylesheet" />
    <script src="/assets/js/app.js"></script>


</head>

<body>
    <!-- Header -->
    <h1 class="uc-sr-only">[Mesa de Serivios Técnologicos DTFD]</h1>
    @include('layout.header')

    

    <!-- Contenido Principal -->
    <div class="content-wrapper">
        <!-- Aside -->
        <aside class="aside d-none d-lg-block col-lg-2 bg-white p-0 m-3 me-0">
            @include('layout.menu')
        </aside>

        <!-- Contenido Central -->
        <main class="main-content bg-white p-0 m-3">
            <div class="container-fluid p-3">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Footer -->
     @include('layout.footer')


</body>

</html>