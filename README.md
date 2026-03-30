# Form Generator

Form Generator is a Laravel 12 + Livewire application for building custom forms, sharing public form links, collecting submissions, and analyzing responses.

## Features

- Drag-and-drop style form builder with multiple field types
- Public form pages via shareable slugs
- Submission storage in JSON, with optional file uploads
- CSV export for submissions
- Form activation and deactivation
- Dashboard analytics (totals, trends, per-form breakdown, field stats)
- Email verification flow with custom verification template
- Google OAuth sign-in support
- Profile and password management

## Tech Stack

- PHP 8.2+
- Laravel 12
- Livewire + AlpineJS
- MySQL (default)
- Vite + Tailwind CSS

## Prerequisites

Before running the project locally, install:

- PHP 8.2+
- Composer
- Node.js 20+ and Bun (recommended by this project), or npm
- MySQL 8+

## Quick Start

1. Clone the repository.
2. Install backend dependencies.
3. Install frontend dependencies.
4. Configure environment variables.
5. Run migrations.
6. Start development services.

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate

# Using Bun (recommended in this project)
bun install
bun run dev

# Or using npm
npm install
npm run dev

# Start Laravel app
php artisan serve
```

You can also run the Composer setup shortcut:

```bash
composer run setup
```

## Environment Configuration

Update your `.env` with the values for your environment.

### Core app settings

- `APP_NAME`
- `APP_ENV`
- `APP_URL`

### Database

- `DB_CONNECTION`
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

### Mail (for verification emails)

- `MAIL_MAILER`
- `MAIL_HOST`
- `MAIL_PORT`
- `MAIL_SCHEME` (preferred, e.g. `tls`)
- `MAIL_USERNAME`
- `MAIL_PASSWORD`
- `MAIL_ENCRYPTION` (legacy alias, optional)
- `MAIL_FROM_ADDRESS`
- `MAIL_FROM_NAME`
- `RESEND_KEY` (when using Resend mail transport)

For Resend API transport, use:

- `MAIL_MAILER=resend`
- `RESEND_KEY=<your-resend-api-key>`
- `MAIL_FROM_ADDRESS=<verified-sender@yourdomain.com>`

If your environment only provides `RESEND_API_KEY`, this project supports it as a fallback.

For Brevo SMTP in production (Railway), typical values are:

- `MAIL_MAILER=smtp`
- `MAIL_HOST=smtp-relay.brevo.com`
- `MAIL_PORT=587`
- `MAIL_SCHEME=smtp` (or omit it)
- `MAIL_USERNAME=<your-brevo-login>`
- `MAIL_PASSWORD=<your-brevo-smtp-key>`
- `MAIL_FROM_ADDRESS=<verified-sender@yourdomain.com>`

If you use port `465`, set `MAIL_SCHEME=smtps`.

### Google OAuth (optional)

- `GOOGLE_CLIENT_ID`
- `GOOGLE_CLIENT_SECRET`
- `GOOGLE_REDIRECT_URI` (typically `${APP_URL}/auth/google/callback`)

## Running the App

In separate terminals:

```bash
php artisan serve
php artisan queue:listen --tries=1
bun run dev
```

Or use the Composer dev script:

```bash
composer run dev
```

## Main Routes

- `/` public landing page
- `/register` register account
- `/login` login page
- `/dashboard` authenticated dashboard
- `/forms/create` create a form
- `/forms/{formId}/edit` edit a form
- `/f/{slug}` public form page

## Storage and File Uploads

- Uploaded files are stored under the `submissions/` path on the configured disk.
- Submission deletion cleans up related uploaded files.

If you need public file serving, run:

```bash
php artisan storage:link
```

## Deployment Notes

- Set `APP_ENV=production` and `APP_DEBUG=false`.
- Ensure `MAIL_MAILER=smtp` is set in Railway variables (otherwise Laravel defaults to `log`).
- Configure a real queue worker (for example, Horizon or Supervisor-managed worker).
- Configure mail provider credentials in production.
- Ensure OAuth callback URLs match your production domain.
- Keep `APP_URL` set to your exact public HTTPS URL (including `www` if used).
- This project trusts upstream proxy headers in bootstrap to prevent signed URL validation issues behind load balancers.
- Run migrations during deployment:

```bash
php artisan migrate --force
```

## Performance Tips

- Use production flags: `APP_ENV=production`, `APP_DEBUG=false`.
- Warm Laravel caches on deploy: `php artisan optimize`.
- Run queues in production (`php artisan queue:work`) so mail and background jobs are not processed inline during requests.
- Prefer Redis for cache/session/queue in production workloads.
- Add database indexes for frequently filtered columns and paginate large lists.

## Security Notes

- Never commit `.env` with real secrets.
- Rotate any credential immediately if it was ever exposed.
- Use per-environment credentials for local, staging, and production.

## License

This project is open-sourced under the MIT license.
