# MiInbox

## Descripción

MiInbox es una API REST desarrollada con Laravel que implementa un sistema de mensajería basado en conversaciones (Threads). El proyecto fue desarrollado como una prueba técnica con el objetivo de demostrar buenas prácticas de arquitectura, separación de responsabilidades y desarrollo orientado a principios SOLID.

La aplicación permite que usuarios autenticados creen conversaciones, intercambien mensajes de texto y reciban notificaciones cuando se generan nuevos mensajes dentro de los hilos en los que participan.

---

## Características

- Autenticación mediante JWT.
- Obtención del usuario autenticado.
- Creación de conversaciones privadas.
- Conversaciones con múltiples participantes.
- Envío de mensajes dentro de un Thread.
- Consulta de conversaciones.
- Consulta del detalle de una conversación.
- Notificaciones automáticas al recibir nuevos mensajes.
- Arquitectura basada en responsabilidades bien definidas.
- Cobertura mediante pruebas unitarias y de integración.

---

## Tecnologías

| Tecnología | Versión |
|------------|----------|
| PHP | 8.3.32 |
| Laravel | 13.20.0 |
| MySQL | 8+ |
| JWT | tymon/jwt-auth |
| PHPUnit | Incluido con Laravel |

---

## Arquitectura

El proyecto fue construido siguiendo los principios SOLID y una arquitectura desacoplada mediante capas especializadas.

La lógica de negocio se encuentra completamente separada de la capa HTTP.

```
Controller
      │
      ▼
    Action
      │
      ▼
 Interfaces
      │
      ▼
   Service
      │
      ▼
   Modelos
```

Cada componente tiene una única responsabilidad.

### Actions

Las Actions representan los casos de uso de la aplicación.

Ejemplos:

- Crear un Thread.
- Obtener conversaciones.
- Enviar un mensaje.
- Consultar notificaciones.
- Autenticar usuarios.

---

### Services

Contienen la lógica de negocio.

Los Controllers nunca interactúan directamente con los modelos.

---

### DTOs

Los DTOs encapsulan los datos de entrada de cada caso de uso.

Esto evita el uso de arreglos dentro de la lógica de negocio y mejora el tipado del proyecto.

---

### Interfaces

Los servicios son consumidos mediante interfaces, permitiendo desacoplamiento e inversión de dependencias.

---

### Requests

Los Form Requests son responsables de validar las peticiones HTTP.

Actualmente existen Requests preparados para todos los endpoints aunque algunos aún no contienen reglas de validación, quedando como mejora futura.

---

### Resources

Los Resources transforman los modelos antes de ser enviados al cliente, evitando exponer directamente la estructura interna de la base de datos.

---

## Modelo de dominio

### User

Representa a un usuario autenticado.

Un usuario puede:

- Participar en múltiples Threads.
- Enviar múltiples mensajes.
- Recibir notificaciones.

---

### Thread

Representa una conversación.

Características:

- Tiene un asunto (Subject).
- Puede contener múltiples participantes.
- Contiene múltiples mensajes.

Actualmente cualquier usuario autenticado puede crear un Thread.

---

### Message

Representa un mensaje de texto perteneciente a un Thread.

Actualmente únicamente soporta mensajes de texto.

---

## Autenticación

La autenticación se realiza mediante JWT utilizando el paquete:

```
tymon/jwt-auth
```

### Login

```
POST /api/sign-in
```

Respuesta:

```json
{
    "access_token": "JWT_TOKEN",
    "token_type": "Bearer",
    "expires_in": 3600
}
```

Todas las rutas protegidas requieren el encabezado:

```
Authorization: Bearer {token}
```

---

## Endpoints

### Autenticación

#### Iniciar sesión

```
POST /api/sign-in
```

---

### Usuario

#### Obtener usuario autenticado

```
GET /api/user
```

---

### Threads

#### Listar conversaciones

```
GET /api/threads
```

Actualmente el DTO soporta:

- búsqueda (`search`)
- estado (`status`)
- paginación (`perPage`)

La validación HTTP correspondiente aún se encuentra pendiente de implementación.

---

#### Crear conversación

```
POST /api/threads
```

---

#### Obtener conversación

```
GET /api/threads/{thread}
```

---

### Mensajes

#### Agregar mensaje

```
POST /api/threads/{thread}/messages
```

---

### Notificaciones

#### Listar notificaciones

```
GET /api/notifications
```

Actualmente el DTO soporta:

- usuario
- paginación

La validación mediante Request será incorporada posteriormente.

---

## Variables de entorno

Variables requeridas:

```env
JWT_SECRET=XXXXXXXXXXX

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

Se recomienda el uso del .env.example

---

## Base de datos

El proyecto utiliza MySQL.

Los Seeders incluidos generan información para facilitar las pruebas:

- Usuarios
- Threads
- Mensajes

Las notificaciones son generadas durante el uso de la aplicación.

---

## Testing

El proyecto incluye pruebas unitarias y pruebas de integración.

Para ejecutar la suite de pruebas:

```bash
php artisan test
```

Las pruebas cubren:

- Autenticación
- Threads
- Mensajes
- Notificaciones
- Actions
- Services

---

## Organización del proyecto

```
app
├── Actions
├── DTOs
├── Http
│   ├── Controllers
│   ├── Requests
│   └── Resources
├── Interfaces
├── Models
├── Notifications
├── Providers
└── Services
```

### Actions

Casos de uso.

### DTOs

Objetos de transferencia de datos.

### Controllers

Entrada HTTP.

### Requests

Validación de peticiones.

### Resources

Transformación de respuestas.

### Services

Lógica de negocio.

### Interfaces

Abstracción de dependencias.

### Models

Persistencia mediante Eloquent.

### Notifications

Implementación de notificaciones de Laravel.

---

## Decisiones de diseño

Durante el desarrollo se tomaron las siguientes decisiones:

- Separar la lógica de negocio de los Controllers.
- Utilizar DTOs para encapsular la información de entrada.
- Consumir servicios mediante interfaces.
- Mantener los Controllers lo más ligeros posible.
- Centralizar la lógica de negocio dentro de Services.
- Implementar Actions para representar casos de uso específicos.
- Utilizar API Resources para controlar el formato de salida.

---

## Mejoras futuras

Aunque la prueba técnica cumple con los requerimientos solicitados, existen funcionalidades que pueden incorporarse en futuras iteraciones.

### Funcionales

- Registro de usuarios.
- Invitación de participantes a un Thread existente.
- Administración de participantes.
- Adjuntar archivos.
- Eliminación de mensajes.
- Edición de mensajes.
- Marcado de mensajes como leídos.
- Eliminación lógica de conversaciones.

### Técnicas

- Validaciones completas en todos los Form Requests.
- Mayor cobertura de pruebas.
- Eventos y Listeners para desacoplar el sistema de notificaciones.
- Caché para consultas frecuentes.
- Rate Limiting específico para la API.
- Paginación configurable en todos los endpoints.
- Filtros avanzados para conversaciones y notificaciones.

---

## Autor
Jose Manuel Valdez Gonzalez :DD
Proyecto desarrollado como prueba técnica utilizando Laravel 13, PHP 8.3 y principios SOLID.