# Nginx + PHP-FPM + MariaDB (Docker Compose)

Este proyecto configura un entorno de desarrollo con **Nginx**, **PHP-FPM**, **MariaDB** y **phpMyAdmin** utilizando Docker Compose. Los servicios están aislados en una red personalizada de Docker, con solo Nginx exponiendo puertos al host.

## Requisitos
- [Docker](https://docs.docker.com/get-docker/) y [Docker Compose](https://docs.docker.com/compose/install/) instalados.

## Inicio Rápido
Para levantar el entorno, sigue estos pasos:

1. **Crear la red de Docker**  
   Crea una red personalizada para la comunicación entre contenedores:  
   ```bash
   docker network create appnet
   ```

2. **Levantar Nginx, PHP-FPM y MariaDB**  
   Construye y ejecuta los servicios principales definidos en `docker-compose.yml`:  
   ```bash
   docker compose up -d --build
   ```
   - `-d`: Ejecuta los contenedores en segundo plano.  
   - `--build`: Fuerza la reconstrucción de imágenes si hay cambios.  

   Una vez completado, la aplicación estará disponible en:  
   - **App**: [http://localhost:8080](http://localhost:8080)  
   - **Base de datos**: Accesible internamente como `db` dentro de la red `appnet`.

3. **Levantar phpMyAdmin**  
   phpMyAdmin está definido en un archivo separado `docker-compose.phpmyadmin.yml` para no interferir con la app principal. Ejecútalo por fuera de la carpeta de este proyecto con:  
   ```bash
   docker compose -f docker-compose.phpmyadmin.yml up -d
   ```
   phpMyAdmin estará disponible en:  
   - **phpMyAdmin**: [http://localhost:8081](http://localhost:8081)  

4. **Credenciales de acceso**  
   Usa las siguientes credenciales para iniciar sesión en phpMyAdmin:  
   - **Host**: `db`  
   - **Usuario**: `appuser`  
   - **Contraseña**: `apppass`  

## Algunos comandos de docker
- **Ver contenedores en ejecución**:  
   ```bash
   docker ps
   ```

- **Detener todos los servicios**:  
   ```bash
   docker compose down
   docker compose -f docker-compose.phpmyadmin.yml down
   ```

- **Ver logs en tiempo real** (ejemplo para Nginx):  
   ```bash
   docker compose logs -f nginx
   ```

## Notas
- **Aislamiento de red**: Solo Nginx expone puertos al host. PHP-FPM y MariaDB están aislados en la red `appnet`.  
- **Seguridad**: Actualiza las credenciales en el archivo `.env` para producción y no expongas el servicio de base de datos públicamente.  
- **Versión de MariaDB**: Se usa la imagen `mariadb:10.5` por compatibilidad. Para soporte a largo plazo