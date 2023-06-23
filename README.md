# Witt-CMS

![Project Version](https://img.shields.io/badge/version-0.1.0-green.svg)

Witt-CMS is a Laravel application powered by Inertia.js, Vue.js, and Tailwind CSS, with server-side rendering (SSR) for better performance and SEO. This project provides a robust CMS with a built-in forum and authentication via Laravel Jetstream.

## Features

- **Forum**: A built-in forum for users to start discussions and post responses.
- **Authentication**: Integrated authentication using Laravel Jetstream.
- **User Management (Coming soon)**: Comprehensive user management interface with Jetstream and Inertia.
- **Server-Side Rendering**: Improved performance and SEO with SSR.
- **Theme Customization (Coming Soon)**: A future feature will allow users to customize the application theme.

## Installation

```bash
# Clone the repository
git clone https://github.com/username/Witt-CMS.git

# Navigate to the project directory
cd Witt-CMS

# Install dependencies
composer install
npm install

# Create a .env file
cp .env.example .env

# Generate an application key
php artisan key:generate

# Run the database migrations
php artisan migrate

# Compile the assets
npm run dev

# Start the server
php artisan serve
```
Now, visit the URL below to see the application:

http://localhost:8000
