<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="icon" type="image/png" href="https://web-uc-prod.s3.amazonaws.com/uc-cl/dist/images/favicon.png" />
    <title>Mesa de Servicio Tecnológicos SDTI/DTFD</title>

    <script src="https://kit-digital-uc-prod.s3.amazonaws.com/uc-kitdigital/js/uc-kitdigital.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"
        integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.1.0/datatables.min.js"
        integrity="sha384-p6KQm0AS28QqD9EpjG8N8PtkleZsESjiBet1HQ7pDp2wWKLJdSEhzQuhFhWIAvfN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.0/js/dataTables.bootstrap5.js"
        integrity="sha384-ytWx70TEZNWKvhA4mV4nQPHLRzPJeBf42voNnsXOSCv7ZxlBWQIceO1G8bJirjxl"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"
        integrity="sha384-d3UHjPdzJkZuk5H3qKYMLRyWLAQBJbby2yr2Q58hXXtAGF8RSNO9jpLDlKKPv5v3"
        crossorigin="anonymous"></script>
    <script src="/assets/js/jquery.form.js"></script>

    <!--  -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.0/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://kit-digital-uc-prod.s3.amazonaws.com/uc-kitdigital/css/uc-kitdigital.css" />

    <!-- #Css style -->
    <link href="/assets/css/loading.css" rel="stylesheet" />


</head>

<body>

    <header class="uc-header">
        <div id="uc-global-topbar"></div>
        <nav class="uc-navbar">
            <!-- Menú para versión Escritorio -->
            <div class="container d-none d-lg-block">
                <div class="row">
                    <div class="col-lg-3 col-xl-2">
                        <img src="https://kit-digital-uc-prod.s3.amazonaws.com/assets/logo-uc-azul.svg"
                            alt="Pontificia Universidad Católica de Chile" class="img-fluid" />
                    </div>
                    <div class="col-lg-8 col-xl-9 pl-60">
                        <div class="h2 text-font--serif text-color--blue mt-24">Mesa de Servicios SDTI
                        </div>
                        <div class="text-color--gray p-size--lg">
                            Dirección de Transformación Digital
                        </div>
                    </div>
                </div>
            </div>
            <!-- Menú para versión Móvil -->
            <div class="uc-navbar_mobile d-block d-lg-none">
                <div class="uc-navbar_mobile-bar navbar-brand">
                    <div class="uc-navbar_mobile-logo navbar-light">
                        <div class="h2 text-font--serif text-color--blue">Mesa de Servicios SDTI</div>
                    </div>
                </div>
            </div>
        </nav>
    </header>




    <div>
        <div class="container mt-60 mb-60">
            <div class="d-flex justify-content-center align-items-center mt-16 mb-32">
                <div class="text-center border p-4 rounded shadow" style="min-width: 300px;">

                    <div class="heading-container mb-32">
                        <h1>Inicio</h1>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="cuentaUc" class="form-label">Ingrese con su cuenta UC para iniciar sesión o
                            registrarse</label>
                        <!--                        <input type="text" class="form-control" id="cuentaUc" placeholder="usuario sin @uc.cl"
                            required>-->
                    </div>

                    <a href="/cas/login" class="uc-btn btn-secondary text-center w-100">
                        Iniciar Sesión SSO CAS UC
                        <i class="uc-icon icon-shape--rounded">arrow_forward</i>
                    </a>

                    <a href="javascript:void(0)" class="mt-2 uc-btn btn-secondary text-center w-100"
                        data-bs-toggle="modal" data-bs-target="#login-signin">
                        Iniciar Sesión con Email
                        <i class="uc-icon icon-shape--rounded">arrow_forward</i>
                    </a>

                </div>
            </div>



        </div>
    </div>


    <footer class="uc-footer">
        <div class="container pb-48">
            <div class="row">
                <div class="col-7 col-md-3 col-xl-2 mb-32">
                    <a href="/">
                        <img src="https://kit-digital-uc-prod.s3.amazonaws.com/assets/logo-uc-blanco.svg"
                            alt="Pontificia Universidad Católica de Chile" class="img-fluid" />
                    </a>
                </div>
                <div class="col-lg-8 offset-lg-1">
                    <div class="h2 color-white text-font--serif mt-28">
                        Mesa de Servicios SDTI
                    </div>
                </div>
            </div>
        </div>
        <div id="uc-global-footer"></div>
    </footer>

    <div class="uc-dev-footer">
        <div class="container">
            <ul class="uc-footer-dev_content">
                <li>
                    Diseño y Desarrollo:
                    <a href="https://transformaciondigital.uc.cl/direccion/" target="_blank">SDTI - DTFD</a>
                </li>
                <li>
                    Sitio administrado por:
                    <a href="https://transformaciondigital.uc.cl/direccion/" target="_blank">SDTI - DTFD</a>
                </li>
                <li>
                    Utilizando el
                    <a href="https://kitdigital.uc.cl/">Kit Digital UC</a>
                </li>
            </ul>
        </div>
    </div>


    <div id="login-signin" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="actionForm" id="actionForm" action="{{ route('login_email') }}" method="POST">
                    @csrf
                    <div class="uc-message info" style="box-shadow:none !important">
                        <a href="#" class="uc-message_close-button" data-bs-dismiss="modal"><i
                                class="uc-icon">close</i></a>
                        <div class="uc-message_body" style="">
                            <h2 class="mb-24">
                                <i class="uc-icon warning-icon uc-icon-modal">login</i> Iniciar Sesión con Email
                            </h2>
                            <div class="uc-form-group">
                                <label>Email UC</label>
                                <input type="email" name="email" id="email" class="uc-input-style" value=""
                                    placeholder="Ingrese email UC" required />
                            </div>
                            <div id="error-flash" style="display:none">
                                <div class="uc-alert error mb-12" style="display:block">
                                    <div class="flex d-flex justify-content-between">
                                        <div class="uc-alert_content">
                                            <i class="uc-icon icon-size--sm">cancel</i> Error.
                                        </div>
                                        <div>
                                            <div class="uc-alert_close" data-id="error-flash" style="cursor: pointer;">
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

                        </div>

                    </div>
                    <div class="modal-footer modal-footer-confirm">
                        <button type="submit" class="uc-btn btn-secondary">Continuar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <div id="login-signin-code" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="actionFormLogin" id="actionFormLogin" action="{{ route('login_email_validate') }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="user" id="user" value="" required />

                    <div class="uc-message info" style="box-shadow:none !important">
                        <a href="#" class="uc-message_close-button" data-bs-dismiss="modal"><i
                                class="uc-icon">close</i></a>
                        <div class="uc-message_body" style="">
                            <h2 class="mb-24">
                                <i class="uc-icon warning-icon uc-icon-modal">login</i> Iniciar Sesión con Email
                            </h2>
                            <p>
                                Por favor ingrese el código de validación que hemos enviado a su correo electrónico.
                            </p>
                            <div class="uc-form-group">
                                <label>Código de Validación</label>
                                <input type="text" name="code" id="code" class="uc-input-style" value=""
                                    placeholder="Ingrese código de valicación" required />
                            </div>
                            <div id="error-flash-login" style="display:none">
                                <div class="uc-alert error mb-12" style="display:block">
                                    <div class="flex d-flex justify-content-between">
                                        <div class="uc-alert_content">
                                            <i class="uc-icon icon-size--sm">cancel</i> Error.
                                        </div>
                                        <div>
                                            <div class="uc-alert_close" data-id="error-flash-login"
                                                style="cursor: pointer;">
                                                <i class="uc-icon icon-size--sm">close</i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div style="display:block; width: 100% !important">
                                        <span class="p p-size--sm bold" id="error-flash-message-login"></span>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                    <div class="modal-footer modal-footer-confirm">
                        <button type="submit" class="uc-btn btn-secondary">Continuar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>






    <script type="text/javascript">
        function start() {
            $("#capaprogress").html(
                `<img src="/assets/img/loading01.svg" style="width:25px"/> cargando`
            );
            $("#loading-super").css("width", $(document).width());
            $("#loading-super").css("height", $(document).height());
            $("#loading-super").show();
            $("#loading-progress").show();
        }
        function stop() {
            window.setTimeout(() => {
                $("#capaprogress").empty();
                $("#loading-super").hide();
                $("#loading-progress").hide();
            }, 1000);
        }

        $().ready(function () {
            $(".uc-alert_close").click(function () {
                console.log('click');
                id = $(this).attr("data-id");
                $("#" + id).hide("slow");
            });

            $('#actionForm').submit(function (e) {
                e.preventDefault();
                var response;
                var msg;
                var url;
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: 'json',
                    timeout: 1200000,
                    beforeSend: function () {
                        start();
                    },
                    error: function (response) {
                        let message = "Error desconocido";
                        if (response.responseJSON) {
                            message = response.responseJSON.message;
                        } else if (response.statusText) {
                            message = response.statusText;
                        }
                        $('#error-flash-message').html(message);
                        $('#error-flash').show('slow');
                    },
                    success: function (response) {
                        var response = response;
                        try {
                            if (response.success == 'ok') {
                                $('#user').val($('#email').val());
                                $('#email').val('');
                                $('#login-signin').modal('hide');
                                $('#login-signin-code').modal('show');
                            } else {
                                throw new Error();
                            }
                        } catch (e) {
                            $('#error-flash-message').html(e);
                            $('#error-flash').show('slow');
                        }
                    },
                    complete: function () {
                        stop();
                    }
                });
                return false;
            });



            $('#actionFormLogin').submit(function (e) {
                e.preventDefault();
                var response;
                var msg;
                var url;
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: 'json',
                    timeout: 1200000,
                    beforeSend: function () {
                        start();
                    },
                    error: function (response) {
                        let url = '';
                        let message = "Error desconocido";
                        if (response.responseJSON) {
                            message = response.responseJSON.message;
                            if (response.responseJSON.url) {
                                url = response.responseJSON.url;
                            }
                        } else if (response.statusText) {
                            message = response.statusText;
                        }
                        if (url) {
                            window.location = url;
                        }
                        $('#error-flash-message-login').html(message);
                        $('#error-flash-login').show('slow');
                    },
                    success: function (response) {
                        var response = response;
                        try {
                            if (response.success == 'ok') {
                                url = `$page`;
                                if (response.url) {
                                    url = response.url
                                }
                                window.location.href = url;
                            } else {
                                throw new Error();
                            }
                        } catch (e) {
                            $('#error-flash-message-login').html(e);
                            $('#error-flash-login').show('slow');
                        }
                    },
                    complete: function () {
                        stop();
                    }
                });
                return false;
            });

        });
    </script>

    <div id="loading-super"></div>
    <div id="loading-progress">
        <div id="capaprogress" class="cprogress"></div>
    </div>
</body>

</html>