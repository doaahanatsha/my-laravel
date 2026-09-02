# Volunteer Coordination API

A Laravel-based REST API for coordinating volunteers and assigning them to tasks across different work locations.

This project was built as part of the Back-End (Laravel) training track.

## Requirements

- PHP 8.2+
- Composer
- MySQL or PostgreSQL
- Laravel 13

## Installation

Clone the repository:

```bash
git clone https://github.com/doaahanatsha/my-laravel.git
cd my-laravel
```

Install dependencies:

```bash
composer install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure your database credentials in the `.env` file.

Run the migrations:

```bash
php artisan migrate
```

Seed the database:

```bash
php artisan db:seed
```

Start the development server:

```bash
php artisan serve
```

The API will be available at:

```text
http://127.0.0.1:8000
```

## Test Credentials

The database seeders create the following test accounts:

| Role | Email | Password |
|---|---|---|
| Admin | admin@gmail.com | 12345678 |
| Volunteer | volunteer@gmail.com | 12345678 |

The Volunteer account also has a volunteer profile.

## Authentication

The API uses Laravel Sanctum for token-based authentication.

Login:

```text
POST /api/login
```

The login response provides an authentication token.

For protected endpoints, send the token using:

```text
Authorization: Bearer <token>
```

## API Endpoints

### Authentication

| Method | Endpoint | Access |
|---|---|---|
| POST | `/api/register` | Public |
| POST | `/api/login` | Public |
| POST | `/api/logout` | Authenticated |

### Profile

| Method | Endpoint | Access |
|---|---|---|
| GET | `/api/me` | Volunteer |
| PUT | `/api/me` | Volunteer |

These endpoints operate on the currently authenticated volunteer's own profile.

### Work Locations

| Method | Endpoint | Access |
|---|---|---|
| GET | `/api/work-locations` | Admin + Volunteer |
| GET | `/api/work-locations/{id}` | Admin + Volunteer |
| POST | `/api/work-locations` | Admin |
| PUT/PATCH | `/api/work-locations/{id}` | Admin |
| DELETE | `/api/work-locations/{id}` | Admin |

Volunteers can view work locations but cannot create, update, or delete them.

### Tasks

| Method | Endpoint | Access |
|---|---|---|
| GET | `/api/tasks` | Admin + Volunteer |
| GET | `/api/tasks/{id}` | Admin + Volunteer |
| POST | `/api/tasks` | Admin |
| PUT/PATCH | `/api/tasks/{id}` | Admin |
| DELETE | `/api/tasks/{id}` | Admin |

Volunteers can view tasks but cannot create, update, or delete them.

### Volunteers

| Method | Endpoint | Access |
|---|---|---|
| GET | `/api/volunteers` | Admin |
| GET | `/api/volunteers/{id}` | Admin |
| POST | `/api/volunteers` | Admin |
| PUT/PATCH | `/api/volunteers/{id}` | Admin |
| DELETE | `/api/volunteers/{id}` | Admin |

Volunteer management is restricted to administrators.

### Assignments

| Method | Endpoint | Access |
|---|---|---|
| GET | `/api/assignments` | Admin |
| GET | `/api/assignments/{id}` | Admin |
| POST | `/api/assignments` | Admin |
| PUT/PATCH | `/api/assignments/{id}` | Admin |
| DELETE | `/api/assignments/{id}` | Admin |
| GET | `/api/my-assignments` | Volunteer |

The `/api/my-assignments` endpoint returns only assignments belonging to the currently authenticated volunteer.

A volunteer cannot use this endpoint to access another volunteer's assignments.

## Authorization

The API uses role-based authorization to separate Admin and Volunteer permissions.

### Admin

Administrators can:

- Manage work locations.
- Manage tasks.
- Manage volunteers.
- Create, update, and delete assignments.
- View all assignments.

Admin-only routes are protected by the `admin` middleware.

### Volunteer

Volunteers can:

- View work locations.
- View tasks.
- View their own profile.
- Update their own profile.
- View their own assignments.

Volunteers cannot access admin-only operations.

An authenticated volunteer attempting an admin-only operation receives:

```text
403 Forbidden
```

## Validation

The project uses Laravel Form Requests for request validation.

Invalid request data returns:

```text
422 Unprocessable Entity
```

Assignment validation uses `exists` rules to make sure that referenced volunteers, work locations, and tasks exist in the database.

## Error Handling

The API uses standard HTTP status codes:

| Status | Meaning |
|---|---|
| 200 | Successful request |
| 201 | Resource created |
| 401 | Unauthenticated |
| 403 | Forbidden |
| 404 | Resource not found |
| 422 | Validation error |

Laravel Route Model Binding is used for resource endpoints, so requesting a non-existing resource returns `404 Not Found`.

## API Resources

The project uses Laravel API Resources to structure API responses.

Resources include:

- `AssignmentResource`
- `VolunteerResource`
- `TaskResource`
- `WorkLocationResource`

These resources control the structure of returned API data and include the required relationship information.

## Eloquent Relationships

The project uses Eloquent relationships between the main models:

- `User` has one `Volunteer`.
- `Volunteer` belongs to a `User`.
- `Volunteer` has many `Assignments`.
- `Assignment` belongs to a `Volunteer`.
- `Assignment` belongs to a `Task`.
- `Assignment` belongs to a `WorkLocation`.

## Main Models

- User
- Volunteer
- Task
- WorkLocation
- Assignment

## Database Seeders

The project includes:

- `AdminSeeder`
- `VolunteerSeeder`

The main `DatabaseSeeder` calls both seeders.

Run:

```bash
php artisan db:seed
```

This creates the default Admin and Volunteer test accounts.

## Testing

The API was tested using Postman.

Testing covers:

- Admin authentication.
- Volunteer authentication.
- Protected endpoints.
- Admin-only authorization.
- Volunteer access to authenticated resources.
- `403 Forbidden` for unauthorized volunteer actions.
- `401 Unauthorized` for unauthenticated requests.
- `404 Not Found` for non-existing resources.
- `422 Unprocessable Entity` for validation errors.
- Assignment creation.
- Assignment update.
- Assignment deletion.
- Retrieving the authenticated volunteer's assignments.
- Preventing volunteers from accessing another volunteer's assignments.

## Project Structure

```text
app/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   ├── Requests/
│   └── Resources/
├── Models/
└── Policies/

database/
├── migrations/
└── seeders/

routes/
└── api.php
```

## Tech Stack

- PHP 8.2+
- Laravel 12
- Laravel Sanctum
- Eloquent ORM
- MySQL / PostgreSQL
- Postman

## API Base URL

When running the application locally:

```text
http://127.0.0.1:8000/api
```

## Repository

GitHub repository:

https://github.com/doaahanatsha/my-laravel

## Postman Collection

A Postman collection for testing the API endpoints for both Admin and Volunteer roles is included in the project repository.

## License

This project was created as part of the Back-End (Laravel) training track.