-- phpMyAdmin SQL Dump
-- Student Record Management System Database
-- Host: localhost
-- Generation Time: 2025-10-05

CREATE DATABASE IF NOT EXISTS `student_system`;
USE `student_system`;

-- --------------------------------------------------------
-- Table structure for `users`
-- --------------------------------------------------------
CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','student') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin user (username: admin / password: admin123)
INSERT INTO `users` (`username`, `password`, `role`)
VALUES ('admin', '$2y$10$4fL9O2LMSH0yK2V8m4y5Uu9tQF7eOvlvUuR5f5tlfY3C4dZZvU/yS', 'admin');
-- password is hashed version of "admin123"

-- --------------------------------------------------------
-- Table structure for `students`
-- --------------------------------------------------------
CREATE TABLE `students` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `student_id` VARCHAR(50) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `course` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Optional sample data
INSERT INTO `students` (`student_id`, `name`, `email`, `course`, `phone`) VALUES
('STU001', 'Juan Dela Cruz', 'juan@example.com', 'BSIT', '09123456789'),
('STU002', 'Maria Santos', 'maria@example.com', 'BSCS', '09998887777');
