# Documentación de la Api Task Managment

 ### Pasos para ejecutar el proyecto :
 * Clonar el proyecto en su entorno local, **git clone respositorio**.
 * Instalar las dependencias del proyecto, **composer install** y luego generar la llave para el proyecto **php artisan key:generate**.
 * Para este proyecto se utilizo la base de datos de SqlLite, configurar los parámetros en el archivo .env.

```ini
# Configuración de la base de datos SQLite
DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=
DB_DATABASE=C:\xampp\htdocs\PruebaTecnicaApi\sqlTask.db -> Ruta local de la db.
DB_USERNAME=
DB_PASSWORD=
```

 * Para este proyecto se utilizo la **autenticación JWT** por lo que se debe ejecutar el comando -> **php artisan jwt:secret**.
 * Luego ejecutar el comando para las migraciones,  **php artisan migrate**.
 * Finalmente ejecutar el comando **php artisan serve** para levantar el servidor.



# Endpoints CRUD - Task Management

## Endpoint de Autenticación

**URL base**:  
`http://127.0.0.1:8000`

---

### **Ruta POST: `/api/login`**

Permite a un usuario autenticarse y recibir un token JWT.

**Cuerpo**:

```json
{
  "email": "urma@gmail.com",
  "password": "urma123"
}
```

**Encabezado**:

```plaintext
Content-Type: application/json
```

**Respuesta 200**:

```json
{
  "headers": {},
  "original": {
    "access_token": "token",
    "token_type": "bearer",
    "expires_in": 3600
  },
  "exception": null
}
```

---

### **Ruta POST: `/api/register`**

Registra un nuevo usuario en el sistema y devuelve un token JWT.

**Cuerpo**:

```json
{
  "name": "Urma",
  "email": "urma@gmail.com",
  "password": "urma123"
}
```

**Encabezado**:

```plaintext
Content-Type: application/json
```

**Respuesta 201**:

```json
{
  "message": "User registered successfully!",
  "user": {
    "name": "Urma",
    "email": "urma@gmail.com",
    "id": 10
  },
  "token": "token",
  "token_type": "bearer"
}
```

### **Ruta POST: `/api/logout`**

Cuando se quiere cerrar la sesion.

**Encabezado**:

```plaintext
Content-Type: application/json
Authorization: Bearer Token
```

**Respuesta 200**:

```json
{
  "message": "Successfully logged out"
}
```

---

## Endpoint de Task :

* **Ruta POST: `/api/tasks`**

Se registra una tarea en la aplicacion.

**Cuerpo**:

```json
{
  "title":"Nueva tarea",
  "description":"Descripcion Nueva",
  "status":"pending"
}
```

**Encabezado**:

```plaintext
Content-Type: application/json
Authorization: Bearer Token
```

**Respuesta 201**:

```json
{
  "message": "Task created successfully",
  "task": {
    "title": "Nueva tarea",
    "description": "Descripcion Nueva",
    "status": "pending",
    "user_id": 13,
    "id": 50
  }
}
```

---
* **Ruta GET: `/api/tasks`**

Se obtiene todas las tareas en base al usuario logueado, paginado en 10 items por pagina.

**Encabezado**:

```plaintext
Content-Type: application/json
Authorization: Bearer Token
```

**Respuesta 200**:

```json
{
  "data": [
    {
      "id": 49,
      "title": "Nueva tarea",
      "description": "desc1",
      "status": "pending",
      "user_id": 13
    },
    {
      "id": 50,
      "title": "Nueva tarea",
      "description": "Descripcion Nueva",
      "status": "pending",
      "user_id": 13
    }
  ],
  "currentPage": 1,
  "previousPage": null,
  "nextPage": null
}
```

---
* **Ruta GET: `/api/tasks/{id}`**

Obtenemos la informacion de una tarea en base al id de la tarea, el id debe ser un entero.

**Encabezado**:

```plaintext
Content-Type: application/json
Authorization: Bearer Token
```

**Respuesta 200**:

```json
{
  "id": 50,
  "title": "Nueva tarea",
  "description": "Descripcion Nueva",
  "status": "pending",
  "user_id": 13
}
```

---
* **Ruta PUT: `/api/tasks/{id}`**

Actualiza la informacion de una tarea en base al id de la tarea, el id debe ser un entero.

**Cuerpo**:

```json
{
  "title":"Nueva tarea actualiazada",
  "description":"Descripcion Nueva actualiazada",
  "status":"done"
}
```

**Encabezado**:

```plaintext
Content-Type: application/json
Authorization: Bearer Token
```



**Respuesta 200**:

```json
{
  "message": "Task updated successfully"
}
```

---


* **Ruta DELETE: `/api/tasks/{id}`**

Elimina una tarea en base al id de la tarea, el id debe ser un entero.


**Encabezado**:

```plaintext
Content-Type: application/json
Authorization: Bearer Token
```

**Respuesta 200**:

```json
{
  "message": "Task deleted successfully"
}
```


## Errores 

**Error 400**:

Cuando se quiere realiza una accion a una tarea con un id que no existe.

```json
{
  "message": "Task with id {id} not found"
}
```

Cuando el parametro id no es un entero.


```json
{
  "message": "The id must be an integer"
}
```

**Error 404**:

Cuando un recurso no es encontrado.


```json
{
  "message": "Resource not found"
}
```
