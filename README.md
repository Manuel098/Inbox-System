# InboxSystem

## Descripción

InboxSystem es una aplicación Full Stack desarrollada como prueba técnica que implementa un sistema de mensajería basado en conversaciones (Threads). El proyecto está compuesto por una API REST desarrollada con Laravel y un cliente web desarrollado con React, ejecutándose mediante Docker Compose.

El objetivo principal es demostrar una arquitectura limpia, desacoplada y mantenible, aplicando principios SOLID y buenas prácticas de desarrollo tanto en el backend como en la organización del proyecto.

Actualmente el backend implementa la lógica principal del sistema, mientras que el frontend se encuentra preparado para consumir la API y continuará evolucionando con nuevas funcionalidades.

---

## Arquitectura

El proyecto está dividido en dos aplicaciones independientes que se comunican mediante HTTP.

```text
                    Docker Compose
                           │
        ┌──────────────────┼──────────────────┐
        │                  │                  │
        ▼                  ▼                  ▼
   React + Vite         Nginx            Laravel API
      :5173             :8000              PHP 8.3
                                                │
                                                ▼
                                             MySQL 8
                                                │
                                                ▼
                                           phpMyAdmin
                                             :8080
```

Cada servicio se ejecuta dentro de su propio contenedor Docker, permitiendo un entorno de desarrollo reproducible y aislado.

---

## Tecnologías utilizadas

### Backend

* PHP 8.3
* Laravel 13
* MySQL 8
* JWT Authentication (tymon/jwt-auth)
* PHPUnit

### Frontend

* React
* Vite
* TypeScript
* Tailwind CSS
* Axios

### Infraestructura

* Docker
* Docker Compose
* Nginx
* phpMyAdmin

---

## Estructura del repositorio

```text
InboxSystem/
├── backend-inboxsystem/
│   ├── app/
│   ├── routes/
│   ├── database/
│   ├── tests/
│   └── README.md
│
├── frontend-inboxsystem/
│   ├── src/
│   ├── public/
│   └── Dockerfile
│
├── nginx/
│   └── default.conf
│
├── docker-compose.yml
└── README.md
```

Cada proyecto posee responsabilidades independientes.

* **backend-inboxsystem** contiene la API REST y toda la lógica de negocio.
* **frontend-inboxsystem** implementa la interfaz de usuario.
* **nginx** actúa como servidor web para Laravel.
* **docker-compose.yml** orquesta todos los servicios.

---

## Requisitos

Únicamente es necesario tener instalado:

* Docker
* Docker Compose

No es necesario instalar PHP, Composer, Node.js o MySQL de forma local.

---

## Instalación

Clonar el repositorio.

```bash
git clone https://github.com/Manuel098/Inbox-System/

cd InboxSystem
```

Levantar todos los servicios.

```bash
docker compose up --build
```

Durante la primera ejecución Docker descargará las imágenes necesarias y construirá los contenedores del proyecto.

---

## Servicios disponibles

| Servicio   | URL                   |
| ---------- | --------------------- |
| Frontend   | http://localhost:5173 |
| Backend    | http://localhost:8000 |
| phpMyAdmin | http://localhost:8080 |
| MySQL      | localhost:3306        |

---

## Base de datos

El proyecto utiliza MySQL 8.

Configuración por defecto:

```text
Host: mysql

Puerto: 3306

Base de datos: laravel

Usuario: laravel

Contraseña: secret
```

Los datos se almacenan en un volumen Docker para mantener la persistencia entre reinicios de los contenedores.

---

## Contenedores

El entorno está compuesto por cinco servicios.

### MySQL

Servidor de base de datos.

Responsabilidades:

* Persistencia de información.
* Almacenamiento de usuarios.
* Conversaciones.
* Mensajes.
* Notificaciones.

---

### Laravel

API REST responsable de:

* autenticación mediante JWT
* administración de Threads
* envío de mensajes
* notificaciones
* lógica de negocio

---

### Nginx

Servidor web encargado de exponer la aplicación Laravel.

---

### React

Cliente web desarrollado con React, TypeScript y Vite.

Actualmente constituye la base para la interfaz del sistema y continuará evolucionando en futuras iteraciones.

---

### phpMyAdmin

Herramienta para administración visual de la base de datos MySQL.

---

## Variables de entorno

El backend requiere como mínimo las siguientes variables se recomienda usar las de .env.example:

```env
JWT_SECRET=XXXXXXXX

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

La configuración completa puede consultarse dentro del proyecto backend.

---

## Backend

La documentación completa de la API se encuentra en:

```text
backend-inboxsystem/README.md
```

En ella se describe:

* Arquitectura
* Endpoints
* Autenticación
* Modelo de dominio
* Testing
* Organización del proyecto

---

## Frontend

El frontend fue desarrollado utilizando React, Vite y TypeScript.

Su función es consumir la API REST proporcionada por Laravel.

Actualmente la infraestructura se encuentra preparada para continuar con el desarrollo de funcionalidades como:

* autenticación
* listado de conversaciones
* visualización de Threads
* envío de mensajes
* consulta de notificaciones

---

## Testing

El backend incluye pruebas unitarias y de integración.

Para ejecutarlas:

```bash
docker compose exec php
php artisan test
```

---

## Decisiones de arquitectura

Durante el desarrollo del proyecto se tomaron las siguientes decisiones:

* Separación completa entre frontend y backend.
* Arquitectura desacoplada basada en principios SOLID.
* API REST independiente del cliente.
* Contenerización completa mediante Docker.
* Persistencia desacoplada mediante MySQL.
* Entorno reproducible mediante Docker Compose.

---

## Roadmap

Entre las mejoras previstas para futuras iteraciones se encuentran:

### Backend

* Registro de usuarios.
* Administración de participantes.
* Invitación a conversaciones.
* Adjuntos en mensajes.
* Marcado de mensajes como leídos.
* Documentación OpenAPI / Swagger.
* Mejoras en filtros y validaciones.
* Cobertura adicional de pruebas.

### Frontend

* Pantalla de autenticación.
* Dashboard principal.
* Listado de conversaciones.
* Vista de mensajes en tiempo real.
* Administración de perfil.
* Gestión de notificaciones.
* Mejor experiencia de usuario.
* Diseño responsive.

---

## Licencia

Este proyecto fue desarrollado con fines académicos como parte de una prueba técnica.
