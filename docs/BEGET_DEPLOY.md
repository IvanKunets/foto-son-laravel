# Развёртывание на Beget (shared-хостинг)

Краткий чек-лист перед переносом Laravel-проекта «Фото-сон». Подробнее см. [README.md](../README.md).

## 1. Версия PHP

В [composer.json](../composer.json) указано `"php": "^8.3"`. В панели Beget выберите **PHP 8.3** или новее для домена/поддомена. Без этого `composer install` и работа приложения невозможны.

## 2. Документ-корень

Каталог сайта в настройках домена должен указывать на **`public/`** (не корень репозитория).

## 3. Файл окружения

- Скопировать `.env.example` → `.env`, задать `APP_URL`, `APP_ENV=production`, `APP_DEBUG=false`.
- Параметры MySQL из панели Beget: `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
- Выполнить `php artisan key:generate` при пустом `APP_KEY`.
- Рекомендуемый минимум для production:
  - `APP_ENV=production`
  - `APP_DEBUG=false`
  - `APP_URL=https://ваш-домен`
  - `SESSION_SECURE_COOKIE=true` (при HTTPS)

## 4. Миграции и сессии

В `.env.example` по умолчанию: `SESSION_DRIVER=database`, `CACHE_STORE=database`, `QUEUE_CONNECTION=database`. После настройки БД выполнить:

```bash
php artisan migrate --force
```

Так будут созданы таблицы для сессий, кэша и очередей (в составе стандартных миграций Laravel). Без успешного `migrate` авторизация и работа сессий могут падать.

### ОСТОРОЖНО: seed в production

- Не запускайте `php artisan db:seed --force` и `php artisan migrate --seed --force` на боевом окружении без явной необходимости.
- В проекте `DatabaseSeeder` содержит демо-данные и демо-администратора для учебного/локального сценария.
- Если сидинги всё же нужны на бою, подготовьте отдельный production-сидер без тестовых аккаунтов и демо-контента.

## 5. Права и ссылка на файлы

- Права на запись: `storage/`, `bootstrap/cache/`.
- `php artisan storage:link` — симлинк `public/storage` → `storage/app/public` для загрузок (галерея, услуги).

## 6. Зависимости и кэш конфигурации

```bash
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
```

При необходимости фронтенд-сборка: `npm ci && npm run build` (если используется Vite в вашем процессе деплоя; публичные CSS/JS уже лежат в `public/css` и `public/js`).

## 7. Расширения PHP

Убедитесь, что включены типичные расширения для Laravel: `openssl`, `pdo_mysql`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`. Redis в `.env` не обязателен при драйверах `database` для сессий и кэша.

## 8. После выкладки (проверка)

- Открыть сайт по HTTPS, проверить публичные страницы и отправку заявки с `/contacts`.
- Войти в админку (`/admin/login`), убедиться что загрузки в галерее/услугах отображаются (`storage:link`).
- Убедиться, что при ошибке на сервере пользователь не видит трассировку (`APP_DEBUG=false`).
- Замерить PageSpeed по пяти URL с **боевого** `APP_URL` и занести результаты в таблицу из [PAGE_SPEED.md](PAGE_SPEED.md).
