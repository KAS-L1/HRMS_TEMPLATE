# Laravel Project Setup

This repository contains a Laravel-based admin template. Follow these instructions to set up the project on your local machine.

## Prerequisites

Before you begin, ensure you have the following installed on your system:

- **Git**: Version control system for tracking source code changes
  - Download from [https://git-scm.com/](https://git-scm.com/)
  - Follow installation instructions for your OS

- **PHP**: Version 7.3 or higher required
  - Check version with `php -v`

- **Composer**: PHP dependency manager
  - Download from [https://getcomposer.org/](https://getcomposer.org/)
  - Follow installation instructions for your OS

- **Web Server**: 
  - Use Apache or Nginx for production
  - Laravel's built-in server for development

- **Database**: 
  - MySQL, PostgreSQL, or SQLite
  - Ensure database service is running

## Installation Steps

1. **Clone the Repository**
   ```bash
   git clone https://gitlab.com/SoengSouy/admin-template-with-laravel-sample.git
   cd admin-template-with-laravel-sample
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Database**
   
   Update `.env` file with your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_db
   DB_USERNAME=root
   DB_PASSWORD=your_database_password
   ```

5. **Run Migrations**
   ```bash
   php artisan migrate
   ```

6. **Start Development Server**
   ```bash
   php artisan serve
   ```
   The application will be available at `http://localhost:8000`

## Troubleshooting

If you encounter any issues during the installation process:

1. Ensure all prerequisites are properly installed
2. Check that your database service is running
3. Verify your database credentials in the `.env` file
4. Try removing vendor directory and running `composer install` again
5. Clear Laravel cache:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

## Support

For additional help or questions, please open an issue in the repository.

## Author

**KAS-L**

## License

MIT License

Copyright (c) 2024 KAS-L

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.