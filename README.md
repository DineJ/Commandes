# Commandes

A web application developed with **CodeIgniter 4**, a PHP framework.

## Requirements

Before installing the project, make sure you have:

- PHP (a version compatible with the project's CodeIgniter 4 dependencies)
- Composer
- Git
- A database server, if required by the application
- The PHP extensions required by `composer.json`

Check your installed versions:

```bash
php -v
composer --version
git --version
```

## Installation

### 1. Clone the repository

Clone the project from GitHub:

```bash
git clone -b main https://github.com/DineJ/Commandes.git
```

Navigate to the project directory:

```bash
cd Commandes
```

### 2. Install dependencies

Install the PHP dependencies using Composer:

```bash
composer install
```

This command installs the dependencies defined in `composer.json`, using the versions specified in `composer.lock` when available.

To update dependencies intentionally, use:

```bash
composer update
```

**Note:** Use `composer install` for the initial setup. `composer update` should only be used when dependencies need to be updated.

### 3. Configure the environment

Copy the provided `env` file to `.env`:

```bash
cp env .env
```

Open `.env` and configure the environment settings.

For local development:

```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'
```

If the application requires a database, configure the connection:

```ini
database.default.hostname = localhost
database.default.database = your_database
database.default.username = your_username
database.default.password = your_password
database.default.DBDriver = MySQLi
database.default.port = 3306
```

Replace these example values with your local configuration.

**Important:** The `.env` file contains environment-specific settings and may contain sensitive information. It should not be committed to Git.

### 4. Check the application configuration

The main application configuration is located at:

```text
app/Config/App.php
```

Check that the default settings are appropriate for your environment.

For example:

```php
public string $baseURL = 'http://localhost:8080/';
```

CodeIgniter 4 allows configuration values to be overridden through environment variables.

For example, when `app.baseURL` is correctly defined in `.env`, it overrides the corresponding default value in `App.php`.

**Recommendation:** Keep shared default settings in `App.php` and environment-specific settings in `.env`.

There is no need to duplicate every configuration value in both files.

### 5. Check writable directories

CodeIgniter 4 uses the `writable/` directory for generated files, including cache, logs and sessions.

Make sure the required directories exist:

```bash
mkdir -p writable/cache writable/logs writable/session
```

On Linux, ensure that the PHP process has write permissions for these directories.

If the directories are already included in the repository, this step can be skipped.

### 6. Set up the database

If the application uses a database:

1. Create the database specified in `.env`.
2. Configure the database credentials.
3. Import the project's database schema or run migrations, if provided.

If CodeIgniter migrations are available, run:

```bash
php spark migrate
```

Only run migrations if they are part of the project's database setup.

### 7. Start the development server

Start the CodeIgniter 4 development server:

```bash
php spark serve
```

By default, the application will be accessible at:

[http://localhost:8080/](http://localhost:8080/)

## Updating the project

To retrieve the latest changes from the current branch:

```bash
git pull
```

If dependencies have changed, run:

```bash
composer install
```

If new database migrations have been added, apply them when required:

```bash
php spark migrate
```

## Troubleshooting

### Missing dependencies

If PHP dependencies are missing, run:

```bash
composer install
```

### Cache or writable directory errors

Check that the required directories exist and that PHP has permission to write to them.

### Database connection errors

Verify the database settings in `.env` and ensure the database server is running.

### Application configuration errors

Check the configuration in `.env` and `app/Config/App.php`.

## Additional documentation

- [CodeIgniter 4 Documentation](https://codeigniter.com/user_guide/)
- [Composer Documentation](https://getcomposer.org/doc/)
- [Git Documentation](https://git-scm.com/doc)
