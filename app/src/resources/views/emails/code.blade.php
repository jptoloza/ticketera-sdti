@extends('emails.main')

@section('title', 'Notificación')

@section('content')
  <div class="bg-white mauto" style="max-width:650px;"">
    <table class=" table-main bg-white">
    <tbody>
    <tr>
      <td class="p-20">
      <div class="container-main">
        Hola <b>@if ($content->name != 'NN') {{ $content->name }} @else {{$content->email}} @endif</b>, adjuntamos el
        código de validación
        para iniciar sesión en la ticketera.
        <br />
      </div>

      <div class="container-main">
        <table>
        <tr>
          <td>Código de Validación</td>
        </tr>
        <tr>
          <td>{{ $content->code }}</td>
        </tr>
        </table>
      </div>
      </td>
    </tr>
    </tbody>
    </table>
  </div>
@endsection