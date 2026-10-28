# Headway College Student ERP System

A comprehensive Student Enterprise Resource Planning (ERP) system built with Laravel 11 and Bootstrap 5, designed for managing student registrations, courses, sessions, and educational qualifications.

## Features

### 1. **Authentication & Authorization**
- Secure login system using Laravel Breeze
- Role-based access control (Admin)
- Session management

### 2. **Master Modules**

#### Course Management
- Create, read, update, and delete courses
- Track course codes, names, duration, and total seats
- Monitor course enrollment status
- View course details and student count

#### Session Management
- Manage academic sessions
- Define session date ranges
- Mark sessions as active/inactive
- Track session-wise student registrations

### 3. **Student Registration Module**
Complete student registration with the following fields:

**Registration Details:**
- College Register No (Unique)
- Control No (Unique)
- Registration Date
- Course (FK)
- Session (FK)

**Personal Information:**
- Student Name
- Father Name
- Mother Name
- Gender (Male, Female, Other - Radio buttons)
- Religion
- Category (SC, ST, OBC, General, etc.)
- Domicile in UP (Yes/No toggle)
- Is Handicap (Yes/No toggle)
- Date of Birth

**Contact Details:**
- Mobile Number (10-digit validation)
- Address
- Pincode (6-digit validation)

**Documents:**
- Photo Upload (JPEG, PNG, JPG, GIF - Max 2MB)
- Signature Upload (JPEG, PNG, JPG, GIF - Max 2MB)

### 4. **Educational Qualifications**
Track educational background with support for multiple qualifications per student:

**Qualification Types:**
- High School
- Intermediate
- Under Graduate (UG)

**Details per Qualification:**
- Board/University
- Stream
- Year of Completion
- Roll Number
- Maximum Marks
- Obtained Marks
- Percentage

### 5. **Dashboard**
Real-time statistics and analytics:
- Total students count
- Total courses and active courses
- Total sessions and active sessions
- Students by course (with capacity tracking)
- Students by session
- Recent student registrations
- Quick action buttons

### 6. **Features**

#### Search & Filter
- Search students by name, register number, control number, or mobile
- Filter by course and session
- Pagination for large datasets

#### File Management
- Secure photo and signature upload
- File storage in `storage/app/public` directory
- Automatic cleanup on student deletion

#### Reporting
- **Excel Export**: Export student data to Excel with formatted headers
- **Print Report**: Generate printable student reports with filters applied
- Custom filtering options for exports and prints

### 7. **User Interface**
- Modern Bootstrap 5 design
- Blue gradient theme (#0D47A1 primary color)
- Responsive layout
- Side navigation menu
- Breadcrumb navigation
- Form validation with error messages
- Success/error alerts with auto-dismiss
- Mobile-friendly responsive design

## Installation & Setup

### Prerequisites
- PHP >= 8.1
- Laravel 11
- Composer
- MySQL or MariaDB
- Node.js & NPM (for frontend assets)

### Step 1: Clone the Repository
```bash
cd your-project-directory
```

### Step 2: Install Dependencies
```bash
composer install
npm install
```

### Step 3: Environment Configuration
```bash
# Copy example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

Update `.env` file with:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=headway_college_erp
DB_USERNAME=root
DB_PASSWORD=

APP_NAME="Headway College ERP"
APP_URL=http://localhost:8000
```

### Step 4: Create Database
```bash
# Create MySQL database
mysql -u root -p -e "CREATE DATABASE headway_college_erp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Step 5: Run Migrations
```bash
php artisan migrate
```

### Step 6: Create Storage Link
```bash
php artisan storage:link
```

This creates a symbolic link from `storage/app/public` to `public/storage` for serving uploaded files.

### Step 7: Install Maatwebsite Excel (if not already installed)
```bash
composer require maatwebsite/excel
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"
```

### Step 8: Build Frontend Assets
```bash
npm run build
```

### Step 9: Start Development Server
```bash
php artisan serve
```

Access the application at: `http://localhost:8000`

## Usage Guide

### User Authentication
1. Use Laravel Breeze to create admin user
2. Login with credentials
3. Access the dashboard

### Managing Courses
1. Navigate to **Courses** from sidebar
2. Click **Add New Course**
3. Fill in course details:
   - Course Code (unique)
   - Course Name
   - Duration
   - Total Seats
   - Description (optional)
   - Active status
4. Click **Create Course**
5. Edit or delete courses from the list

### Managing Sessions
1. Navigate to **Sessions** from sidebar
2. Click **Add New Session**
3. Fill in session details:
   - Session Name (e.g., "2024-2025")
   - Start Date
   - End Date
   - Remarks (optional)
   - Active status
4. Click **Create Session**

### Registering Students
1. Navigate to **Students** from sidebar
2. Click **Register Student**
3. Fill in all required information:
   - Registration and course details
   - Personal information
   - Contact details
   - Upload photo and signature
4. Click **Register Student**
5. Educational qualifications can be added later

### Viewing Student Details
1. Go to **Students** list
2. Click **View** button (eye icon) for any student
3. View complete profile including:
   - All personal information
   - Uploaded documents
   - Educational qualifications (if added)
   - Timestamps

### Editing Student Information
1. On student details page, click **Edit Student**
2. Modify required fields
3. Upload new photo/signature (optional - will replace existing)
4. Click **Update Student**

### Searching & Filtering Students
1. Use the search bar to search by:
   - Student name
   - Register number
   - Control number
   - Mobile number
2. Use dropdown filters for:
   - Course
   - Session
3. Click **Search** or use **Reset** to clear filters

### Exporting Data
1. Go to **Students** list with filters
2. Click **Export** button
3. Downloads Excel file with formatted headers and student data
4. Filters applied on the page are reflected in the export

### Printing Reports
1. Go to **Students** list with desired filters
2. Click **Print** button
3. Opens print preview with student table
4. Use browser print dialog to generate PDF or physical print

## Project Structure

```
headwaycollege/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   │   ├── CourseController.php
│   │   │   ├── SessionController.php
│   │   │   └── StudentController.php
│   │   └── Requests/
│   │       ├── StoreCourseRequest.php
│   │       ├── StoreSessionRequest.php
│   │       ├── StoreStudentRequest.php
│   │       └── StoreEducationalQualificationRequest.php
│   ├── Models/
│   │   ├── Course.php
│   │   ├── Session.php
│   │   ├── Student.php
│   │   └── EducationalQualification.php
│   └── Exports/
│       └── StudentsExport.php
├── database/
│   ├── migrations/
│   │   ├── 2025_03_24_100001_create_courses_table.php
│   │   ├── 2025_03_24_100002_create_sessions_table.php
│   │   ├── 2025_03_24_100003_create_students_table.php
│   │   └── 2025_03_24_100004_create_educational_qualifications_table.php
│   └── factories/
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── dashboard.blade.php
│       ├── courses/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       ├── sessions/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       └── students/
│           ├── index.blade.php
│           ├── create.blade.php
│           ├── edit.blade.php
│           ├── show.blade.php
│           └── print.blade.php
├── routes/
│   └── web.php
└── storage/
    └── app/
        └── public/
            └── students/
                ├── photos/
                └── signatures/
```

## Database Schema

### Courses Table
```sql
- id (primary key)
- code (unique string)
- name (string)
- description (text, nullable)
- duration (string, nullable)
- total_seats (integer)
- is_active (boolean)
- timestamps
```

### Sessions Table
```sql
- id (primary key)
- name (unique string)
- start_date (date)
- end_date (date)
- remarks (text, nullable)
- is_active (boolean)
- timestamps
```

### Students Table
```sql
- id (primary key)
- college_register_no (unique string)
- control_no (unique string)
- registration_date (date)
- course_id (foreign key → courses)
- session_id (foreign key → sessions)
- name (string)
- father_name (string)
- mother_name (string)
- gender (enum: male, female, other)
- religion (string, nullable)
- category (string, nullable)
- domicile_up (boolean)
- is_handicap (boolean)
- dob (date)
- mobile (string, 10 digits)
- address (text)
- pincode (string, 6 digits)
- photo_path (string, nullable)
- signature_path (string, nullable)
- timestamps
```

### Educational Qualifications Table
```sql
- id (primary key)
- student_id (foreign key → students, cascade delete)
- qualification_type (enum: highschool, intermediate, ug)
- board_university (string)
- stream (string)
- year_of_completion (integer)
- roll_number (string)
- max_marks (integer)
- obtained_marks (integer)
- percentage (decimal 5,2)
- timestamps
```

## Validation Rules

### Course Validation
- Code: Required, unique
- Name: Required, max 255 characters
- Duration: Optional
- Total Seats: Required, minimum 1
- Description: Optional

### Session Validation
- Name: Required, unique
- Start Date: Required, valid date
- End Date: Required, after start date
- Remarks: Optional

### Student Validation
- Register No: Required, unique
- Control No: Required, unique
- Course ID: Required, exists in courses table
- Session ID: Required, exists in sessions table
- Name: Required, max 255 characters
- Father/Mother Name: Required, max 255 characters
- Gender: Required (male, female, other)
- DOB: Required, must be in the past
- Mobile: Required, exactly 10 digits, unique
- Address: Required, max 500 characters
- Pincode: Required, exactly 6 digits
- Photo: Optional, image file, max 2MB
- Signature: Optional, image file, max 2MB

## Key Features Implementation

### File Upload Handling
- Files stored in `storage/app/public/students/{photos|signatures}`
- Automatic cleanup when updated or deleted
- Accessible via `storage/` symlink
- Image validation (type and size)

### Excel Export
- Uses Maatwebsite\Excel package
- Custom StudentsExport class
- Blue header styling
- Filter-aware export
- Date formatting for readability

### Relationships
- Course → hasMany Students
- Session → hasMany Students
- Student → belongsTo Course
- Student → belongsTo Session
- Student → hasMany EducationalQualifications
- EducationalQualification → belongsTo Student

## Security Considerations

1. **CSRF Protection**: All forms include CSRF tokens
2. **Input Validation**: Form requests validate all inputs
3. **File Upload Security**: File type and size validation
4. **SQL Injection Prevention**: Using eloquent ORM
5. **Authorization**: Middleware requires authentication
6. **Soft Deletes**: Consider implementing for data protection

## Performance Optimization Tips

1. Add indexes to frequently searched columns:
   ```sql
   ALTER TABLE students ADD INDEX idx_mobile (mobile);
   ALTER TABLE students ADD INDEX idx_register_no (college_register_no);
   ```

2. Cache course and session lists
3. Use eager loading in controllers
4. Implement pagination (already done)
5. Add database query optimization queries

## Troubleshooting

### Issue: File uploads not working
**Solution**: Ensure `storage/app/public` directory exists and storage link is created:
```bash
php artisan storage:link
```

### Issue: Images not displaying
**Solution**: Check if public storage link exists:
```bash
ls -la public/storage
```

### Issue: Excel export not working
**Solution**: Ensure Maatwebsite Excel package is installed:
```bash
composer require maatwebsite/excel
```

### Issue: Migrations not running
**Solution**: Check database connection in `.env` and run:
```bash
php artisan migrate --fresh
```

## Future Enhancements

1. **Educational Qualifications UI**: Add dynamic form to add qualifications within student registration
2. **Email Notifications**: Send registration confirmation emails
3. **Bulk Import**: CSV/Excel import for students
4. **Report Generation**: PDF report generation
5. **API Endpoints**: REST API for mobile app
6. **Attendance Management**: Track student attendance
7. **Fee Management**: Fee collection and tracking
8. **Multi-user Roles**: Different roles for admin, staff, students
9. **SMS Notifications**: SMS integration for alerts
10. **Analytics Dashboard**: Advanced charts and statistics

## Support & Documentation

For more information on Laravel and its components:
- [Laravel Documentation](https://laravel.com/docs)
- [Bootstrap Documentation](https://getbootstrap.com/docs)
- [Maatwebsite Excel](https://docs.laravel-excel.com/)

## License

This project is provided as-is for Headway College.

## Version History

**Version 1.0.0** - March 24, 2025
- Initial release
- Course management
- Session management
- Student registration with full CRU operations
- Educational qualifications tracking
- Excel export functionality
- Report generation
- Dashboard with statistics

---

**Last Updated**: March 24, 2025
