<!DOCTYPE html>
<html>
<head>
    <title>Notificación</title>
</head>
<body>
    <h1 style="border-bottom: 1px solid #c00c0c">Mesa de Servicios SDTI</h1>
    
    <div>
        Hola, {{ $content->user->name }}:
        <br/>
        Se ha creado un nuevo ticket ({{ $content->ticket->subject }} por "{{ $content->created_by->name }}".
        <br/>
        Equipo: {{ $content->ticket->queur_id }}
        <br/>
        Estado: {{ $content->ticket->status_id }}
        <br/>
        <br/>
        Par ver más detalles ingrese a {{ env('APP_URL')}}/tickets/{{ $content->ticket->id}}.
    </div>

    

</body>
</html>
