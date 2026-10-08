# Простой блог — PHP + Smarty + MySQL (Docker)

## Быстрый старт

### 1. Окружение
cp .env.example .env

### 2. Собрать образ (composer install выполняется внутри образа)
make build

### 3. Поднять контейнеры (db → app (с миграцией схемы) → web)
make up

### 4. Заполнить тестовыми данными (категории + статьи)
make seed