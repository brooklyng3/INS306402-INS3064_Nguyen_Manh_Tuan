# School Management System (Session 08)

A robust, custom-built PHP/MySQL CRUD application designed to manage school operations, including students, courses, enrollments, and teachers. This project demonstrates secure architecture, custom error handling, and environment-specific configuration.

## 🚀 Features

* **Four Complete CRUD Modules:** Manage Students, Courses, Enrollments, and Teachers.
* **Custom Exception Handling:** Implements a centralized `ValidationException` class to cleanly separate user-input errors from system-level database failures.
* **Secure Environment Configuration:** Utilizes an `env.php` toggle to display errors during development and safely log them to a private file during production to prevent Information Disclosure.
* **Advanced Data Retrieval:** Features complex MySQL queries to handle pagination (10 records per page) and dynamic dropdown filtering within the Enrollments module.
* **Unified UI/UX:** A global CSS stylesheet provides a clean, responsive, and consistent user interface across all modules.
* **Security Best Practices:** Uses `htmlspecialchars()` to prevent XSS attacks and PDO prepared statements to prevent SQL Injection.

## 📁 Project Structure

```text
session_08_enrollment_app/
├── assets/
│   └── css/
│       └── style.css            # Global stylesheet
├── classes/
│   ├── Database.php             # Singleton PDO database wrapper
│   └── ValidationException.php  # Custom error handling class
├── config/
│   ├── database.example.php     # Safe configuration template (Tracked in Git)
│   ├── database.php             # Local credentials (Ignored in Git)
│   └── env.php                  # Environment toggle (dev/prod)
├── courses/                     # Courses CRUD module
├── database/
│   └── school_db.sql            # Exported database schema and seed data
├── enrollments/                 # Enrollments CRUD module
├── students/                    # Students CRUD module
├── teachers/                    # Teachers CRUD module
├── index.php                    # Main dashboard navigation
├── .gitignore                   # Secures local database credentials
└── README.md                    # Project documentation

Prerequisites
PHP 8.0 or higher

MySQL / MariaDB

Local server environment (XAMPP, MAMP, or LAMP stack)

⚙️ Installation & Setup
Clone the repository:
Download or clone this repository to your local server directory (e.g., htdocs for XAMPP).

Database Setup:

Open phpMyAdmin (or your preferred SQL client).

Create a new database named school_db.

Import the provided SQL file located at database/school_db.sql to generate the tables and fake data.

Configuration:

Navigate to the config/ directory.

Duplicate database.example.php and rename the copy to database.php.

Open the new database.php and update the database credentials (username/password) to match your local environment.

Run the Application:

Ensure your local Apache and MySQL servers are running.

Navigate to the project root in your browser (e.g., http://localhost/session_08/index.php).

🛡️ Environment Management
To test the application's secure error logging, open config/env.php and change the ENVIRONMENT constant:

'development': Displays all PHP and database errors directly on the screen for easy debugging.

'production': Hides stack traces from the UI and securely writes them to a logs/php_error.log file.

✍️ Author
Nguyễn Mạnh Tuấn ```