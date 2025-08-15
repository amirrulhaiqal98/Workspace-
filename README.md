# Task Management System with Workspaces

## Project Objective

A comprehensive task management application built with Laravel 12 that allows users to organize their tasks within workspaces. The system provides a professional interface for managing deadlines, tracking progress, and maintaining productivity through an intuitive workspace-based organization structure.

## About the Application

This task management system is designed to help users:
- Create and manage multiple workspaces for different projects or contexts
- Add tasks with mandatory deadlines to ensure accountability
- Track task completion status with visual indicators
- Monitor overdue tasks and time remaining for upcoming deadlines
- Maintain complete data isolation between users for privacy and security

## Core Modules

### 🔐 Authentication Module
- User registration and login with custom username field
- Profile management with picture upload capability
- Secure session management using Laravel Breeze

### 🏢 Workspace Module
- Create and manage multiple workspaces (up to 50 per user)
- Each workspace acts as a container for related tasks
- Workspace statistics showing task counts and completion rates
- Complete ownership isolation - users can only access their own workspaces

### ✅ Task Module
- Create tasks with mandatory deadlines within workspaces
- Task status management (incomplete/completed)
- Overdue detection with visual warnings
- Human-readable time displays (e.g., "3 days from now")
- Up to 1000 tasks per workspace

### 📊 Dashboard Module
- Overview of all workspaces and tasks
- Visual charts showing task completion statistics
- Quick access to recent workspaces and overdue tasks
- Responsive design optimized for all devices

## Technology Stack

### Backend
- **Framework**: Laravel 12
- **PHP Version**: 8.2+
- **Database**: MySQL
- **Authentication**: Laravel Breeze with custom modifications

### Frontend
- **UI Framework**: AdminLTE 3 (via CDN)
- **JavaScript**: Alpine.js 3
- **Build Tool**: Vite 7
- **Charts**: Chart.js integration
- **Icons**: Font Awesome (via AdminLTE)

### Development Tools
- **Environment**: Laragon (Windows) / Laravel Sail (Docker)
- **Package Manager**: Composer (PHP) + npm (JavaScript)
- **Code Quality**: Laravel Pint for code formatting
- **Debugging**: Laravel Pail for real-time log monitoring

## Installation & Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & npm
- SQLite or MySQL database

### Step 1: Clone Repository
```bash
git clone <repository-url>
cd runCloudAssesment
```

### Step 2: Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### Step 3: Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create SQLite database (if using SQLite)
touch database/database.sqlite
```

### Step 4: Database Setup
```bash
# Run migrations
php artisan migrate

# Seed with test data (optional)
php artisan db:seed --class=CleanTestDataSeeder
```

### Step 5: Build Assets
```bash
# Build frontend assets
npm run build

# Or run in development mode with hot reload
npm run dev
```

### Step 6: Start Development Server
```bash
# Start all services concurrently (recommended)
composer run dev

# Or start individual services
php artisan serve              # Laravel server
```

## Environment Variables

Key configuration options in `.env`:

```env
# Application
APP_NAME="Task Management System"
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite

# Application Limits
USER_MAX_WORKSPACES=50
WORKSPACE_MAX_TASKS=1000
ITEMS_PER_PAGE=15
TASK_OVERDUE_WARNING_HOURS=24
```

## Security Features

- ✅ Complete data isolation between users
- ✅ Authorization policies for all operations
- ✅ Middleware protection for workspace access
- ✅ CSRF protection on all forms
- ✅ Input validation and sanitization
- ✅ Route model binding with automatic 404s
