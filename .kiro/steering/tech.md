# Technology Stack

## Backend Framework

-   **Laravel 12.x** (PHP 8.2+)
-   **Spatie Laravel Permission** for role-based access control
-   **Laravel Sanctum** for API authentication
-   **SQLite** database (default, configurable to MySQL/PostgreSQL)

## Frontend Stack

-   **Vite** for asset bundling and hot reload
-   **TailwindCSS 4.x** for styling
-   **Blade templates** for server-side rendering
-   **Axios** for HTTP requests

## Development Tools

-   **Laravel Pint** for code formatting
-   **PHPUnit** for testing
-   **Laravel Sail** for Docker development
-   **Laravel Pail** for log monitoring
-   **Concurrently** for running multiple dev processes

## Common Commands

### Development

```bash
# Start development environment (all services)
composer run dev

# Individual services
php artisan serve          # Laravel server
npm run dev               # Vite dev server
php artisan queue:listen  # Queue worker
php artisan pail          # Log monitoring
```

### Database

```bash
php artisan migrate              # Run migrations
php artisan migrate:fresh --seed # Fresh migration with seeding
php artisan db:seed             # Run seeders only
```

### Testing

```bash
php artisan test        # Run PHPUnit tests
./vendor/bin/phpunit   # Direct PHPUnit execution
```

### Code Quality

```bash
./vendor/bin/pint      # Format code with Laravel Pint
```

### Asset Building

```bash
npm run build          # Production build
npm run dev           # Development build with watch
```

## Environment Setup

-   Copy `.env.example` to `.env`
-   Run `php artisan key:generate`
-   Configure database settings in `.env`
-   Default uses SQLite with `database/database.sqlite`
