# Office Management System

The **Office Management System** is a simple web-based application built using **Laravel**, **MySQL**, and **DataTables** to efficiently manage company and employee information.  
It provides CRUD operations for employees, manager assignment, and structured location data using a **country–state–city hierarchy**.



## Features

- Manage employees with full **CRUD (Create, Read, Update, Delete)** operations  
- Assign managers and maintain a structured company hierarchy  
- Dynamic country, state, and city selection powered by the **CountriesNow API**  
- Searchable, sortable, and paginated tables using **DataTables**  
- Modern UI using **Blade templates**, **Tailwind CSS**, and **Vite**



## Tech Stack

- **Backend:** Laravel  
- **Frontend:** Blade Templates, Tailwind CSS  
- **Database:** MySQL  
- **API Integration:** CountriesNow API (Country, State, City data)  
- **Package Managers:** Composer, NPM  
- **Build Tool:** Vite  



## Prerequisites

Make sure the following are installed on your system:

- PHP >= 8.2  
- Composer >= 2.0  
- Node.js >= 18.x & NPM >= 9.x  
- MySQL >= 8.0 or MariaDB >= 10.3  
- Git  



## Installation

### 1. Clone the Repository
```bash
git clone https://github.com/Ishagupta145/office-management-system.git
cd office-management-system
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node Dependencies
```bash
npm install
```

### 4. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

## Configuration

### Database Configuration

Update the .env file with your database credentials:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=office_management
DB_USERNAME=your_database_username
DB_PASSWORD=
```

### CountriesNow API Configuration

The application uses the CountriesNow API for location data.
No API key is required for basic usage.
```bash
COUNTRIESNOW_API_URL=https://countriesnow.space/api/v0.1
```
Note: CountriesNow API is used instead of the Universal Tutorial API due to frequent Bad Gateway (502) errors and better reliability without authentication.

## Database Setup
1. Create the Database
```bash
CREATE DATABASE office_management;
```

2. Run Migrations
```bash
php artisan migrate
```

3. (Optional) Seed the Database
```bash
php artisan db:seed
```


## Running the Application
Start the Laravel Server
```bash
php artisan serve
```

The application will be available at: http://localhost:8000 

## Build Frontend Assets

For development:
```bash
npm run dev
```

For production:
```bash
npm run build
```

## Project Status

This is an early-stage office management system created as a learning and demonstration project using Laravel, MySQL, and modern frontend tooling.

Planned future enhancements:

Role-based access control (RBAC)

Advanced reporting and analytics

Deployment configuration and optimization

## License

The Laravel framework is open-sourced software licensed under the MIT License.


