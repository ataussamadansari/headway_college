# Quick Start Guide - Headway College ERP

## One-Time Setup

### 1. Database Setup
```bash
# Create database
mysql -u root -p -e "CREATE DATABASE headway_college_erp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Update .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=headway_college_erp
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Dependencies Installation
```bash
composer install
npm install
composer require maatwebsite/excel
```

### 3. Application Setup
```bash
php artisan key:generate
php artisan migrate
php artisan storage:link
```

### 4. Build Assets
```bash
npm run build
```

### 5. Create Initial User (Optional - if using Breeze)
```bash
# If you want to set up Laravel Breeze for authentication:
composer require laravel/breeze --dev
php artisan breeze:install
npm run build
```

## Testing the System

### 1. Start Development Server
```bash
php artisan serve
# Access at http://localhost:8000
```

### 2. Create Initial Data
```bash
php artisan tinker

# Create courses
$course1 = App\Models\Course::create([
    'code' => 'BCA001',
    'name' => 'Bachelor of Computer Applications',
    'duration' => '3 Years',
    'total_seats' => 60,
    'is_active' => true,
    'description' => 'A comprehensive 3-year undergraduate program in Computer Applications'
]);

$course2 = App\Models\Course::create([
    'code' => 'BCS001',
    'name' => 'Bachelor of Computer Science',
    'duration' => '3 Years',
    'total_seats' => 50,
    'is_active' => true,
    'description' => 'A comprehensive 3-year undergraduate program in Computer Science'
]);

# Create sessions
$session = App\Models\Session::create([
    'name' => '2024-2025',
    'start_date' => '2024-07-01',
    'end_date' => '2025-06-30',
    'remarks' => 'Regular session',
    'is_active' => true,
]);

# Create a student
$student = App\Models\Student::create([
    'college_register_no' => 'HW/BCA/001/2024',
    'control_no' => 'CTRL/001/2024',
    'registration_date' => now(),
    'course_id' => $course1->id,
    'session_id' => $session->id,
    'name' => 'John Doe',
    'father_name' => 'Robert Doe',
    'mother_name' => 'Mary Doe',
    'gender' => 'male',
    'religion' => 'Christian',
    'category' => 'General',
    'domicile_up' => true,
    'is_handicap' => false,
    'dob' => '2003-05-15',
    'mobile' => '9876543210',
    'address' => '123 Main Street, Lucknow',
    'pincode' => '226001',
]);

exit
```

## Required Configuration

### 1. Update .env
```env
APP_NAME="Headway College ERP"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=headway_college_erp
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=noreply@headwaycollege.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 2. Create Storage Directories
These are automatically created by the application, but you can pre-create them:
```bash
mkdir -p storage/app/public/students/photos
mkdir -p storage/app/public/students/signatures
chmod -R 755 storage
chmod -R 755 public/storage
```

### 3. Permissions (Linux/Mac)
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## Running Migrations

### Initial Run (All tables)
```bash
php artisan migrate
```

### Fresh Migration (Dangerous - drops all tables)
```bash
php artisan migrate:fresh
```

### Rollback Changes
```bash
php artisan migrate:rollback
```

## Common Operations

### Clear Laravel Cache/Config
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Run Database Seeder
```bash
php artisan db:seed
```

### Create New Migration
```bash
php artisan make:migration create_table_name
```

### Create New Model
```bash
php artisan make:model ModelName
```

### Create New Controller
```bash
php artisan make:controller ControllerName --resource
```

## File Uploads

### Storage Path Configuration
Files are stored in: `storage/app/public/students/`

To access files:
- Photos: `/storage/students/photos/filename.jpg`
- Signatures: `/storage/students/signatures/filename.jpg`

### Ensure Disk Configuration
In `config/filesystems.php`, ensure:
```php
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
    'permissions' => [
        'file' => [
            'public' => 0644,
            'private' => 0600,
        ],
        'dir' => [
            'public' => 0755,
            'private' => 0700,
        ],
    ],
],
```

## Debugging Tips

### Enable Query Logging
```php
// In tinker or routes
DB::enableQueryLog();
// ... run some queries
dd(DB::getQueryLog());
```

### View App Error Log
```bash
tail -f storage/logs/laravel.log
```

### Test File Upload
```bash
# Upload test image
php artisan tinker
$file = new UploadedFile('path/to/image.jpg', 'image.jpg');
```

## Performance Tuning

### Optimize Autoloader
```bash
composer dumpautoload --optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Database Optimization
```bash
# Add indexes
php artisan tinker
DB::statement('ALTER TABLE students ADD INDEX idx_mobile (mobile);');
DB::statement('ALTER TABLE students ADD INDEX idx_register_no (college_register_no);');
DB::statement('ALTER TABLE students ADD INDEX idx_control_no (control_no);');
exit
```

## Troubleshooting

### Port Already in Use
```bash
# Use different port
php artisan serve --port=8001
```

### Permission Denied on storage/
```bash
sudo chmod -R 777 storage
sudo chmod -R 777 bootstrap/cache
```

### Database Connection Error
```bash
# Check .env credentials
php artisan tinker
DB::connection()->getPdo();
```

### Missing Storage Link
```bash
php artisan storage:link
```

## Backup & Maintenance

### Database Backup
```bash
mysqldump -u root -p headway_college_erp > backup.sql
```

### Database Restore
```bash
mysql -u root -p headway_college_erp < backup.sql
```

### Clean Old Uploads
```bash
# Remove files not used in 30 days
find storage/app/public/students -type f -atime +30 -delete
```

## Production Deployment Checklist

- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Cache configuration: `php artisan config:cache`
- [ ] Cache routes: `php artisan route:cache`
- [ ] Cache views: `php artisan view:cache`
- [ ] Set proper file permissions
- [ ] Configure proper database backups
- [ ] Set up SSL certificate
- [ ] Configure email service
- [ ] Set up monitoring logs
- [ ] Set up user authentication

## Useful Commands Reference

```bash
# Run development server
php artisan serve

# Queue work (if using queues)
php artisan queue:work

# Schedule tasks
php artisan schedule:run

# Run tests
php artisan test

# Code quality check
php artisan tinker

# View Laravel version
php artisan --version

# List all routes
php artisan route:list

# Clear everything
php artisan optimize:clear
```

---

For detailed documentation, see [DOCUMENTATION.md](./DOCUMENTATION.md)
