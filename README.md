<p align="center">
  <img src="public/images/logo.png" alt="Фото-сон логотип" width="140">
</p>

<h1 align="center">Фото-сон — дипломный fullstack-проект фотосалона</h1>

<p align="center">
  <code>PHP 8.3+</code> <code>Laravel 13</code> <code>MySQL/MariaDB</code> <code>Blade</code> <code>Vite</code> <code>JavaScript</code>
</p>

<p align="center">
  <img alt="PHP 8.3+" src="https://img.shields.io/badge/PHP-8.3%2B-777BB4?logo=php&logoColor=white">
  <img alt="Laravel 13" src="https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white">
  <img alt="MySQL/MariaDB" src="https://img.shields.io/badge/DB-MySQL%20%2F%20MariaDB-4479A1?logo=mysql&logoColor=white">
  <img alt="Blade" src="https://img.shields.io/badge/Blade-Templates-F7523F">
  <img alt="Vite" src="https://img.shields.io/badge/Vite-Build-646CFF?logo=vite&logoColor=white">
</p>

## Оглавление

- [О проекте](#о-проекте)
- [Функциональность](#функциональность)
  - [Публичная часть](#публичная-часть)
  - [Административная часть](#административная-часть)
- [Реализация и архитектура](#реализация-и-архитектура)
- [Инженерные решения](#инженерные-решения)
- [Технологический стек](#технологический-стек)
- [Требования к окружению](#требования-к-окружению)
- [Локальный запуск](#локальный-запуск)
- [Проверка после запуска](#проверка-после-запуска)
- [Развертывание](#развертывание)
- [Структура проекта](#структура-проекта)
- [Документация](#документация)
- [Безопасность репозитория](#безопасность-репозитория)

## О проекте

`Фото-сон` — сайт фотосалона с публичной витриной услуг и административной панелью для операционной работы.  
Проект выполнен в рамках ВКР по специальности **09.02.07 «Информационные системы и программирование»**.

Основной пользовательский поток: клиент просматривает услуги, галерею и отзывы, затем отправляет онлайн-заявку; администратор обрабатывает заявку и управляет контентом через админ-панель.

## Функциональность

### Публичная часть

- Страницы: `/`, `/services`, `/gallery`, `/reviews`, `/contacts`.
- Страница политики данных: `/privacy-policy`.
- Форма онлайн-заявки: `POST /order` с валидацией на сервере (`FormRequest`).
- Выбор услуги в форме через Select2.
- Централизованные SEO/OpenGraph мета-данные через layout.

### Административная часть

- Вход администратора: `/admin/login`.
- Дашборд с ключевыми показателями.
- Управление заявками: список, фильтрация, поиск, смена статуса, удаление.
- CRUD услуг и категорий услуг.
- CRUD галереи (категории и фотографии), переключение видимости.
- CRUD отзывов, переключение видимости.

## Реализация и архитектура

- Паттерн MVC на Laravel.
- Публичные и административные маршруты разделены.
- Админ-маршруты сгруппированы с `prefix('admin')` и `middleware('auth')`.
- Шаблонизация: Blade.
- Данные: MySQL/MariaDB + миграции Laravel.

## Инженерные решения

- Корректные HTTP-методы для CRUD и CSRF-защита форм.
- Ограничение попыток входа в админку (`throttle:5,1` на `POST /admin/login`).
- Пагинация, фильтрация и поиск в списках админ-панели.
- Хранение и публикация загруженных файлов через `storage` и `php artisan storage:link`.

## Технологический стек

- **Backend:** PHP 8.3+, Laravel 13, Eloquent ORM, Form Requests.
- **Frontend:** Blade, HTML5, CSS3, JavaScript.
- **База данных:** MySQL/MariaDB.
- **Сборка ассетов:** Vite (`vite`, `laravel-vite-plugin`).

## Требования к окружению

- PHP 8.3+
- Composer 2+
- MySQL 8+ или MariaDB 10.4+
- Node.js 20.19+ (или 22.12+)
- npm 10+

## Локальный запуск

```bash
git clone <REPOSITORY_URL>
cd foto-son
composer install
npm install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build
php artisan serve
```

Для Linux/macOS вместо `copy`:

```bash
cp .env.example .env
```

## Проверка после запуска

- `php artisan --version`
- `php artisan route:list`
- Проверить публичные маршруты: `/`, `/services`, `/gallery`, `/reviews`, `/contacts`
- Проверить вход в админ-панель: `/admin/login`

## Развертывание

- Для shared-хостинга Beget используется чек-лист: `docs/BEGET_DEPLOY.md`.
- Для production рекомендуется:
  - `APP_ENV=production`
  - `APP_DEBUG=false`
  - корректные параметры `DB_*` в `.env`
  - выполнение миграций и `storage:link`

## Структура проекта

- `app/Http/Controllers` — контроллеры публичной и административной частей.
- `app/Http/Requests` — валидация входящих данных.
- `app/Models` — модели и связи.
- `routes/web.php` — маршруты приложения.
- `resources/views` — Blade-шаблоны.
- `database/migrations` — структура БД.
- `database/seeders` — тестовые/демо-данные.
- `public/` — публичные ассеты и точка входа.

## Документация

- Руководство администратора: `docs/ADMIN_GUIDE.md`
- Развертывание на Beget: `docs/BEGET_DEPLOY.md`
- Политика паролей администратора: `docs/ADMIN_PASSWORD_POLICY.md`

## Безопасность репозитория

В репозиторий не включаются:

- `.env` и любые секреты;
- дампы БД (`*.sql`, `*.sql.gz`);
- архивы бэкапов (`*.tar.gz`, `*.zip`, `*.7z`).
