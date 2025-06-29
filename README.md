# NOSQL_DATABASES

A modern web application for movie management built with PHP and MongoDB, containerized with Docker for easy deployment and development.

## Description

This project implements a complete movie management system (CRUD) using NoSQL technologies. The application allows users to create, read, update, and delete movie information, leveraging MongoDB's flexibility for data storage.

## Technologies Used

- **Backend**: PHP with Apache HTTP Server
- **Database**: MongoDB (NoSQL)
- **Containerization**: Docker & Docker Compose
- **Dependency Management**: Composer
- **Web Server**: Apache HTTP Server

## Project Structure

```
NOSQL_PELICULAS/
├── apache-php/                 # Main application
│   ├── app/                   # Application code
│   │   ├── vendor/           # Composer dependencies
│   │   ├── composer.json     # Dependencies configuration
│   │   ├── composer.lock     # Dependencies lock file
│   │   ├── create_form.php   # Creation form
│   │   ├── create.php        # Creation logic
│   │   ├── db.php           # Database configuration
│   │   ├── delete.php       # Deletion logic
│   │   ├── find.php         # Movie search functionality
│   │   ├── index.php        # Main page
│   │   ├── lista.php        # Movie listing
│   │   ├── test.php         # Testing file
│   │   ├── update_form.php  # Update form
│   │   └── update.php       # Update logic
│   └── Dockerfile           # PHP/Apache container configuration
├── mongo-init/               # MongoDB initialization scripts
└── docker-compose.yml        # Container orchestration
```

## Features

- **Create Movies**: Add new movies with detailed information
- **List Movies**: View all stored movies
- **Search Movies**: Find specific movies
- **Update Movies**: Modify existing information
- **Delete Movies**: Remove movies from the system
- **Containerized Deployment**: Easy installation and deployment

## Prerequisites

- Docker
- Docker Compose
- Git

## Installation and Configuration

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/NOSQL_DATABASES.git
   cd NOSQL_DATABASES
   ```

2. **Build and run containers**
   ```bash
   docker-compose up -d
   ```

3. **Install PHP dependencies**
   ```bash
   docker-compose exec apache composer install
   ```

4. **Access the application**
   - Web application: `http://localhost:8080`
   - MongoDB: `mongodb://localhost:27017`

## Services Configuration

The application consists of two main services:

### MongoDB Service
- **Container**: mongo
- **Image**: mongo:6
- **Port**: 27017
- **Initialization**: Scripts in `./mongo-init` directory are executed on first run

### Apache/PHP Service
- **Container**: apache2
- **Port**: 8080 (mapped to container port 80)
- **Volume Mount**: Application code mounted from `./apache-php/app` to `/var/www/html`

## Usage

Once the application is running:

1. Navigate to `http://localhost:8080` in your browser
2. Use the web interface to:
   - View existing movie listings
   - Add new movies
   - Search for specific movies
   - Edit movie information
   - Delete movies

## Architecture

The application follows a simple but effective architecture:

- **Frontend**: PHP pages with HTML forms
- **Backend**: PHP scripts for business logic
- **Database**: MongoDB for flexible data storage
- **Infrastructure**: Docker containers for isolation and portability

## Main Endpoints

- `/` - Main page
- `/lista.php` - Movie listings
- `/create_form.php` - New movie form
- `/update_form.php` - Edit form
- `/find.php` - Movie search

## Development

### Local Development Setup

1. Ensure Docker and Docker Compose are installed
2. Clone the repository
3. Run `docker-compose up -d` to start services
4. The application will be available at `http://localhost:8080`
5. MongoDB will be accessible at `mongodb://localhost:27017`

### Database Initialization

Place any MongoDB initialization scripts in the `mongo-init/` directory. These scripts will be automatically executed when the MongoDB container starts for the first time.

## Security Considerations

- Input validation in forms
- Secure MongoDB connection
- Data sanitization before storage
- Container isolation for enhanced security
