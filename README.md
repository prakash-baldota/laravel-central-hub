# Centralized Authentication System

## Description
This project implements a centralized authentication system that allows multiple Laravel-based projects  to authenticate users through a Single Sign-On (SSO) mechanism, using a custom authentication system. The system supports API authentication via Laravel Sanctum, role-based access control, and user management with token-based authentication. It facilitates seamless communication and access control across multiple projects with a shared database.

## Version
- **Version**: 1.0.0
- **Last Updated**: February 2025
- **Laravel Version**: 10.x
- **PHP Version**: 8.2

## Table of Contents
- [Features](#features)
- [Technologies](#technologies)
- [Installation](#installation)
- [Configuration](#configuration)
- [API Documentation](#api-documentation)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

## Features
- **API Authentication**: Token-based authentication using Laravel Sanctum.
- **Role-Based Access Control**: Users have different roles with varied access levels.
- **Refresh Tokens**: Securely refresh access tokens for long-lasting sessions.
- **User Management**: Centralized user management and registration system.

## Technologies
- **Backend**: Laravel 10, PHP 8.2, MySQL
- **API Authentication**: Laravel Sanctum
- **Database**: MySQL
- **Frontend**: Vue.js framework for the frontend (not covered in this repository)

## Installation

### Prerequisites
- PHP = 8.2
- Composer
- Laravel 10.x
- MySQL

### Clone the Repository
First, clone the repository to your local machine:
```bash
git clone https://github.com/prakash-baldota/laravel-central-hub.git
cd laravel-central-hub
