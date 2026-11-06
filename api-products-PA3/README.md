# API Users

API REST básica para gestionar usuarios con PHP y MySQL.

## Requisitos para utilizar mi projecto

- XAMPP
- PHP
- MySQL/MariaDB
- PowerShell o cURL. (ejecutable en la terminal de vs code). 

## Base de datos

Crear una base de datos llamada `user_database` y ejecutar:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

La conexión predeterminada de este proyecto usa:

- Host: `127.0.0.1`
- Puerto: `3306`
- Base de datos: `user_database`
- Usuario: `root`
- Contraseña: vacía

## Iniciar el servidor

La raíz del proyecto:

```powershell
cd D:\xampp\htdocs\api-products-PA3
D:\xampp\php\php.exe -S 127.0.0.1:8000 -t public
```

-Los pasos se ejecutan en la terminal.
-Verificar la carpeta exacta donde ha sido guardado el projecto. Asi evitamos errores en la conexión.
-Es muy importante también mantener esa terminal abierta mientras se  prueban los endpoints. Pruebe abrir una terminal adicional para los endpoints.

## Los Endpoints

### Obtener todos los usuarios

```powershell
Invoke-RestMethod "http://127.0.0.1:8000/api/users" -Method Get
```

### Obtener un usuario

```powershell
Invoke-RestMethod "http://127.0.0.1:8000/api/users/1" -Method Get
```

### Crear un usuario

```powershell
Invoke-RestMethod `
  -Uri "http://127.0.0.1:8000/api/users" `
  -Method Post `
  -ContentType "application/json" `
  -Body '{"name":"Ana","email":"ana@example.com","password":"ihateisil1234"}'
```

### Actualizar un usuario

```powershell
Invoke-RestMethod `
  -Uri "http://127.0.0.1:8000/api/users/1" `
  -Method Put `
  -ContentType "application/json" `
  -Body '{"name":"Ana Ramirez","email":"ana.ramirez@example.com","password":"iloveisil8765"}'
```

### Eliminar un usuario

```powershell
Invoke-RestMethod "http://127.0.0.1:8000/api/users/1" -Method Delete
```
