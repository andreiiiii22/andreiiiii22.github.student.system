CREATE DATABASE IF NOT EXISTS `student_system` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `student_system`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','student') NOT NULL DEFAULT 'student'
);

CREATE TABLE IF NOT EXISTS `students` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_id` VARCHAR(50) NOT NULL UNIQUE,
  `name` VARCHAR(200) NOT NULL,
  `email` VARCHAR(200) NOT NULL UNIQUE,
  `course` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) NOT NULL
);
