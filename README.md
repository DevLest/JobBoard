
# JobBoard Application

This is a JobBoard application built with Laravel and VueJS. It allows job seekers to view job postings from both local sources and external sources. Job board moderators can approve or mark jobs as spam directly from email notifications.

## Features

- Post job listings
- View local job listings
- Fetch and display external job listings from an API
- Search and filter job listings
- Approve or mark job listings as spam via email notifications

## Prerequisites

- PHP >= 8.0
- Composer
- Node.js
- Laravel CLI
- MySQL or any other supported database

## Setup Instructions

### Step 1: Clone the Repository

```bash
git clone https://github.com/your-username/jobboard.git
cd jobboard
```

### Step 2: Install Dependencies

```bash
composer install
```

### Step 3: Create and Configure `.env` File

```bash
cp .env.example .env
```

Update the `.env` file with your database and mail configuration:

```env
APP_NAME=JobBoard
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jobboard
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Step 4: Generate Application Key

```bash
php artisan key:generate
```

### Step 5: Run Migrations

```bash
php artisan migrate
```

### Step 6: Seed the Database (Optional)

If you have seeders, you can seed the database with initial data:

```bash
php artisan db:seed
```

### Step 7: Serve the Application

```bash
php artisan serve
```

Open your browser and navigate to `http://localhost:8000`.

### External Job Source

The application fetches external job listings from the following URL:
- https://mrge-group-gmbh.jobs.personio.de/xml

### Using Mailhog for Local Development

To test email notifications locally, you can use Mailhog:

1. **Download and Run Mailhog:**
   - Go to the [Mailhog releases page](https://github.com/mailhog/MailHog/releases) and download `MailHog_windows_amd64.exe` for Windows.
   - Run Mailhog by double-clicking the executable file.

2. **Update `.env` Configuration for Mailhog:**

```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

3. **View Emails:**
   - Open your web browser and navigate to `http://127.0.0.1:8025` to view the emails sent by the application.

### Approval and Spam Management

- **Approve Jobs:** Approval can only be done via email notifications sent to the moderator.
- **Mark as Spam:** Jobs can be marked as spam from both the email notifications and the job listings page.

### License

This project is open-source and available under the [MIT License](LICENSE).