Here is a **clean, ready-to-copy Symfony README** for your Docker setup (no Laravel leftovers, fully corrected):

---

# 🐳 Symfony Docker Setup

## 🚀 Start the environment

```bash
docker-compose build --no-cache
docker-compose up -d
```

---

## 📦 Install dependencies

```bash
docker exec -it api composer install
```

---

## 🧹 Cache (Symfony)

### Clear cache

```bash
docker exec -it api php bin/console cache:clear
```

### Warm up cache

```bash
docker exec -it api php bin/console cache:warmup
```

---

## ⚙️ Database (Doctrine)

### Run migrations

```bash
docker exec -it api php bin/console doctrine:migrations:migrate
```

### Create a migration

```bash
docker exec -it api php bin/console make:migration
```

---

## 🧠 Composer autoload

```bash
docker exec -it api composer dump-autoload
```

---

## 🔥 Queue (Symfony Messenger)

### Start worker

```bash
docker exec -it api php bin/console messenger:consume async -vv
```

### Restart workers

```bash
docker restart queue
```

---

## ⏱ Scheduler

```bash
docker restart scheduler
```

---

## 📚 API Documentation

### If using API Platform

Open:

```
http://localhost:8000/api/docs
```

### If using NelmioApiDocBundle

```bash
docker exec -it api php bin/console nelmio:apidoc:dump
```

---

## 🧼 Docker commands

### Stop containers

```bash
docker-compose down
```

### Rebuild everything

```bash
docker-compose down -v
docker-compose up -d --build
```

---

## 🧠 Symfony main command

```bash
docker exec -it api php bin/console
```

---