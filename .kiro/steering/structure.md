# Project Structure

## Laravel Application Structure

### Core Application (`app/`)

```
app/
├── Http/
│   ├── Controllers/        # Route controllers
│   │   ├── Admin/         # Admin-only controllers (UserController, RoleController)
│   │   ├── AuthController # Authentication logic
│   │   ├── BlogController # Blog CRUD operations
│   │   ├── ProjectController # Project CRUD operations
│   │   └── DashboardController # Dashboard with statistics
│   └── Requests/          # Form request validation classes
│       ├── LoginRequest
│       ├── Store/UpdateBlogRequest
│       ├── Store/UpdateProjectRequest
│       ├── Store/UpdateUserRequest
│       └── Store/UpdateRoleRequest
├── Models/                # Eloquent models
│   ├── User.php          # User model with roles
│   ├── Blog.php          # Blog model
│   └── Project.php       # Project model
└── Providers/            # Service providers
    └── AppServiceProvider.php
```

### Frontend Resources (`resources/`)

```
resources/
├── css/
│   └── app.css           # Main stylesheet (TailwindCSS)
├── js/
│   ├── app.js           # Main JavaScript entry
│   └── bootstrap.js     # Bootstrap configuration
└── views/               # Blade templates
    ├── layouts/
    │   └── app.blade.php # Main layout template
    ├── auth/
    │   └── login.blade.php # Login form
    ├── admin/           # Admin-only views
    │   ├── users/       # User management views
    │   └── roles/       # Role management views
    ├── blogs/           # Blog management views
    ├── projects/        # Project management views
    ├── dashboard.blade.php # Dashboard view
    └── welcome.blade.php   # Landing page
```

### Database (`database/`)

```
database/
├── migrations/          # Database schema migrations
├── seeders/            # Database seeders
│   └── RolePermissionSeeder.php # Default roles & permissions
├── factories/          # Model factories for testing
└── database.sqlite     # SQLite database file
```

### Configuration (`config/`)

-   Standard Laravel configuration files
-   `permission.php` - Spatie permission configuration
-   `database.php` - Database connections (defaults to SQLite)

### Routes (`routes/`)

-   `web.php` - Web routes with middleware protection
-   `api.php` - API routes (if needed)
-   `console.php` - Artisan commands

## Naming Conventions

### Controllers

-   Use singular nouns: `BlogController`, `ProjectController`
-   Admin controllers in `Admin/` namespace
-   Resource controllers for CRUD operations

### Models

-   Singular nouns: `User`, `Blog`, `Project`
-   Use Eloquent relationships and accessors/mutators

### Views

-   Organized by feature: `blogs/`, `projects/`, `admin/`
-   Use kebab-case for file names
-   Blade templates use `.blade.php` extension

### Permissions

-   Use kebab-case: `manage-blogs`, `view-dashboard`
-   Follow pattern: `action-resource`

### Middleware

-   Permission-based: `middleware('permission:manage-blogs')`
-   Role-based: `middleware('role:Admin')`

## Architecture Patterns

### Authorization

-   Use Spatie Laravel Permission package
-   Check permissions in controllers with `$this->authorize()`
-   Use middleware for route protection
-   Blade directives: `@can()`, `@cannot()`

### Request Validation

-   Separate Form Request classes for validation
-   Store/Update request pairs for each resource
-   Validation rules in dedicated classes

### Database

-   Use migrations for schema changes
-   Seeders for default data (roles, permissions, users)
-   Factories for testing data generation
