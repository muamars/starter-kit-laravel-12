# Setup Guide - Laravel Starter Kit

Panduan lengkap step by step untuk setup Laravel starter kit dengan role & permission dari awal.

## Step 1: Persiapan Project Laravel

### 1.1 Install Laravel Baru

```bash
composer create-project laravel/laravel laravel-starter-kit
cd laravel-starter-kit
```

### 1.2 Install Package Dependencies

```bash
# Install Spatie Permission
composer require spatie/laravel-permission

# Install Laravel UI (untuk authentication)
composer require laravel/ui
php artisan ui bootstrap --auth
npm install && npm run build
```

## Step 2: Database Setup

### 2.1 Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_starter
DB_USERNAME=root
DB_PASSWORD=
```

### 2.2 Publish & Migrate Spatie Permission

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

## Step 3: Model Setup

### 3.1 Update User Model

Tambahkan trait ke `app/Models/User.php`:

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    // ... rest of the model
}
```

### 3.2 Buat Model Blog

```bash
php artisan make:model Blog -m
```

Edit migration `database/migrations/create_blogs_table.php`:

```php
Schema::create('blogs', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('content');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->timestamps();
});
```

### 3.3 Buat Model Project

```bash
php artisan make:model Project -m
```

Edit migration `database/migrations/create_projects_table.php`:

```php
Schema::create('projects', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->timestamps();
});
```

### 3.4 Jalankan Migration

```bash
php artisan migrate
```

## Step 4: Seeder Setup

### 4.1 Buat Role Permission Seeder

```bash
php artisan make:seeder RolePermissionSeeder
```

### 4.2 Update DatabaseSeeder

Edit `database/seeders/DatabaseSeeder.php`:

```php
public function run(): void
{
    $this->call([
        RolePermissionSeeder::class,
    ]);
}
```

## Step 5: Middleware Setup

### 5.1 Register Middleware

Edit `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
    ]);
})
```

### 5.2 Register Service Provider

Edit `bootstrap/providers.php`:

```php
return [
    App\Providers\AppServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
];
```

## Step 6: Controllers

### 6.1 Buat Controllers

```bash
php artisan make:controller DashboardController
php artisan make:controller BlogController --resource
php artisan make:controller ProjectController --resource
php artisan make:controller Admin/UserController --resource
php artisan make:controller Admin/RoleController --resource
```

### 6.2 Update AuthController

```bash
php artisan make:controller AuthController
```

## Step 7: Views Setup

### 7.1 Buat Layout Utama

Buat `resources/views/layouts/app.blade.php`

### 7.2 Buat Views untuk setiap module:

-   Dashboard: `resources/views/dashboard.blade.php`
-   Auth: `resources/views/auth/login.blade.php`
-   Blogs: `resources/views/blogs/{index,create,edit,show}.blade.php`
-   Projects: `resources/views/projects/{index,create,edit,show}.blade.php`
-   Admin Users: `resources/views/admin/users/{index,create,edit,show}.blade.php`
-   Admin Roles: `resources/views/admin/roles/{index,create,edit,show}.blade.php`

## Step 8: Routes Setup

### 8.1 Update Web Routes

Edit `routes/web.php` dengan semua routes yang diperlukan.

## Step 9: Styling

### 9.1 Update CSS

Edit `resources/css/app.css` untuk styling yang konsisten.

## Step 10: Testing & Seeding

### 10.1 Jalankan Seeder

```bash
php artisan db:seed
```

### 10.2 Test Login

-   Admin: admin@example.com / password
-   Writer: writer@example.com / password
-   Manager: manager@example.com / password

## Step 11: Final Check

### 11.1 Start Server

```bash
php artisan serve
```

### 11.2 Test Semua Fitur

1. Login dengan berbagai role
2. Test akses dashboard
3. Test CRUD blogs (Writer)
4. Test CRUD projects (Manager)
5. Test user management (Admin)
6. Test role management (Admin)

## Troubleshooting Common Issues

### Issue 1: Middleware Permission tidak terdaftar

**Error:** `Target class [permission] does not exist`

**Solution:** Pastikan middleware sudah terdaftar di `bootstrap/app.php`

### Issue 2: Service Provider tidak terdaftar

**Error:** Permission-related errors

**Solution:** Pastikan `Spatie\Permission\PermissionServiceProvider::class` ada di `bootstrap/providers.php`

### Issue 3: Dashboard blank

**Error:** Dashboard tidak menampilkan data

**Solution:** Pastikan user sudah login dan memiliki permission `view-dashboard`

### Issue 4: Migration error

**Error:** Table already exists

**Solution:**

```bash
php artisan migrate:fresh --seed
```

## Tips Development

1. **Selalu test dengan berbagai role** untuk memastikan authorization bekerja
2. **Gunakan middleware permission** di routes untuk proteksi
3. **Buat seeder yang comprehensive** untuk testing
4. **Dokumentasikan permission baru** yang ditambahkan
5. **Test authorization di controller** dengan `$this->authorize()`

## Next Steps

Setelah setup dasar selesai, Anda bisa:

1. Menambah module baru (Categories, Tags, dll)
2. Implementasi API endpoints
3. Menambah fitur upload file
4. Implementasi notification system
5. Menambah audit trail
6. Implementasi caching
7. Setup testing (PHPUnit)

Starter kit ini memberikan foundation yang solid untuk development aplikasi Laravel dengan sistem role & permission yang robust.

## Step 12: Form Request Classes (Bonus)

### 12.1 Buat Form Request Classes

```bash
php artisan make:request LoginRequest
php artisan make:request StoreBlogRequest
php artisan make:request UpdateBlogRequest
php artisan make:request StoreProjectRequest
php artisan make:request UpdateProjectRequest
php artisan make:request StoreUserRequest
php artisan make:request UpdateUserRequest
php artisan make:request StoreRoleRequest
php artisan make:request UpdateRoleRequest
```

### 12.2 Keuntungan Form Request

-   **Separation of Concerns** - Validation logic terpisah dari controller
-   **Reusable** - Bisa digunakan di multiple controller
-   **Authorization** - Built-in authorization check
-   **Custom Messages** - Error messages yang customizable
-   **Cleaner Controllers** - Controller lebih fokus ke business logic

### 12.3 Contoh Form Request

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('manage-blogs');
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul blog wajib diisi.',
            'content.required' => 'Konten blog wajib diisi.',
        ];
    }
}
```

### 12.4 Update Controllers

Ganti `Request $request` dengan Form Request yang sesuai:

```php
// Sebelum
public function store(Request $request)
{
    $validated = $request->validate([...]);
}

// Sesudah
public function store(StoreBlogRequest $request)
{
    $validated = $request->validated();
}
```

## Best Practices untuk Form Request

1. **Naming Convention**

    - Store: `Store{Model}Request`
    - Update: `Update{Model}Request`
    - Custom: `{Action}{Model}Request`

2. **Authorization**

    - Gunakan `authorize()` method untuk permission check
    - Return `true` jika tidak ada authorization khusus

3. **Validation Rules**

    - Pisahkan rules yang berbeda untuk store vs update
    - Gunakan conditional rules jika diperlukan

4. **Custom Messages**

    - Selalu sediakan pesan error dalam bahasa yang sesuai
    - Gunakan pesan yang user-friendly

5. **Error Handling**
    - Form Request otomatis redirect dengan errors
    - Untuk API, override `failedValidation()` method

## API dan Web Controller - Gunakan Form Request yang Sama

### ✅ **Rekomendasi: Gunakan Form Request yang sama untuk Web dan API**

### Keuntungan:

-   **DRY Principle** - Tidak ada duplikasi validation
-   **Consistency** - Rules sama antara web dan API
-   **Maintainability** - Satu tempat untuk update validation
-   **Auto Error Handling** - Laravel otomatis handle response format
-   **Authorization** - Permission check tetap sama

### 🔧 Implementasi:

```php
// Web method
public function store(StoreBlogRequest $request)
{
    $validated = $request->validated();
    // ... business logic
    return redirect()->route('blogs.index');
}

// API method - gunakan Form Request yang sama
public function apiStore(StoreBlogRequest $request)
{
    $validated = $request->validated(); // Rules yang sama!
    // ... business logic yang sama
    return response()->json($blog, 201);
}
```

### 📝 Error Response Otomatis:

-   **Web Request**: Redirect dengan session errors
-   **API Request**: JSON response dengan validation errors
-   Laravel otomatis detect berdasarkan `Accept` header

### 🚫 **Hindari membuat Form Request terpisah untuk API** kecuali:

-   API membutuhkan validation rules yang benar-benar berbeda
-   API membutuhkan authorization logic yang berbeda
-   Ada business requirement khusus untuk API

### 💡 Tips:

1. Pastikan Form Request include semua field yang dibutuhkan web dan API
2. Gunakan `nullable` atau `sometimes` untuk field optional
3. Laravel otomatis handle error format berdasarkan request type

## Step 13: Menambah Permission & Role Baru

### 13.1 Menambah Permission Baru

#### A. Edit Seeder

Edit `database/seeders/RolePermissionSeeder.php`:

```php
$permissions = [
    // Blog permissions
    'view blogs',
    'create blogs',
    'edit blogs',
    'delete blogs',

    // Project permissions
    'view projects',
    'create projects',
    'edit projects',
    'delete projects',

    // User management permissions
    'view users',
    'create users',
    'edit users',
    'delete users',

    // Role management permissions
    'view roles',
    'create roles',
    'edit roles',
    'delete roles',

    // ✅ TAMBAHKAN PERMISSION BARU DI SINI
    'manage categories',
    'export data',
    'view reports',
    'manage settings',
    'view analytics',
];
```

#### B. Assign Permission ke Role

```php
// Assign permissions to roles
$adminRole->givePermissionTo(Permission::all()); // Admin dapat semua

$writerRole->givePermissionTo([
    'view blogs',
    'create blogs',
    'edit blogs',
    'delete blogs',
    'manage categories', // ✅ Tambahkan ke Writer
]);

$managerRole->givePermissionTo([
    'view projects',
    'create projects',
    'edit projects',
    'delete projects',
    'view reports',     // ✅ Tambahkan ke Manager
    'export data',      // ✅ Tambahkan ke Manager
]);

// ✅ BUAT ROLE BARU
$analystRole = Role::create(['name' => 'Analyst']);
$analystRole->givePermissionTo([
    'view reports',
    'view analytics',
    'export data',
]);
```

#### C. Jalankan Seeder

```bash
# Option 1: Reset semua data
php artisan migrate:fresh --seed

# Option 2: Hanya jalankan seeder (jika tidak ada perubahan struktur)
php artisan db:seed --class=RolePermissionSeeder

# Option 3: Buat seeder khusus untuk permission baru
php artisan make:seeder NewPermissionSeeder
php artisan db:seed --class=NewPermissionSeeder
```

### 13.2 Menggunakan Permission di Code

#### A. Di Controller

```php
<?php

namespace App\Http\Controllers;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view categories')->only(['index', 'show']);
        $this->middleware('permission:manage categories')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        // Method 1: Manual check
        if (!auth()->user()->can('view categories')) {
            abort(403, 'Unauthorized action.');
        }

        // Method 2: Authorization (recommended)
        $this->authorize('view categories');

        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        // Sudah di-handle oleh middleware, tapi bisa double check
        $this->authorize('manage categories');

        return view('categories.create');
    }
}
```

#### B. Di Routes

```php
// routes/web.php

// Single route dengan permission
Route::get('/reports', [ReportController::class, 'index'])
    ->middleware('permission:view reports');

// Group routes dengan permission yang sama
Route::middleware(['auth', 'permission:export data'])->group(function () {
    Route::get('/export/users', [ExportController::class, 'users']);
    Route::get('/export/blogs', [ExportController::class, 'blogs']);
    Route::get('/export/projects', [ExportController::class, 'projects']);
});

// Multiple permissions (user harus punya salah satu)
Route::get('/admin-panel', [AdminController::class, 'index'])
    ->middleware('permission:manage users|manage roles');

// Multiple permissions (user harus punya semua)
Route::get('/super-admin', [SuperAdminController::class, 'index'])
    ->middleware(['permission:manage users', 'permission:manage roles']);
```

#### C. Di Blade Views

```blade
{{-- resources/views/layouts/app.blade.php --}}

<nav class="navbar">
    <ul class="nav">
        {{-- Semua user yang login bisa lihat dashboard --}}
        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>

        {{-- Hanya user dengan permission tertentu --}}
        @can('view blogs')
            <li><a href="{{ route('blogs.index') }}">Blogs</a></li>
        @endcan

        @can('view projects')
            <li><a href="{{ route('projects.index') }}">Projects</a></li>
        @endcan

        @can('manage categories')
            <li><a href="{{ route('categories.index') }}">Categories</a></li>
        @endcan

        {{-- Admin menu --}}
        @canany(['manage users', 'manage roles'])
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">Admin</a>
                <ul class="dropdown-menu">
                    @can('manage users')
                        <li><a href="{{ route('admin.users.index') }}">Users</a></li>
                    @endcan
                    @can('manage roles')
                        <li><a href="{{ route('admin.roles.index') }}">Roles</a></li>
                    @endcan
                </ul>
            </li>
        @endcanany

        {{-- Reports menu --}}
        @can('view reports')
            <li><a href="{{ route('reports.index') }}">Reports</a></li>
        @endcan

        @can('export data')
            <li><a href="{{ route('export.index') }}">Export</a></li>
        @endcan
    </ul>
</nav>
```

#### D. Di Form Request

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('manage categories');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }
}
```

### 13.3 Permission Dinamis (Runtime)

#### A. Buat Permission Baru via Code

```php
// Di controller atau command
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

// Buat permission baru
$permission = Permission::create(['name' => 'manage inventory']);

// Assign ke role yang sudah ada
$adminRole = Role::findByName('Admin');
$adminRole->givePermissionTo('manage inventory');

// Assign ke user langsung
$user = User::find(1);
$user->givePermissionTo('manage inventory');
```

#### B. Buat Role Baru via Code

```php
// Buat role baru
$supervisorRole = Role::create(['name' => 'Supervisor']);

// Assign multiple permissions
$supervisorRole->givePermissionTo([
    'view reports',
    'export data',
    'manage categories',
]);

// Assign role ke user
$user = User::find(1);
$user->assignRole('Supervisor');
```

### 13.4 Best Practices Permission

#### A. Naming Convention

```php
// ✅ Good - Descriptive dan konsisten
'view blogs'
'create blogs'
'edit blogs'
'delete blogs'
'manage categories'
'export users'
'view reports'

// ❌ Bad - Tidak konsisten
'blog-view'
'createBlog'
'EDIT_BLOG'
'blogs.delete'
```

#### B. Granular vs Grouped

```php
// ✅ Granular (Recommended) - Lebih flexible
'view blogs'
'create blogs'
'edit blogs'
'delete blogs'

// ⚠️ Grouped - Kurang flexible tapi lebih simple
'manage blogs' // covers all CRUD operations
```

#### C. Permission Hierarchy

```php
// Level 1: Basic permissions
'view blogs'
'create blogs'

// Level 2: Advanced permissions
'publish blogs'
'feature blogs'

// Level 3: Admin permissions
'manage all blogs' // bisa edit blog user lain
'delete any blogs' // bisa delete blog user lain
```

### 13.5 Testing Permissions

#### A. Manual Testing

```bash
# Login sebagai user dengan role berbeda
# Test akses ke berbagai halaman
# Pastikan 403 error muncul untuk unauthorized access
```

#### B. Unit Testing

```php
// tests/Feature/PermissionTest.php
public function test_writer_can_create_blog()
{
    $writer = User::factory()->create();
    $writer->assignRole('Writer');

    $this->actingAs($writer)
         ->post('/blogs', ['title' => 'Test', 'content' => 'Content'])
         ->assertStatus(302); // redirect success
}

public function test_writer_cannot_manage_users()
{
    $writer = User::factory()->create();
    $writer->assignRole('Writer');

    $this->actingAs($writer)
         ->get('/admin/users')
         ->assertStatus(403); // forbidden
}
```

### 13.6 Troubleshooting

#### A. Permission tidak bekerja

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear

# Re-seed permissions
php artisan migrate:fresh --seed
```

#### B. User tidak punya permission setelah assign role

```php
// Check di tinker
php artisan tinker

$user = User::find(1);
$user->roles; // Check roles
$user->permissions; // Check direct permissions
$user->getAllPermissions(); // Check all permissions (role + direct)
$user->can('permission-name'); // Test specific permission
```

Dengan panduan ini, Anda bisa dengan mudah menambah permission dan role baru sesuai kebutuhan aplikasi! 🚀
