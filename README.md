# Student Record Management System (MVP)

Simple PHP + MySQL student records system built for XAMPP.

## Features
- Role-based login (Admin / Student)
- Admin: Add, Edit, Delete, Search students
- Student: View records only
- Uses `password_hash()` for security
- SQL injection safe (prepared statements)
- Minimal responsive design

## Setup (Local / XAMPP)
1. Copy project to: `C:\xampp\htdocs\student_system`
2. Start Apache & MySQL in XAMPP.
3. In phpMyAdmin, import `create_database.sql`.
4. Copy `config.sample.php` → `config.php`, then edit with your MySQL credentials.
5. Create an admin account:
   - Option 1: Run `init_admin.php` locally once (then delete it)
   - Option 2: Insert admin manually via phpMyAdmin (see SQL below)
6. Open `http://localhost/student_system/login.php`.

### Example admin insert (manual)
```sql
INSERT INTO users (username, password, role)
VALUES ('admin', '$2y$10$exampleHashedPassword...', 'admin');
