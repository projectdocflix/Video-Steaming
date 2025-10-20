# Video Streaming Platform

A production-ready Laravel application for subscription-based video learning. It supports on‑demand video, live classes, subscriptions, multi‑gateway payments, and an admin dashboard.

## Features

- Subscriptions and packages (student/instructor/org support)
- On-demand video: local, YouTube, Vimeo; SCORM course support
- Live classes: Agora (WebRTC), Zoom, BigBlueButton, Jitsi, Google Meet
- Payments via multiple gateways (PayPal, Stripe, Razorpay, Mollie, Paystack, SSLCommerz, Braintree, Iyzipay, BitPay, etc.)
- API (Laravel Passport), Social login (Google/Facebook/Twitter)
- Admin panel for content, settings, and users
- Theming and multi-language support

## Tech Stack

- PHP 8.1, Laravel 9
- MySQL 8.0
- Blade, Laravel Mix, Vue 3 (selective)
- Docker (php-fpm, nginx, mysql)

## Quick Start

### Option A: Docker (recommended)

1. Copy `.env` from your secure source and adjust values (DB, APP_URL, MAIL, storage):
   - MySQL inside Docker listens on container port 3306, mapped to host 3307.
2. Start services:
   - `docker compose up -d`
3. Install dependencies and initialize app (inside app container):
   - `docker exec -it laravel_app bash`
   - `composer install`
   - `php artisan key:generate`
   - `php artisan migrate` (or import `your_db_backup.sql`)
   - `php artisan storage:link`
   - (Optional) `php artisan passport:install` for API tokens
4. Build frontend assets (on host):
   - `npm ci && npm run dev` (or `npm run prod`)
5. Open app at `http://localhost` (nginx container maps port 80).

### Option B: Manual (no Docker)

1. Prereqs: PHP 8.1, Composer 2, Node 18+, MySQL 8.0
2. Install PHP deps: `composer install`
3. Copy `.env`, set `APP_URL`, DB, MAIL, storage, etc.
4. `php artisan key:generate`
5. DB: `php artisan migrate` (or import `your_db_backup.sql`)
6. `php artisan storage:link`
7. Frontend: `npm ci && npm run dev`
8. Serve: `php artisan serve` (or your preferred web server)

## Environment Variables (minimum)

- Core: `APP_NAME`, `APP_ENV`, `APP_KEY`, `APP_DEBUG`, `APP_URL`
- DB: `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- Mail: `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_ENCRYPTION`, `MAIL_FROM_*`
- Storage (optional): AWS/Wasabi/Vultr S3-compatible keys
- Realtime/Video (optional): `agora_app_id`, `agora_app_certificate` (set via Admin Settings), Zoom/BBB keys
- Payments (as used): gateway keys (PayPal, Stripe, Paystack, SSLCommerz, etc.)

See the full list in the handoff doc.

## NPM & Composer Scripts

- Dev build: `npm run dev`
- Prod build: `npm run prod`
- Watch: `npm run watch`
- PHP tests: `php artisan test`

## Testing

- Run test suite: `php artisan test`
- Configure test DB in `.env.testing` or use sqlite in-memory.

## Deployment Notes

- Build assets with `npm run prod`
- Cache config/routes/views: `php artisan config:cache && php artisan route:cache && php artisan view:cache`
- Ensure queue workers are running if `QUEUE_CONNECTION` ≠ `sync`
- Use object storage for media at scale; prefer Redis for cache/session/queues

## Security

- Do not commit secrets or `.env`
- Rotate API keys regularly and manage via environment/Settings
- Enforce HTTPS in production

## Documentation

- Full technical handoff: `Video-Steaming/TECHNICAL_HANDOFF.md` (architecture, setup, payments, streaming, ops)

## License

See the `LICENSE` file for licensing information.
