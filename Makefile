.PHONY: help build up down restart ps logs logs-app logs-db logs-web \
        php-shell mysql-shell composer migrate seed clear-smarty clean rebuild \
        pull exec-app exec-db

DC := docker compose

help: ## Показ списка команд
	@echo "Доступные команды:"
	@echo ""
	@grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) \
		| awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-18s\033[0m %s\n", $$1, $$2}'
	@echo ""

build: ## Собрать Docker-образ
	$(DC) build

up: ## Поднять все сервисы (detached)
	$(DC) up -d

rebuild: ## Пересобрать и перезапустить всё
	$(DC) up -d --build

down: ## Остановить все сервисы (данные сохраняются)
	$(DC) down

clean: ## Остановить и удалить контейнеры + тома (БД сотрётся!)
	$(DC) down -v

ps: ## Статус контейнеров
	$(DC) ps

logs: ## Логи всех сервисов (follow)
	$(DC) logs -f

logs-app: ## Логи PHP-приложения
	$(DC) logs -f app

logs-db: ## Логи MySQL
	$(DC) logs -f db

logs-web: ## Логи Nginx
	$(DC) logs -f web

php-shell: ## Зайти в shell PHP-контейнера
	$(DC) exec app sh

composer: ## Запустить composer внутри контейнера (пример: make composer c=install)
	$(DC) exec app composer $(c)

migrate: ## Запустить миграцию БД
	$(DC) exec app php app/bin/migrate.php

seed: ## Заполнить БД тестовыми данными (категории + статьи)
	$(DC) exec app php app/bin/seed.php

mysql-shell: ## Зайти в MySQL (пароль из .env)
	$(DC) exec db mysql -u$${DB_USER:-app} -p$${DB_PASSWORD:-change_me} $${DB_NAME:-app}

clear-smarty: ## Очистить кэш Smarty
	$(DC) exec app sh -c "rm -f /var/www/html/smarty/templates_c/* /var/www/html/smarty/cache/*"
	@echo "Smarty cache cleaned."

pull: ## Подтянуть последние образы
	$(DC) pull

exec-app: ## Выполнить команду в PHP-контейнере (пример: make exec-app CMD="php -v")
	$(DC) exec app sh -c '$(CMD)'

exec-db: ## Выполнить команду в MySQL-контейнере (пример: make exec-db CMD="SHOW DATABASES;")
	$(DC) exec db sh -c '$(CMD)'