# IRRIGATION SYSTEM

Your task is to design and implement a RESTful API for managing an irrigation system. The system should allow users to manage irrigation zones, schedules, and watering events. Additionally, whenever a schedule is created or updated, an email should be sent to the admin (admin@cashcardng.com).

## Requirements

### Zones Management

CRUD a zone

```
{
 "name": "string",
 "area": "string"
}
```

### Schedule Management

```
{
  "start_time": "string",
  "duration": "string",
  "days_of_week": ["string"]
}
```

### Watering Event

1. Start watering a zone
2. Stop watering a zone
3. Get zone watering status

## Acceptance Criteria

#### Zone Management

-   Users can create, retrieve, update, and delete irrigation zones.
-   Users can list all irrigation zones.

#### Schedule Management

-   Users can create, retrieve, update, and delete schedules for specific zones.
-   Users can list all schedules for a specific zone.
-   An email is sent to the admin whenever a schedule is created or updated.

#### Watering Events

-   Users can start and stop watering for a specific zone.
-   Users can retrieve the current status of a specific zone (watering or stopped).

#### Email Notification

-   An email is sent to the admin email address provided in the configuration whenever a schedule is created or updated.

## Additional Considerations

-   Authentication & Authorization: Ensure only authorized users can manage zones and schedules.
-   Validation: Validate the input data for creating and updating zones and schedules.
-   Error Handling: Proper error messages for cases like invalid zone ID, schedule conflicts, etc.

NB: Solution should be in Laravel 8+

# Irrigation System API

A RESTful API for managing an irrigation system built with Laravel 8. The system allows users to manage irrigation zones, schedules, and watering events.

## Features

-   Zone Management (CRUD operations)
-   Schedule Management (CRUD operations with email notifications)
-   Watering Events (Start, Stop, Status)
-   Authentication & Authorization
-   Validation & Error Handling

## Requirements

-   PHP 7.3+
-   Composer
-   MySQL or compatible database
-   SMTP server for email notifications

## Installation

1. Clone the repository

```bash
git clone https://github.com/yourusername/irrigation-system.git
cd irrigation-system
```

2. Install dependencies

```bash
composer install
```

3. Copy the .env.example file to .env and configure your environment

```bash
cp .env.example .env
```

4. Generate an application key

```bash
php artisan key:generate
```

5. Configure your database in the .env file

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=irrigation_system
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Configure mail settings in the .env file

```
MAIL_MAILER=smtp
MAIL_HOST=your_mail_host
MAIL_PORT=your_mail_port
MAIL_USERNAME=your_mail_username
MAIL_PASSWORD=your_mail_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@irrigationsystem.com
MAIL_FROM_NAME="${APP_NAME}"
```

7. Run migrations and seed the database

```bash
php artisan migrate --seed
```

8. Start the development server

```bash
php artisan serve
```

## API Documentation

### Authentication

-   `POST /api/register` - Register a new user
-   `POST /api/login` - Login and get access token
-   `POST /api/logout` - Logout (requires authentication)

### Zone Management

-   `GET /api/zones` - List all zones
-   `POST /api/zones` - Create a new zone
-   `GET /api/zones/{zone}` - Get a specific zone
-   `PUT /api/zones/{zone}` - Update a zone
-   `DELETE /api/zones/{zone}` - Delete a zone

### Schedule Management

-   `GET /api/zones/{zone}/schedules` - List all schedules for a zone
-   `POST /api/zones/{zone}/schedules` - Create a new schedule for a zone
-   `GET /api/zones/{zone}/schedules/{schedule}` - Get a specific schedule
-   `PUT /api/zones/{zone}/schedules/{schedule}` - Update a schedule
-   `DELETE /api/zones/{zone}/schedules/{schedule}` - Delete a schedule

### Watering Events

-   `POST /api/zones/{zone}/watering/start` - Start watering a zone
-   `POST /api/zones/{zone}/watering/stop` - Stop watering a zone
-   `GET /api/zones/{zone}/watering/status` - Get the watering status of a zone

## Testing

Run the PHPUnit tests

```bash
php artisan test
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
