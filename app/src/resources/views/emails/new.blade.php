@extends('emails.main')

@section('title', 'Notificación')

@section('content')
  <div class="bg-white mauto" style="max-width:650px;"">
    <table class="table-main bg-white">
      <tbody>
        <tr>
          <td class="p-20">
            <div class="container-main">
              Hola <b>{{ App\Http\Helpers\UtilHelper::ucTexto($content->user->name) }}</b>,
              se ha creado un nuevo ticket.
              <br />
            </div>

            <div class="container-main">
              <table>
                <tr>
                  <td>Asunto</td>
                  <td>:</td>
                  <td><b>{{ $content->ticket->subject }}</b></td>
                </tr>
                <tr>
                  <td>Creado por</td>
                  <td>:</td>
                  <td><b>{{ App\Http\Helpers\UtilHelper::ucTexto($content->created_by->name) }}</b></td>
                </tr>
                <tr>
                  <td>Equipo</td>
                  <td>:</td>
                  <td><b>{{ $content->queue->queue }}</b></td>
                </tr>
                <tr>
                  <td>Estado</td>
                  <td>:</td>
                  <td><b>{{ App\Http\Helpers\UtilHelper::ucTexto($content->status->status) }}</b></td>
                </tr>
              </table>
            </div>

            <div class="container-main">
              <a href="{{ env('APP_URL') }}/tickets/{{ $content->ticket->id }}" class="uc-btn btn-secondary btn-inline">Ver
                Solicitud</a>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
@endsection
