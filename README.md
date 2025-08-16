# Nginx + PHP-FPM + MariaDB (Docker Compose)

## Requisitos
- Docker y Docker Compose instalados

## Cómo levantar
```bash
docker compose up -d --build
```

- App: http://localhost:8080
- phpMyAdmin: http://localhost:8081 (host: `db`, usuario: `appuser`, pass: `apppass`)

## Notas
- Solo Nginx expone puertos al host. PHP y MariaDB quedan aislados en la red `appnet`.
- Cambiá credenciales en `.env` para producción y **no publiques `db`**.
- La imagen `mariadb:10.5` está aquí para compatibilidad, pero considerá actualizar a una versión soportada a largo plazo (por ejemplo 10.6 o superior).
