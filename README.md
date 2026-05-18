# 🎮 GameStore - Selenium Test Automation Project

A **Software Testing & Quality Assurance** project built with **CodeIgniter 4** and **Selenium WebDriver (PHP)** for automated UI testing of an online game store application.

---

## 📌 Project Overview

This project contains automated test suites for the **GameStore** web application — an e-commerce platform for purchasing digital games. The testing framework uses **PHPUnit** with **Facebook WebDriver** to simulate real browser interactions via Selenium.

---

## 🧪 Test Coverage

| Module         | Test File                      | Test Cases |
|----------------|-------------------------------|------------|
| Login          | `tests/ui/LoginTest.php`       | 9 tests    |
| Register       | `tests/ui/RegisterTest.php`    | 8 tests    |
| Cart           | `tests/ui/CartTest.php`        | ~5 tests   |
| Checkout       | `tests/ui/CheckoutTest.php`    | ~5 tests   |
| Library        | `tests/ui/LibraryTest.php`     | ~5 tests   |
| Profile        | `tests/ui/ProfileTest.php`     | ~4 tests   |
| Admin CRUD     | `tests/ui/AdminCrudTest.php`   | ~6 tests   |

---

## 🛠️ Tech Stack

- **Backend Framework:** CodeIgniter 4 (PHP 8.2+)
- **Testing Framework:** PHPUnit 10.5
- **Browser Automation:** Facebook PHP WebDriver (Selenium)
- **Database:** MySQL (via XAMPP)
- **Browser:** Google Chrome + ChromeDriver

---

## ⚙️ Requirements

- PHP >= 8.2
- XAMPP (Apache + MySQL)
- Composer
- Google Chrome browser
- ChromeDriver (matching your Chrome version)
- Selenium Server / ChromeDriver running on `localhost:9515`

---

## 🚀 Setup & Installation

### 1. Clone the Repository
```bash
git clone https://github.com/nazlakhayra-23/gamestore.git
cd gamestore
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Configure Environment
```bash
cp .env.example .env
```
Edit `.env` and set your database credentials:
```
database.default.hostname = 127.0.0.1
database.default.database = partdua_gamestore
database.default.username = root
database.default.password = 
```

### 4. Run Database Migration & Seeder
```bash
php spark migrate
php spark db:seed UserSeeder
php spark db:seed CategorySeeder
php spark db:seed GamesSeeder
php spark db:seed AdminSeeder
```

### 5. Start the Application
```bash
php spark serve --port=8082
```

### 6. Start ChromeDriver
Run ChromeDriver from the `driver/` folder:
```bash
./chromedriver --port=9515
```

---

## ▶️ Running Tests

### Run All Tests
```bash
vendor/bin/phpunit
```

### Run Specific Test File
```bash
vendor/bin/phpunit tests/ui/LoginTest.php
vendor/bin/phpunit tests/ui/RegisterTest.php
```

### Run with Verbose Output
```bash
vendor/bin/phpunit --testdox
```

---

## 📁 Project Structure

```
gamestoreSelenium/
├── app/
│   ├── Controllers/        # Application controllers
│   ├── Models/             # Database models
│   ├── Views/              # HTML views
│   └── Database/
│       ├── Migrations/     # Database schema
│       └── Seeds/          # Test data seeders
├── tests/
│   ├── ui/                 # Selenium UI tests
│   ├── unit/               # Unit tests
│   ├── Support/            # Base test classes & helpers
│   └── report/             # Test screenshots (auto-generated)
├── public/                 # Web-accessible folder
├── phpunit.xml             # PHPUnit configuration
└── composer.json           # PHP dependencies
```

---

## 👥 Test Accounts

| Role  | Email                   | Password   |
|-------|-------------------------|------------|
| User  | dash@gmail.com          | dash123    |
| Admin | admin@gamestore.com     | admin123   |

---

## 📝 Notes

- Test screenshots on failure are saved to `tests/report/screenshots/`
- Make sure ChromeDriver version matches your installed Chrome version
- The app must be running at `http://localhost:8082` before executing tests
- Test database: `partdua_gamestore` (configured in `phpunit.xml`)

---

## 📄 License

MIT License — see [LICENSE](LICENSE) for details.
