# Laravel Starter Kit dengan Role & Permission

Laravel starter kit lengkap dengan sistem authentication, authorization menggunakan roles & permissions, dan content management system.

## Fitur Utama

-   ✅ Authentication (Login/Logout)
-   ✅ Role-based Access Control (RBAC)
-   ✅ Permission-based Authorization
-   ✅ Dashboard dengan statistik
-   ✅ Blog Management
-   ✅ Project Management
-   ✅ User Management (Admin)
-   ✅ Role & Permission Management (Admin)

## Roles & Permissions

### Default Roles:

1. **Admin** - Full access ke semua fitur
2. **Writer** - Hanya akses blog management
3. **Manager** - Hanya akses project management

### Default Permissions:

-   `view-dashboard` - Akses dashboard
-   `manage-blogs` - CRUD blogs
-   `manage-projects` - CRUD projects
-   `manage-users` - CRUD users
-   `manage-roles` - CRUD roles & permissions

## Setup & Installation

### 1. Clone & Install Dependencies

```bash
git clone <repository-url>
cd laravel-starter-kit
composer install
npm install
```

### 2. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Configuration

Edit `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_starter
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Database Migration & Seeding

```bash
php artisan migrate
php artisan db:seed
```

### 5. Build Assets

```bash
npm run build
# atau untuk development
npm run dev
```

### 6. Start Server

```bash
php artisan serve
```

## Default Users

Setelah seeding, Anda dapat login dengan:

| Email               | Password | Role    |
| ------------------- | -------- | ------- |
| admin@example.com   | password | Admin   |
| writer@example.com  | password | Writer  |
| manager@example.com | password | Manager |

## Struktur Project

### Controllers

-   `AuthController` - Handle authentication
-   `DashboardController` - Dashboard dengan statistik
-   `BlogController` - CRUD blogs
-   `ProjectController` - CRUD projects
-   `Admin/UserController` - User management
-   `Admin/RoleController` - Role & permission management

### Form Requests

-   `LoginRequest` - Validation untuk login
-   `StoreBlogRequest` & `UpdateBlogRequest` - Validation untuk blog
-   `StoreProjectRequest` & `UpdateProjectRequest` - Validation untuk project
-   `StoreUserRequest` & `UpdateUserRequest` - Validation untuk user
-   `StoreRoleRequest` & `UpdateRoleRequest` - Validation untuk role

### Models

-   `User` - User model dengan roles
-   `Blog` - Blog model
-   `Project` - Project model
-   `Role` - Role model (Spatie)
-   `Permission` - Permission model (Spatie)

### Middleware

-   `PermissionMiddleware` - Check user permissions
-   `RoleMiddleware` - Check user roles

### Views

-   `layouts/app.blade.php` - Main layout
-   `dashboard.blade.php` - Dashboard
-   `auth/login.blade.php` - Login form
-   `blogs/*` - Blog management views
-   `projects/*` - Project management views
-   `admin/users/*` - User management views
-   `admin/roles/*` - Role management views

## Penggunaan

### Menambah Permission Baru

#### 1. Tambahkan ke Seeder

Edit `database/seeders/RolePermissionSeeder.php`:

```php
$permissions = [
    // Existing permissions...
    'view blogs',
    'create blogs',

    // Tambahkan permission baru
    'manage categories',
    'export data',
    'view reports',
];
```

#### 2. Assign ke Role

```php
// Di seeder atau manual
$adminRole = Role::findByName('Admin');
$adminRole->givePermissionTo(['manage categories', 'export data']);

$writerRole = Role::findByName('Writer');
$writerRole->givePermissionTo('manage categories');
```

#### 3. Jalankan Seeder Ulang

```bash
php artisan migrate:fresh --seed
# atau hanya seeder
php artisan db:seed --class=RolePermissionSeeder
```

#### 4. Gunakan di Controller

```php
// Method 1: Middleware
public function __construct()
{
    $this->middleware('permission:manage categories')->only(['create', 'store']);
}

// Method 2: Authorization
public function create()
{
    $this->authorize('manage categories');
    // ...
}

// Method 3: Manual check
public function index()
{
    if (!auth()->user()->can('view reports')) {
        abort(403);
    }
    // ...
}
```

#### 5. Gunakan di Routes

```php
Route::get('/categories', [CategoryController::class, 'index'])
    ->middleware('permission:manage categories');

Route::group(['middleware' => 'permission:export data'], function () {
    Route::get('/export/users', [ExportController::class, 'users']);
    Route::get('/export/blogs', [ExportController::class, 'blogs']);
});
```

#### 6. Gunakan di Blade Views

```blade
@can('manage categories')
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        Add Category
    </a>
@endcan

@cannot('export data')
    <p>You don't have permission to export data.</p>
@endcannot
```

### Menambah Role Baru

1. Buat role:

```php
$role = Role::create(['name' => 'new-role']);
```

2. Assign permissions:

```php
$role->givePermissionTo(['permission1', 'permission2']);
```

3. Assign ke user:

```php
$user->assignRole('new-role');
```

## Customization

### Menambah Field ke User

1. Buat migration:

```bash
php artisan make:migration add_fields_to_users_table
```

2. Update model dan form sesuai kebutuhan

### Menambah Module Baru

1. Buat controller:

```bash
php artisan make:controller NewModuleController --resource
```

2. Buat model & migration:

```bash
php artisan make:model NewModule -m
```

3. Tambahkan routes di `routes/web.php`
4. Buat views sesuai kebutuhan
5. Tambahkan permission baru di seeder

## Troubleshooting

### Permission Middleware Error

Pastikan middleware sudah terdaftar di `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
    ]);
})
```

### Service Provider Error

Pastikan provider sudah terdaftar di `bootstrap/providers.php`:

```php
return [
    App\Providers\AppServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
];
```

## License

MIT License
