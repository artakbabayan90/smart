# Smart Project

This is the README file for the Smart Project. It provides instructions on how to set up and run the application.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Installation](#installation)
    - [Using Docker (Recommended)](#using-docker-recommended)
    - [Manual Installation](#manual-installation)
- [Configuration](#configuration)
- [Running the Application](#running-the-application)
    - [With Docker](#with-docker)
    - [Manually](#manually)
- [Database Seeders](#database-seeders)
- [Default Admin and User Credentials](#default-admin-and-user-credentials)
- [cURL](#curl)
- [Contributing](#contributing)
- [License](#license)

## Prerequisites

Before you begin, ensure you have the following installed:

- **Git:** For version control. You likely already have this if you're here! ([https://git-scm.com/downloads](https://git-scm.com/downloads))
- **Docker** and **Docker Compose:** If you choose the Docker installation method. ([https://docs.docker.com/get-docker/](https://docs.docker.com/get-docker/))

For manual installation, you will also need:

- **PHP:** Version >= [Your Required PHP Version] ([https://www.php.net/downloads](https://www.php.net/downloads))
- **Composer:** For managing PHP dependencies ([https://getcomposer.org/download/](https://getcomposer.org/download/))
- **A Database:** (e.g., MySQL, PostgreSQL) and the necessary PHP extensions.

## Installation

### Using Docker (Recommended)

This is the easiest way to get the project running with all dependencies isolated.

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/artakbabayan90/smart.git](https://github.com/artakbabayan90/smart.git)
    cd smart
    ```

2.  **Copy environment configuration:**
    ```bash
    cp .env.example .env
    ```
    You may need to adjust the `.env` file for database settings or other environment-specific configurations (see the [Configuration](#configuration) section).

3.  **Build and run the Docker containers:**
    ```bash
    docker-compose up -d --build
    ```
    This command will build the Docker images and start the containers in detached mode.

4.  **Install PHP dependencies (within the PHP container):**
    ```bash
    docker-compose exec app composer install
    ```

5.  **Generate application key:**
    ```bash
    docker-compose exec app php artisan key:generate
    ```

6.  **Run database migrations:**
    ```bash
    docker-compose exec app php artisan migrate --seed
    ```
    The `--seed` flag will also run the database seeders (see the [Database Seeders](#database-seeders) section), which will create the default admin and user accounts.

### Manual Installation

If you prefer to install the project directly on your local machine:

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/artakbabayan90/smart.git](https://github.com/artakbabayan90/smart.git)
    cd smart
    ```

2.  **Copy environment configuration:**
    ```bash
    cp .env.example .env
    ```
    Edit the `.env` file to configure your database connection and other environment variables.

3.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

4.  **Generate application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Configure your database:** Ensure your database server is running and the credentials in your `.env` file are correct.

6.  **Run database migrations and seeders:**
    ```bash
    php artisan migrate --seed
    ```

## Configuration

The primary configuration for the application is done through the `.env` file. This file contains sensitive information like database credentials, API keys, etc. **Do not commit your `.env` file to version control.**

When using Docker, the `.env` file in the project root is used to configure the environment within the containers.

## Running the Application

### With Docker

Once the containers are running, you can access the application through your web browser, usually at `http://localhost` or the port you have mapped in your `docker-compose.yml` file (e.g., `http://localhost:8000`).

You can also run Artisan commands within the `app` container using `docker-compose exec app php artisan <command>`.

### Manually

1.  **Start your web server:** (e.g., Apache, Nginx) and ensure it's configured to serve the project's `public` directory as the document root.

2.  **Access the application** through the URL configured in your web server.

## Database Seeders

Database seeders are used to populate your database with initial data, including default user accounts. You can find the seeder files in the `database/seeders` directory.

- To run all seeders, use:
  ```bash
  php artisan migrate --seed
  # Or with Docker:
  # docker-compose exec app php artisan migrate --seed