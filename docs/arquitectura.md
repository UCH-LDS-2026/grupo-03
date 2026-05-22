# Arquitectura del sistema

## Patrón general

El sistema sigue el patrón MVC simplificado implementado en PHP. Cada solicitud HTTP es recibida por un único punto de entrada que actúa como *front controller* y delega la ejecución al controlador y acción correspondientes.

```
Navegador → Servidor → Front controller → Controlador → Modelo → Vista → Navegador
```

## Capas

### Model
Clases PHP que encapsulan toda interacción con la base de datos a través de PDO. Exponen métodos con nombres descriptivos (`save`, `findByArea`, `markAsResolved`). No contienen lógica de presentación.

### View
Archivos PHP de plantilla que generan el HTML final. Reciben datos desde el controlador y solo se encargan de mostrarlos. No contienen lógica de negocio.

### Controller
Clases PHP que reciben la request, validan la entrada, llaman al modelo y seleccionan la vista a renderizar. Cada entidad principal tiene su propio controlador: `TicketController`, `SolucionController`, `UsuarioController`, `AreaController`, `BusquedaController`.

### Front controller
Punto de entrada único. Lee los parámetros de la solicitud, instancia el controlador correspondiente e invoca la acción solicitada.

## Base de datos

Se utiliza **SQLite** como motor de base de datos, por su simplicidad de configuración y por no requerir un servidor separado. El acceso se realiza mediante PDO, lo que abstrae el motor subyacente y facilita una eventual migración a un motor más robusto.

## Flujo de una solicitud típica

1. El navegador envía una solicitud al servidor
2. El front controller identifica el controlador y acción correspondientes
3. El controlador valida la sesión y el rol del usuario
4. Si es necesario, interactúa con el modelo para leer o escribir datos
5. El controlador selecciona la vista y le pasa los datos
6. La vista genera el HTML final que se envía al navegador

## Seguridad

- Contraseñas hasheadas con `password_hash()` (bcrypt), verificadas con `password_verify()`
- Consultas con sentencias preparadas PDO para prevenir inyección SQL
- Control de acceso por rol mediante `$_SESSION['rol']` en cada controlador
- Archivo de base de datos excluido del repositorio via `.gitignore`

## Estructura de carpetas

```
sistema-tickets/
├── config/
├── controllers/
├── models/
├── views/
├── public/
├── database/
│   └── schema.sql
└── index.php
```
