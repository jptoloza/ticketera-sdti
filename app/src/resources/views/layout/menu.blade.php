<div class="m-4 mt-3 ms-3 mb-1 title-menu">
  <div class="d-flex  mb-3">
    <a href="{{ route('tickets_addForm') }}" class="uc-btn btn-primary vw-100">
      Nuevo Ticket&nbsp;&nbsp;
      <i class="uc-icon icon-size--sm">edit</i>
    </a>
  </div>

  <ul class="uc-navbar-side">
    <li class="d-block d-lg-none mb-1">
      <a href="/" class="uc-navbar-side_label active">
        <span class="h5"><i class="uc-icon me-2">home</i>Inicio</span>
      </a>
    </li>
    <li>
      <a class="uc-navbar-side_label active">
        <span class="h5"><i class="uc-icon me-2">local_offer</i>Tickets</span>
      </a>
      <ul class="uc-navbar-side">
        <li>
          <a href="{{route('tickets')}}">
            Mis tickets ({{ $myTickets }})
            <i class="uc-icon">keyboard_arrow_right</i>
          </a>
        </li>
      @if (in_array('ROLE_AGENT', session('roles')))
        <li>
          <a href="{{ route('tickets.assigned') }}">
            Mis tickets asignados ({{ $myAsignedTickets }})
            <i class="uc-icon">keyboard_arrow_right</i>
          </a>
        </li>
      @endif
      </ul>
    </li>

    @if ((in_array('ROLE_AGENT', session('roles')) || 
        in_array('ROLE_MANAGER', session('roles'))) && count($userQueues))

    <li class="mt-3">
      <a href="#" class="uc-navbar-side_label active">
        <span class="h5"><i class="uc-icon me-2">topic</i> Equipos</span>
      </a>
      <ul class="uc-navbar-side pt-3">
      @forelse ($userQueues as $queue)
        <li class="mb-3" style="padding-left: 16px;">
          <span class="uc-navbar-side_label">{{ $queue->queue }} <i class="uc-icon">keyboard_arrow_right</i></span>
          <ul id="submenu-{{ $queue->id }}" class="uc-navbar-side">
            <li>
              <a href="{{ route('tickets.noAssigned.queue', $queue->id) }}" class="pb-0">
              Tickets no asignados ({{ $dataQueue[$queue->id] }})
              <i class="uc-icon">keyboard_arrow_right</i>
              </a>
            </li>
            <li>
              <a href="{{ route('tickets.byQueue', $queue->id) }}">
              Todos los tickets
              <i class="uc-icon">keyboard_arrow_right</i>
              </a>
            </li>
          </ul>
          
        </li>
      @empty
        <li>
          <span class="uc-navbar-side_label text-muted">Sin colas asignadas</span>
        </li>
    @endforelse
      </ul>
    </li>
  @endif

  </ul>
</div>




