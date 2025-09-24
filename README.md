# Event Booking System — Backend

## Overview

This is a backend-only Event Booking System built with Laravel 12, following industry-standard best practices.  

Features include:

- RESTful APIs  
- Authentication & Authorization with Laravel Sanctum  
- Role-based access control (Admin / Organizer / Customer)  
- Event, Ticket, Booking, and Payment management  
- Middleware, Services, Traits, Notifications, Queues, Caching  
- Soft deletes, factories, migrations, and seeders  

---

## Requirements

- PHP 8.2+  
- Composer  
- MySQL 8+  
- Laravel 12  

---

## Installation & Setup

1. Clone the repository:

```bash
git clone https://github.com/mohsincoder11/event-booking.git
cd event-booking

composer install


cp .env.example .env

set up database

php artisan migrate

php artisan db:seed
Seeded data includes:

2 Admin users

3 Organizers

10 Customers

5 Events

15 Tickets

20 Bookings

php artisan serve

test using the postman
