# Orders API

A Laravel-based RESTful API for managing customer orders.

## Features

- Create new orders with multiple products
- Retrieve order details
- Automatic total price calculation
- Data validation
- API documentation with Swagger/OpenAPI

## Technology Stack

- PHP 8.1+
- Laravel 11
- SQLite database
- OpenAPI/Swagger for documentation

## Architecture

The project follows clean architecture principles with:
- Repository Pattern
- Service Layer
- Data Transfer Objects (DTOs)
- API Resources
- Form Requests for validation

## Installation

1. Clone the repository:
```bash
git clone https://github.com/dennlon/orders-api.git
cd orders-api
```

2. Install dependencies:
```bash
composer install
```

3. Create environment file:
```bash
cp .env.example .env
php artisan key:generate
```

4. Create SQLite database:
```bash
touch database/database.sqlite
```

5. Run migrations and seeders:
```bash
php artisan migrate --seed
```

## API Documentation

The API documentation is available at `/api/documentation` when running the application.

To regenerate the documentation:
```bash
php artisan l5-swagger:generate
```

## API Endpoints

### Create Order
- **POST** `/api/orders`
- Creates a new order with products

### Get Order
- **GET** `/api/orders/{id}`
- Retrieves order details by ID

## Testing

Run the test suite:
```bash
php artisan test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
