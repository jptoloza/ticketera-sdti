# ticketera-sdti

## lo que falta:
terminar los mensajes
terminar el cambio de estado
terminar la navegación por las colas
colocar el envio de correo
completar las tablas del admin





crear tablas:
users
- id
- name
- rut
- login
- email
- created_at
- update_at
- deleted_at


sessions
- id
- user_id foreignId('user_id')->nullable()
- ip_address
- user_agent
- payload
- last_activity

- created_at
- update_at
- deleted_at


request_logs
- id 
- method
- url
- ip
- headers
- body
- created_at
- update_at
- deleted_at

roles
- id
- rol
- active
- created_at
- update_at
- deleted_at
1.- Administrador
2.- Agente
3.- Usuario

users_roles
- id
- user_id foreign key users
- role_id foreign key roles
- created_at
- update_at
- deleted_at
* unique user_id/role_id



priorities
- id
- priority
- active
- created_at
- update_at
- deleted_at
1.- Baja
2.- Media
3.- Alta
4.- Crítica


tickets
- id
- status_id foreign key status
- priority_id FOREIGN key   priorities
- user_id FOREIGN users
- queue_id FOREIGN queues
- subject
- message
- files json
- created_by
- assigned_agent
- created_at
- update_at
- deleted_at

tickets_messages
- id
- ticket_id
- created_by
- message
- files
- created_at
- update_at
- deleted_at


ticket_notifications
- id
- ticket_id
- user_id
- status
- created_at
- update_at
- deleted_at


status
- id
- status
- active
- created_at
- update_at
- deleted_at
1.- abierto
2.- asignado
3.- reasignado
3.- en progreso
4.- escalado
5.- cerrado
6.- cancelado



logs
- id 
- url
- ip
- user_id foreign key users nullable
- register => acción, datos, etc
- created_at
- update_at
- deleted_at


logs_tickets
- id
- ticket_id
- action => update, close, in progress, etc
- data => data antes y despues
- created_at
- update_at
- deleted_at

queues (colas)
- id
- queue
- active
- created_at
- update_at
- deleted_at

colas_users
- id
- user_id foreign key users
- queue_id foreign key queues
- created_at
- update_at
- deleted_at
* unique user_id/queue_id


