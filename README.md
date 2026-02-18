# School Management System

A Laravel-based REST API for managing school operations including student enrollments, courses, grades, and attendance tracking.

## Table of Contents

- [Setup Steps](#setup-steps)
- [Architecture Explanation](#architecture-explanation)
- [Response Standard Explanation](#response-standard-explanation)
- [API Endpoints](#api-endpoints)

---

## Setup Steps

### Prerequisites

- PHP 8.2 or higher
- PostgreSQL (or any database supported by Laravel)
- Composer
- Node.js & npm/pnpm

### Installation

1. **Clone the repository and navigate to the project directory:**

```bash
cd school-management
```

2. **Install PHP dependencies:**

```bash
composer install
```

3. **Install JavaScript dependencies:**

```bash
npm install
# or
pnpm install
```

4. **Create environment file:**

```bash
cp .env.example .env
```

5. **Generate application key:**

```bash
php artisan key:generate
```

6. **Configure database in `.env`:**

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=school_management
DB_USERNAME=root
DB_PASSWORD=your_password
```

7. **Run database migrations:**

```bash
php artisan migrate
```

8. **Seed the database with sample data:**

```bash
php artisan db:seed
```

This creates:
- 10 sample students
- 10 sample courses
- 1 admin user (email: `ib_admin@gmail.com`, password: `password1@#`)

The seeder will output an admin API token in the console.

9. **Build frontend assets:**

```bash
npm run build
```

10. **Start the development server:**

```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

### Quick Setup (One Command)

Alternatively, you can run the setup script defined in `composer.json`:

```bash
composer run setup
```

### Running Tests

```bash
composer run test
```

---

## Architecture Explanation

### Directory Structure

```
school-management/
├── app/
│   ├── Enums/                    # Enum classes for constants
│   │   ├── AttendanceStatus.php
│   │   └── StudentStatus.php
│   ├── Helpers/                  # Helper classes
│   │   └── ErrorResponse.php
│   ├── Http/
│   │   ├── Controllers/          # Controllers organized by role
│   │   │   ├── Api/
│   │   │   │   ├── Admin/        # Admin-specific controllers
│   │   │   │   ├── Auth/         # Authentication controllers
│   │   │   │   └── Student/      # Student-specific controllers
│   │   │   └── Controller.php    # Base controller with ApiResponse trait
│   │   └── Requests/             # Form Request classes for validation
│   │       ├── Auth/
│   │       ├── Course/Admin/
│   │       ├── Enrollment/Admin/
│   │       ├── Grade/Admin/
│   │       └── User/Admin/
│   ├── Models/                   # Eloquent models
│   │   ├── Attendance.php
│   │   ├── Course.php
│   │   ├── Enrollment.php
│   │   ├── Grade.php
│   │   └── User.php
│   ├── Repositories/             # Repository Pattern Implementation
│   │   ├── Contracts/            # Repository interfaces
│   │   │   ├── BaseRepositoryInterface.php
│   │   │   ├── UserRepositoryInterface.php
│   │   │   └── ...
│   │   └── Eloquent/             # Concrete implementations
│   │       ├── EloquentBaseRepository.php
│   │       ├── EloquentUserRepository.php
│   │       └── ...
│   ├── Rules/                    # Custom validation rules
│   │   └── isEnrolled.php
│   ├── Services/                 # Business logic layer
│   │   └── AuthService.php
│   └── Traits/                   # Reusable traits
│       └── ApiResponse.php
├── database/
│   ├── factories/                # Model factories for testing
│   ├── migrations/               # Database migrations
│   └── seeders/                  # Database seeders
├── routes/
│   ├── api.php                   # API routes
│   ├── web.php                   # Web routes
│   └── console.php               # Console commands
└── tests/                        # Test suites
    ├── Feature/
    └── Unit/
```

### Architectural Patterns

#### 1. Repository Pattern

The project implements the Repository Pattern to abstract data access logic:

- **Contracts/Interfaces** (`app/Repositories/Contracts/`): Define the contract for data operations
  - `BaseRepositoryInterface`: Core CRUD operations
  - Specific interfaces like `UserRepositoryInterface` extend the base

- **Eloquent Implementations** (`app/Repositories/Eloquent/`): Concrete implementations using Eloquent ORM
  - `EloquentBaseRepository`: Base implementation with common CRUD methods
  - Specific repositories extend the base and add domain-specific methods

**Benefits:**
- Separation of concerns between business logic and data access
- Easier testing through dependency injection
- Ability to swap implementations (e.g., Eloquent to a different ORM)

#### 2. Service Layer

Business logic is encapsulated in Service classes (`app/Services/`):

- `AuthService`: Handles authentication logic (login, register, logout)
- Services orchestrate repositories and implement domain-specific operations
- Controllers delegate to services rather than handling logic directly

#### 3. Role-Based Access Control (RBAC)

The API uses Laravel Sanctum for authentication and custom role-based middleware:

- **Admin Role**: Full access to CRUD operations
- **Student Role**: Limited access to view own data only

Routes are protected using middleware groups:
```php
Route::middleware(['auth:sanctum', 'role:admin'])
```

#### 4. Form Request Validation

All input validation is handled by dedicated Form Request classes:

- Located in `app/Http/Requests/`
- Organized by feature and role (e.g., `Course/Admin/StoreCourseRequest`)
- Validation rules are centralized and reusable

#### 5. API Versioning

API routes are versioned using URL prefixes:

```php
Route::prefix('v1')->group(function () {
    // All v1 routes
});
```

---

## Response Standard Explanation

All API responses follow a standardized JSON format defined in `app/Traits/ApiResponse.php`.

### Success Response Format

#### Single Resource Response

```json
{
  "status": "success",
  "message": "User created successfully.",
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  }
}
```

#### Paginated Response

When returning paginated data, the response includes metadata and links:

```json
{
  "status": "success",
  "message": "Courses retrieved successfully.",
  "data": [
    {
      "id": 1,
      "name": "Mathematics 101",
      "description": "Introduction to Mathematics"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 10,
    "total": 50
  },
  "links": {
    "first": "http://localhost:8000/api/v1/admin/courses?page=1",
    "last": "http://localhost:8000/api/v1/admin/courses?page=5",
    "prev": null,
    "next": "http://localhost:8000/api/v1/admin/courses?page=2"
  }
}
```

### Error Response Format

```json
{
  "status": "error",
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password must be at least 8 characters."]
  }
}
```

### Response Methods

The `ApiResponse` trait provides two main methods:

#### `success($data, $message, $code = 200)`

Returns a successful JSON response.

**Parameters:**
- `$data`: The response data (object, array, or paginator)
- `$message`: Human-readable success message
- `$code`: HTTP status code (default: 200)

**Example Usage:**
```php
return $this->success($user, 'User created successfully.', 201);
```

#### `error($message, $code = 400, $errors = null)`

Returns an error JSON response.

**Parameters:**
- `$message`: Human-readable error message
- `$code`: HTTP status code (default: 400)
- `$errors`: Optional detailed error information (validation errors, etc.)

**Example Usage:**
```php
return $this->error('Invalid credentials.', 401);
```

### HTTP Status Codes Used

| Code | Usage |
|------|-------|
| 200 | Successful GET, PUT, PATCH requests |
| 201 | Successful POST requests (resource created) |
| 400 | Bad request (client errors) |
| 401 | Unauthorized (authentication required) |
| 403 | Forbidden (insufficient permissions) |
| 404 | Resource not found |
| 422 | Validation errors |
| 500 | Server errors |

---

## API Endpoints

### Authentication

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/api/v1/auth/register` | Register a new user | No |
| POST | `/api/v1/auth/login` | Login user | No |
| GET | `/api/v1/auth/logout` | Logout user | Yes |

### Admin Routes (Requires Admin Role)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/v1/admin/courses` | List all courses |
| POST | `/api/v1/admin/courses` | Create a new course |
| GET | `/api/v1/admin/courses/{id}` | Get course details |
| PUT/PATCH | `/api/v1/admin/courses/{id}` | Update a course |
| DELETE | `/api/v1/admin/courses/{id}` | Delete a course |
| GET | `/api/v1/admin/students` | List all students |
| POST | `/api/v1/admin/students` | Create a new student |
| GET | `/api/v1/admin/students/{id}` | Get student details |
| PUT/PATCH | `/api/v1/admin/students/{id}` | Update a student |
| DELETE | `/api/v1/admin/students/{id}` | Delete a student |
| POST | `/api/v1/admin/enrollments` | Enroll student in course |
| DELETE | `/api/v1/admin/enrollments/{id}` | Remove enrollment |
| GET | `/api/v1/admin/grades` | List all grades |
| POST | `/api/v1/admin/grades` | Create a grade |
| PUT/PATCH | `/api/v1/admin/grades/{id}` | Update a grade |
| DELETE | `/api/v1/admin/grades/{id}` | Delete a grade |
| GET | `/api/v1/admin/attendance` | List all attendance records |
| GET | `/api/v1/admin/students/{id}/attendance` | Get student's attendance |

### Student Routes (Requires Student Role)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/v1/student/me` | Get current student profile |
| GET | `/api/v1/student/courses` | Get enrolled courses |
| GET | `/api/v1/student/attendance` | Get own attendance records |
| POST | `/api/v1/student/attendance/check-in` | Check-in attendance |
| POST | `/api/v1/student/attendance/check-out` | Check-out attendance |
| GET | `/api/v1/student/grades` | Get own grades |

### Postman Collection

Import the `School-Management.postman_collection.json` file into Postman for complete API documentation and testing.

---

## License

This project is open-sourced software licensed under the MIT license.
