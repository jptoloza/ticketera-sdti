<!DOCTYPE html>
<html lang="es">

  <head>
    <title>@yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" type="text/css">
    <style type="text/css">
      @import url(https://fonts.googleapis.com/css?family=Roboto:300,400,500,700);
    </style>
    <link rel="stylesheet" href="https://kit-digital-uc-prod.s3.amazonaws.com/uc-kitdigital/css/uc-kitdigital.css" />

    <style type="text/css">
      body {
        word-spacing: normal;
        background-color: #ffffff;
        margin: 0;
        padding: 0;
        -webkit-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
        font-family: Roboto, sans-serif;
        font-size: 0.875rem;
      }

      .email-container {
        width: 650px;
        max-width: 100%;
        margin: 0 auto;
        background-color: #ffffff;
      }

      .logo {
        width: 30% !important;
        max-width: 30%;
        text-align: center;
        padding: 20px 25px;
      }

      .system-name {
        width: 70% !important;
        max-width: 70%;
        text-align: left;
        padding: 20px 25px;
        color: #000;
      }

      .system-footer {
        text-align: left;
        padding: 10px 20px 10px 20px;
        background: #0176de;
        color: #ffffff;
        font-size: 0.7rem;
        line-height: 1;
      }

      .siga-header {
        margin: 0 auto;
        max-width: 650px;
      }

      .siga-header-mobile {
        display: none !important;
      }

      .siga-bg-azul {
        background: #0176de;
      }

      .siga-table-ac {
        margin-left: auto;
        margin-right: auto;
      }

      .siga-table-w100 {
        width: 100%;
      }

      .siga-table-border-1 {
        border: none;
      }

      .siga-table-border-1 {
        border: 1px solid #c0c0c0;

      }

      .pr-10 {
        padding-right: 10px;
      }

      .pb-0 {
        padding-bottom: 0px;
      }

      .pt-0 {
        padding-top: 0px;
      }

      .pt-30 {
        padding-top: 30px;
      }

      .mb-0 {
        margin-bottom: 0 !important;
      }

      .fw-normal {
        font-weight: normal;
      }

      .bg-white {
        background: #FFFFFF;
      }

      .mauto {
        margin: 0 auto;
      }

      .text-left {
        text-align: left;
      }

      .text-center {
        text-align: center;
      }

      .p-20 {
        padding: 20px;
      }

      .table-main {
        border: 0px;
        padding: 0px;
        width: 100%;
      }

      .container-main {
        padding-bottom: 20px;
      }


      .uc-btn {
        position: relative;
        line-height: 1;
        border: none;
        display: flex;
        align-items: center;
        text-decoration: none;
        border-radius: 4px;
        background-color: transparent;
        justify-content: space-between;
        transition: background-color .2s ease;
      }

      .uc-btn.btn-secondary,
      .uc-btn.uc-btn-secondary {
        color: #fff;
        padding: 12px 16px;
        line-height: 1.5;
        font-weight: 500;
        background-color: #0176de;
        box-shadow: 0 0 8px rgba(136, 136, 136, .18);
      }



      .uc-btn.btn-primary {
        color: #0176de;
        display: flex;
        padding: 12px 16px;
        line-height: 1.5;
        text-align: left;
        font-weight: 500;
        background-color: #fff;
        border: 1px solid #eaeaea;
        border-top-color: rgb(234, 234, 234);
        border-right-color: rgb(234, 234, 234);
        border-bottom-color: rgb(234, 234, 234);
        border-left-color: rgb(234, 234, 234);
        box-shadow: 0 0 8px rgba(136, 136, 136, .18);
      }


      .uc-btn.btn-primary:hover,
      .uc-btn.btn-primary.hover {
        border-color: #0176de;
        text-decoration: none;
      }


      .uc-btn.btn-inline {
        display: inline-flex;
      }

      .border-bottom-1 {
        border-bottom: 1px solid #c0c0c0;
      }

      /* Estilo para móvil */
      @media screen and (max-width: 480px) {
        .email-container {
          width: 100% !important;
        }

        .siga-header {
          display: none !important;
        }

        .siga-header-mobile {
          display: block !important;
          margin: 0 auto;
          max-width: 650px;
        }

        .system-name {
          text-align: center;
          color: #ffffff;
        }
      }
    </style>
  </head>

  <body>
    <div class="email-container">
      <div class="siga-header">
        <table cellpadding="3" cellspacing="3" class="siga-table-ac siga-table-border-1 siga-table-w100">
          <tr>
            <td class="logo pr-10 border-bottom-1">
              <img height="auto" src="https://kit-digital-uc-prod.s3.amazonaws.com/assets/escudos/logo-uc-01.svg"
                alt="Logo UC">
            </td>
            <td class="system-name pt-30 border-bottom-1">
              <h2 class="mb-0">Mesa de Servicios SDTI</h2>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              @yield('content')
            </td>
          </tr>
          <tr>
            <td colspan="2" class="system-footer">
              <h3 class="mb-0">Dirección de Transformación Digital</h3>
              <h3 class="mb-0 fw-normal">Pontificia Universidad Católica de Chile &copy; {{ date('Y') }}</h3>
            </td>
          </tr>
        </table>
      </div>

      <div class="siga-header-mobile">
        <table cellpadding="3" cellspacing="3" class="siga-table-ac siga-table-border-1 siga-table-w100">
          <tr>
            <td class="logo  pr-10 pb-0" valign="middle">
              <img height="auto"
                src="https://kit-digital-uc-prod.s3.amazonaws.com/kit_mail_iconos/marca_uc/logo-uc-blanco.png"
                alt="Logo UC">
            </td>
          </tr>
          <tr>
            <td class="system-name pt-0">
              <h2 class="mb-0">Mesa de Servicios SDTI</h2>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              @yield('content')
            </td>
          </tr>
          <tr>
            <td colspan="2" class="system-footer">
              Dirección de Transformación Digital
              <br />
              Pontificia Universidad Católica de Chile &copy; {{ date('Y') }}
              <br />
            </td>
          </tr>
        </table>
      </div>
    </div>
  </body>

</html>
