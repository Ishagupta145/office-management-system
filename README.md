# Office Management System

Office Management System is a simple web-based application developed using Laravel, MySQL and DataTables to efficiently manage company and employee information. It is a CRUD-based system that allows administrators to add, update, view, and manage employee records, assign managers, and maintain structured company data.

**Tech Stack**
1. Backend Framework: Laravel
2. Frontend: Blade Templates, Tailwind CSS
3. Database: MySQL
4. API Integration: CountriesNow API 
5. Package Manager: Composer, NPM
6. Build Tool: Vite


**Prerequisites**
Ensure you have the following installed on your system:
1. PHP >= 8.2
2. Composer >= 2.0
3. Node.js >= 18.x and NPM >= 9.x
4. MySQL >= 8.0 or MariaDB >= 10.3
5. Git

## Installation
Step 1: Clone the Repository
1. git clone https://github.com/Ishagupta145/office-management-system.git
2. cd office-management-system

Step 2: Install PHP Dependencies
1. composer install

Step 3: Install Node Dependencies
1. npm install

Step 4: Environment Configuration
Copy the example environment file and generate an application key:
1. cp .env.example .env
2. php artisan key:generate

**Configuration**
Step 1: Database Configuration
Open the .env file and update the database credentials:
1. envDB_CONNECTION=mysql
2. DB_HOST=127.0.0.1
3. DB_PORT=3307
4. DB_DATABASE=office_management
5. DB_USERNAME=your_database_username
6. DB_PASSWORD=

Step 2: API Configuration
The application uses the CountriesNow API for location data. No API key is required for basic usage:
COUNTRIESNOW_API_URL=https://countriesnow.space/api/v0.1

(Note: The CountriesNow API is used instead of the Universal Tutorial API due to the bad gateway errors. CountriesNow provides reliable access to country, state, and city data without requiring authentication.)

**Database Setup**
Step 1: Create Database
Create a new MySQL database:
1. mysql -u root -p
2. CREATE DATABASE office_management;
3. EXIT;

Step 2: Run Migrations
Execute the database migrations to create all necessary tables:
1. php artisan migrate

Step 3: Seed Database (Optional)
Populate the database with sample data:
php artisan db:seed

**Running the Application**
Development Server:- Start the Laravel development server:
1. php artisan serve

(The application will be available at http://localhost:8000)

Build Frontend Assets:- In a separate terminal, compile and watch frontend assets:
npm run dev
For production build:
npm run build



## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
