````markdown
# 🐳 Symfony Docker Setup

## 🚀 Start the environment

Build and start all containers:

```bash
docker-compose build --no-cache
docker-compose up -d
````

---

# 📦 Install dependencies

Install Composer dependencies inside the Symfony container:

```bash
docker exec -it api composer install
```

---

# 🧹 Symfony Cache

## Clear cache

```bash
docker exec -it api php bin/console cache:clear
```

## Warm up cache

```bash
docker exec -it api php bin/console cache:warmup
```

---

# ⚙️ Database (Doctrine)

## Run migrations

```bash
docker exec -it api php bin/console doctrine:migrations:migrate
```

## Create a migration

```bash
docker exec -it api php bin/console make:migration
```

## Update database schema (development only)

```bash
docker exec -it api php bin/console doctrine:schema:update --force
```

---

# 🔐 JWT Authentication (LexikJWTAuthenticationBundle)

## Generate JWT key pair

Generate the private and public keys required for JWT token signing:

```bash
docker exec -it api php bin/console lexik:jwt:generate-keypair
```

This creates:

```
config/jwt/
├── private.pem
└── public.pem
```

## Clear cache after JWT configuration changes

```bash
docker exec -it api php bin/console cache:clear
```

## Check JWT configuration

```bash
docker exec -it api php bin/console debug:config lexik_jwt_authentication
```

---

# 🧠 Composer Autoload

Regenerate Composer autoload files:

```bash
docker exec -it api composer dump-autoload
```

---

# 🔥 Symfony Messenger Queue

## Start worker

```bash
docker exec -it api php bin/console messenger:consume async -vv
```

## Restart workers

```bash
docker restart queue
```

---

# ⏱ Scheduler

Restart scheduler service:

```bash
docker restart scheduler
```

---

# 📚 API Documentation

## NelmioApiDocBundle

Generate API documentation:

```bash
docker exec -it api php bin/console nelmio:apidoc:dump
```

Open:

```
http://localhost:8000/api/doc
```

---

# 🧼 Docker Commands

## Stop containers

```bash
docker-compose down
```

## Stop containers and remove volumes

```bash
docker-compose down -v
```

## Rebuild everything

```bash
docker-compose down -v
docker-compose up -d --build
```

## View running containers

```bash
docker ps
```

## Enter Symfony container

```bash
docker exec -it api bash
```

---

# 🧠 Symfony Main Command

List all Symfony commands:

```bash
docker exec -it api php bin/console
```

---

# 🔍 Useful Debug Commands

## List routes

```bash
docker exec -it api php bin/console debug:router
```

## Check services

```bash
docker exec -it api php bin/console debug:container
```

## Check environment

```bash
docker exec -it api php bin/console about
```

---

# 🔑 Authentication Flow

Login endpoint:

```
POST /api/v1/auth/login
```

Example request:

```json
{
    "email": "user@mail.com",
    "password": "password"
}
```

Successful response:

```json
{
    "success": true,
    "message": "OK",
    "data": {
        "token": "JWT_TOKEN",
        "ttl": "TOKEN_EXPIRATION_TIME"
    }
}
```

Use the token:

```
Authorization: Bearer JWT_TOKEN
```

Protected routes require the JWT token.

---

# 📁 Project Structure

```
src/
├── Auth/
│   ├── Application/
│   ├── Domain/
│   ├── Infrastructure/
│   └── Presentation/
│
├── User/
│   ├── Application/
│   ├── Domain/
│   ├── Infrastructure/
│   └── Presentation/
│
└── Shared/
    ├── Helpers/
    └── Infrastructure/
```

---

# 🛠 Development Workflow

After changing PHP classes:

```bash
docker exec -it api composer dump-autoload
```

After changing Symfony configuration:

```bash
docker exec -it api php bin/console cache:clear
```

After adding routes:

```bash
docker exec -it api php bin/console debug:router
```

After adding services:

```bash
docker exec -it api php bin/console debug:container
```

```
```
