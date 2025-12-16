## Office Management System

Office Management System is a simple web-based application developed using Laravel, MySQL and DataTables to efficiently manage company and employee information. It is a CRUD-based system that allows administrators to add, update, view, and manage employee records, assign managers, and maintain structured company data.

**Tech Stack**
Backend Framework: Laravel
Frontend: Blade Templates, Tailwind CSS
Database: MySQL
API Integration: CountriesNow API 
Package Manager: Composer, NPM
Build Tool: Vite


**Prerequisites**
Ensure you have the following installed on your system:
PHP >= 8.2
Composer >= 2.0
Node.js >= 18.x and NPM >= 9.x
MySQL >= 8.0 or MariaDB >= 10.3
Git

**Installation**
Step 1: Clone the Repository
git clone https://github.com/Ishagupta145/office-management-system.git
cd office-management-system

Step 2: Install PHP Dependencies
composer install

Step 3: Install Node Dependencies
npm install

Step 4: Environment Configuration
Copy the example environment file and generate an application key:
cp .env.example .env
php artisan key:generate

**Configuration**
Step 1: Database Configuration
Open the .env file and update the database credentials:
envDB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=office_management
DB_USERNAME=your_database_username
DB_PASSWORD=

Step 2: API Configuration
The application uses the CountriesNow API for location data. No API key is required for basic usage:
COUNTRIESNOW_API_URL=https://countriesnow.space/api/v0.1

(Note: The CountriesNow API is used instead of the Universal Tutorial API due to the bad gateway errors. CountriesNow provides reliable access to country, state, and city data without requiring authentication.)

**Database Setup**
Step 1: Create Database
Create a new MySQL database:
mysql -u root -p
CREATE DATABASE office_management;
EXIT;

Step 2: Run Migrations
Execute the database migrations to create all necessary tables:
php artisan migrate

Step 3: Seed Database (Optional)
Populate the database with sample data:
php artisan db:seed

**Running the Application**
Development Server:- Start the Laravel development server:
php artisan serve
The application will be available at http://localhost:8000

Build Frontend Assets:- In a separate terminal, compile and watch frontend assets:
npm run dev
For production build:
npm run build



## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
