# 🙏 Silpa5PHP Framework

A modern PHP framework built on Buddhist principles - combining the **Five Precepts (Panca Sila)** and **Vatthabot 7** virtuous principles to promote ethical, mindful development practices.

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D7.4-blue)](https://www.php.net/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](./LICENSE)
![Version](https://img.shields.io/badge/Version-1.0.0-green)

---

## 📚 Table of Contents

- [Features](#features)
- [The Five Precepts (Panca Sila)](#the-five-precepts-panca-sila)
- [Vatthabot 7 Principles](#vatthabot-7-principles)
- [Installation](#installation)
- [Quick Start](#quick-start)
- [Project Structure](#project-structure)
- [Configuration](#configuration)
- [System Architecture](#system-architecture)
- [Middleware](#middleware)
- [Contributing](#contributing)
- [License](#license)

---

## ✨ Features

### Ethical Foundation
- **Five Precepts Integration**: Ethical validation and enforcement throughout the framework
- **Vatthabot 7 Principles**: Seven virtuous principles guiding application behavior
- **Karma System**: Track and manage karma points for actions within the system
- **Dharma Layers**: Layered architecture following Buddhist philosophy

### Modern Development
- **PSR-4 Autoloading**: Modern PHP namespace support
- **Component-Based**: Modular and extensible architecture
- **Configuration Management**: Flexible configuration system
- **Security Focused**: Built-in protection mechanisms
- **Error Handling**: Graceful error management with Buddhist philosophy

### Built-in Features
- **Authentication System**: User authentication and authorization
- **Role & Permission System**: Flexible role-based access control
- **Session Management**: Secure session handling
- **Karma Tracking**: Record and monitor application actions
- **Environmental Support**: Development and production environments

---

## 🎯 The Five Precepts (Panca Sila)

The Five Precepts form the ethical foundation of the Silpa5PHP framework:

### 1. **Ahimsa** (अहिंसा) - Non-violence / Non-harm
- No killing, harming, or destruction
- Application: Exception handling, error prevention, safe data handling
- Principle: Write code that doesn't harm users or systems

### 2. **Adinnadana** (अदिननदान) - Non-stealing / Respect for property
- No stealing or taking what is not given
- Application: Proper authentication, authorization, and CSRF protection
- Principle: Respect user data and system resources

### 3. **Kamesu Micchacara** (कामेसु मिच्छचार) - Right conduct / Sexual ethics
- No sexual misconduct
- Application: Proper session handling, secure communication
- Principle: Maintain integrity in all communications

### 4. **Musavada** (मुसावाद) - Truthfulness / Honesty
- No lying or deception
- Application: Accurate configuration, honest error reporting
- Principle: Configuration and messages must be truthful

### 5. **Sura Meraya Majja** (सुरा मेरय मज्ज) - Sobriety / Mindfulness
- Avoid intoxication and maintain clarity
- Application: System stability, resource management
- Principle: Keep the system stable and mindful

---

## 🌟 Vatthabot 7 Principles

Seven virtuous principles governing ethical conduct:

| Principle | Name | Meaning | Application |
|-----------|------|---------|------------|
| 1 | **Akodhano** | Non-anger / Patience | Error handling with grace |
| 2 | **Apisunavaco** | Honest speech | Clear, truthful communication |
| 3 | **Kulejethapachayi** | Noble conduct | Best practices in coding |
| 4 | **Matapetibharo** | Respect for elders | Dependency management |
| 5 | **Saccavaco** | Truth speaker | Accurate logging/reporting |
| 6 | **Sanhavaco** | Harmonious speech | Balanced design decisions |
| 7 | **Tanasamvibhagarato** | Non-covetousness | Mindful resource usage |

---

## 📦 Installation

### Requirements
- PHP 7.4 or higher
- Composer
- MySQL/MariaDB (optional)
- XAMPP or similar local environment

### Step 1: Clone or Download
```bash
cd c:\xampp\htdocs
git clone https://github.com/silpa5/silpa5_v2.git silpa5_v2
cd silpa5_v2
```

### Step 2: Install Dependencies
```bash
composer install
```

### Step 3: Configure Environment
Create a `.env` file in the project root:
```env
CI_ENVIRONMENT=development
app.baseURL=http://localhost/silpa5_v2/public/
database.default.hostname=localhost
database.default.database=silpa5_db
database.default.username=root
database.default.password=
```

### Step 4: Set Permissions
```bash
chmod -R 755 writable/
```

### Step 5: Access the Application
```
http://localhost/silpa5_v2/public/
```

---

## 🚀 Quick Start

### Basic Application Flow

```php
// 1. Bootstrap loads (system/bootstrap.php)
// 2. Configuration initialized (app/Config/App.php)
// 3. Five Precepts validated
// 4. Vatthabot 7 principles initialized
// 5. Application starts (system/Core/Application.php)
// 6. Request handled and response rendered
```

### Creating a Simple Controller

```php
<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        return view('home/index', [
            'title' => 'Welcome',
            'precepts' => $this->getPrecepts()
        ]);
    }
}
```

### Using Authentication

```php
<?php
// Check if user is logged in
if (auth()->loggedIn()) {
    $user = auth()->user();
    echo "Welcome " . $user->name;
}

// Login a user
auth()->login($userId);

// Logout
auth()->logout();
```

---

## 📁 Project Structure

```
silpa5_v2/
├── app/                          # Application code
│   ├── Config/                   # Configuration files
│   │   ├── App.php              # Main configuration
│   │   ├── Database.php         # Database config
│   │   ├── FivePrecepts.php     # Precepts settings
│   │   └── Routes.php           # Application routes
│   ├── Controllers/              # Request handlers
│   │   ├── AuthController.php   # Authentication
│   │   ├── BaseController.php   # Base controller
│   │   └── UserController.php   # User management
│   ├── Models/                   # Data models
│   │   ├── UserModel.php        # User model
│   │   ├── RoleModel.php        # Role model
│   │   └── KarmaLogModel.php    # Karma tracking
│   ├── Middleware/               # Request middleware
│   │   ├── PreceptMiddleware.php
│   │   └── KarmaMiddleware.php
│   ├── Views/                    # View templates
│   │   ├── layouts/             # Layout templates
│   │   ├── auth/                # Auth views
│   │   └── home/                # Home views
│   └── Database/                 # Migrations and seeds
│       ├── Migrations/
│       └── Seeds/
├── system/                       # Framework core
│   ├── Core/                     # Core classes
│   │   ├── Application.php      # App dispatcher
│   │   ├── BasePrecept.php      # Precept base
│   │   ├── FivePrecepts/        # Five precepts
│   │   └── Vatthabot7/          # Vatthabot 7
│   ├── Config/                   # System config
│   │   └── BaseConfig.php       # Config base class
│   ├── Database/                 # Database layer
│   ├── Http/                     # HTTP handling
│   └── bootstrap.php             # System bootstrap
├── public/                       # Web root
│   ├── index.php                # Entry point
│   ├── assets/                  # Static files
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   └── uploads/                 # User uploads
├── writable/                    # Writable directories
│   ├── cache/                   # Cache files
│   ├── logs/                    # Application logs
│   └── uploads/                 # File uploads
├── tests/                       # Unit tests
├── vendor/                      # Composer dependencies
├── composer.json                # Dependencies
├── .env                         # Environment variables
├── .env.example                # Example env file
├── LICENSE                     # MIT License
└── README.md                   # This file
```

---

## ⚙️ Configuration

### Main Configuration (app/Config/App.php)

```php
class App extends BaseConfig
{
    // Base URL for the application
    public string $baseURL = 'http://localhost/silpa5_v2/public/';
    
    // Session driver (file, database, etc.)
    public string $sessionDriver = 'file';
    
    // Enable CSRF protection (Adinnadana principle)
    public bool $CSRFProtection = true;
    
    // Log level (0=none, 1=errors, 2=all)
    public int $logLevel = 2;
}
```

### Database Configuration

```php
// app/Config/Database.php
public array $default = [
    'hostname' => 'localhost',
    'database' => 'silpa5_db',
    'username' => 'root',
    'password' => '',
    'driver' => 'MySQLi'
];
```

---

## 🏗️ System Architecture

### Bootstrap Process

1. **Constants Definition**: Define BASEPATH, APPPATH, WRITEPATH
2. **Autoloader**: Load Composer autoloader
3. **Environment**: Load .env file with PHP dotenv
4. **Configuration**: Load App.php configuration
5. **Validation**: Execute Five Precepts validation
6. **Initialization**: Initialize Vatthabot 7 principles
7. **Application**: Start the Application dispatcher

### Request Flow

```
Public/index.php
    ↓
system/bootstrap.php (Framework initialization)
    ↓
system/Core/Application.php (Request handler)
    ↓
Middleware Stack (Precepts, Karma, Security)
    ↓
Router (Route matching)
    ↓
Controller (Business logic)
    ↓
Model (Data access)
    ↓
View (Response rendering)
    ↓
Response (Send to client)
```

---

## 🔒 Middleware

### PreceptMiddleware
Validates Five Precepts compliance for each request.

```php
// Automatically checks:
- Ahimsa: Safe error handling
- Adinnadana: Authorization checks
- Kamesu: Session integrity
- Musavada: Truthful logging
- Sura Meraya: System stability
```

### KarmaMiddleware
Tracks and manages karma points based on user actions.

```php
// Track positive and negative actions
- Positive: Helpful actions, successful operations
- Negative: Errors, violations, failed attempts
```

### VatthabotMiddleware
Enforces Vatthabot 7 principles throughout the application.

---

## 👥 User & Authorization System

### Built-in Models

#### UserModel
```php
$user = $userModel->find($userId);
$user->name        // User name
$user->email       // Email address
$user->status      // Active/Inactive
```

#### RoleModel
```php
$role = $roleModel->find($roleId);
$role->name        // Role name (admin, user, etc.)
```

#### PermissionModel
```php
$perm = $permModel->getByName('create_post');
// Check permission
if ($user->hasPermission('create_post')) {
    // Allow action
}
```

#### KarmaLogModel
```php
// Record karma action
$karmaLog->recordAction($userId, 'post_created', 10);

// Get user karma
$karma = $karmaLog->getUserKarma($userId);
```

---

## 🧪 Testing

### Running Tests

```bash
# Run all tests
composer test

# Run specific test file
composer test tests/App/Controllers/UserControllerTest.php

# Run with coverage
composer test -- --coverage-html coverage/
```

### Writing Tests

```php
<?php
namespace Tests\App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;

class UserControllerTest extends CIUnitTestCase
{
    public function testIndex()
    {
        $result = $this->withURI('/users')
                       ->controller('App\Controllers\UserController')
                       ->execute('index');
        
        $this->assertResponseStatus(200);
    }
}
```

---

## 📝 Database Migrations

### Creating a Migration

```bash
php spark migrate:create CreateUsersTable

# Edit app/Database/Migrations/[timestamp]_create_users_table.php
```

### Running Migrations

```bash
# Run pending migrations
php spark migrate

# Rollback to previous batch
php spark migrate:rollback

# Refresh database (rollback + migrate)
php spark migrate:refresh
```

---

## 🌍 Internationalization (i18n)

### Adding Language Files

```
app/Language/
├── en/
│   ├── messages.php
│   ├── errors.php
│   └── validation.php
└── th/
    ├── messages.php
    ├── errors.php
    └── validation.php
```

### Using Translations

```php
// Get translated string
echo lang('messages.welcome');

// With parameters
echo lang('messages.greeting', ['name' => 'John']);
```

---

## 🔐 Security Features

### CSRF Protection (Adinnadana)
```php
// All forms automatically include CSRF token
<?= csrf_field() ?>

// Or get CSRF token
$token = csrf_hash();
```

### Input Validation (Musavada)
```php
$validation = \Config\Services::validation();
$validation->setRules([
    'email' => 'required|valid_email',
    'password' => 'required|min_length[8]'
]);

if (!$validation->run($data)) {
    $errors = $validation->getErrors();
}
```

### SQL Injection Prevention
```php
// Safe query with parameterized statements
$user = $userModel->where('email', $email)->first();
```

---

## 🎓 Learning Resources

### Understanding Buddhist Principles in Code

- **Ahimsa**: Write defensive code that handles errors gracefully
- **Adinnadana**: Implement proper authentication and authorization
- **Kamesu**: Maintain clean session management
- **Musavada**: Write honest error messages and logs
- **Sura Meraya**: Keep your system stable and mindful

### Documentation Files
- [Five Precepts README](./FIVE_PRECEPTS_README.md)
- [App Structure](./APP_STRUCTURE_COMPLETE.md)

---

## 🐛 Troubleshooting

### Classes Not Found
```
Error: Class "Silpa5PHP\Core\Application" not found
Solution: Ensure vendor/autoload.php is loaded and composer install has run
```

### Missing Constants
```
Error: Undefined constant "BASEPATH"
Solution: Call system/bootstrap.php which defines all required constants
```

### Configuration Issues
```
Error: Base URL not properly configured
Solution: Check app/Config/App.php and set correct baseURL
```

---

## 🤝 Contributing

We welcome contributions! Please follow these guidelines:

1. **Fork** the repository
2. **Create** a feature branch (`git checkout -b feature/amazing-feature`)
3. **Commit** your changes (`git commit -m 'Add amazing feature'`)
4. **Push** to the branch (`git push origin feature/amazing-feature`)
5. **Open** a Pull Request

### Coding Standards
- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation
- Adhere to the Five Precepts in your code

---

## 📊 Roadmap

- [ ] RESTful API Framework
- [ ] Real-time Notifications
- [ ] Advanced Caching System
- [ ] GraphQL Support
- [ ] Web Socket Support
- [ ] Built-in Admin Panel
- [ ] Plugin System
- [ ] Enhanced Karma System

---

## 📞 Support

- **Issues**: [GitHub Issues](https://github.com/silpa5/silpa5_v2/issues)
- **Discussions**: [GitHub Discussions](https://github.com/silpa5/silpa5_v2/discussions)
- **Email**: support@silpa5php.dev
- **Documentation**: [Official Docs](https://docs.silpa5php.dev)

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](./LICENSE) file for details.

---

## 🙏 Acknowledgments

- Buddha for the wisdom of the Five Precepts
- The Buddhist community for the Vatthabot 7 principles
- All contributors who help make this framework better
- The PHP community for its amazing tools and libraries

---

## 🌈 Philosophy

> "Right view, right intention, right speech, right action, right livelihood, 
> right effort, right mindfulness, right concentration."
> 
> — The Eightfold Path

Silpa5PHP follows these principles to create a framework where ethical 
coding practices are not just encouraged, but built into the core of the system.

---

**Created with compassion for developers and their code. 🙏**

*Last Updated: March 1, 2026*
