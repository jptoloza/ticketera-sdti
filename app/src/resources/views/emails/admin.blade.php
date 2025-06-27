@extends('emails.main')

@section('title', 'Notificación')

@section('content')
  <div class="bg-white mauto" style="max-width:650px;"">
    <table class="table-main bg-white">
      <tbody>
        <tr>
          <td class="p-20">
            <div class="container-main">
              Hola <b>Admin</b>, se ha generado un cambio en la ticketera.
              <br />
            </div>

            <div class="container-main">
                <table>
                    <tr>
                        <td>Registro</td>
                    </tr>
                    <tr>
                        <td>{{ $content->register }}</td>
                    </tr>
                </table>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
@endsection
