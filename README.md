# ---------------------------------------------------
# Event Booking System — Backend Setup (Laravel 12)
# ---------------------------------------------------

# 1. Clone the repository
git clone https://github.com/mohsincoder11/event-booking.git
cd event-booking

# 2. Install PHP dependencies
composer install

# 3. Copy the example environment file
cp .env.example .env

# 4. Edit the .env file to set your database credentials
 Open .env in your favorite editor and configure:
 DB_CONNECTION=mysql
 DB_HOST=127.0.0.1
 DB_PORT=3306
 DB_DATABASE=your_database_name
 DB_USERNAME=your_database_user
 DB_PASSWORD=your_database_password

# Optional: set other settings like MAIL, QUEUE, CACHE if needed

# 5. Generate the Laravel application key
php artisan key:generate

# 6. Run database migrations
php artisan migrate

# 7. Seed the database with sample data
php artisan db:seed
# Seeded data includes:
 - 2 Admin users
 - 3 Organizers
 - 10 Customers
 - 5 Events
 - 15 Tickets
 - 20 Bookings

# 8. Serve the application locally
php artisan serve
The backend will be available at http://127.0.0.1:8000

# 9. Testing the API
- Use Postman or any API client
- Authentication handled via Laravel Sanctum
Example endpoints:
  POST   /api/login       -> User login
  GET    /api/events      -> List events
  POST   /api/bookings    -> Create booking
  GET    /api/users       -> List users (Admin only)

# 10. Notes & Tips
 - Make sure MySQL is running
 - PHP version should be 8.2+
 - Run 'composer dump-autoload' if you add new classes
