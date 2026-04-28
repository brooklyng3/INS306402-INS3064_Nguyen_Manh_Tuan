-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2026 at 07:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `created_at`) VALUES
(1, 'Introduction to Network Security', 'Learn the fundamentals of securing networks, protocols, and architecture.', '2026-03-31 02:10:03'),
(2, 'Web Application Penetration Testing', 'Deep dive into finding and exploiting vulnerabilities in web apps.', '2026-03-31 02:10:03'),
(3, 'Advanced Reverse Shells & Privilege Escalation', 'Techniques for gaining and elevating access within compromised systems.', '2026-03-31 02:10:03'),
(4, 'Neural Networks & Deep Learning', 'Build and train machine learning models using PyTorch.', '2026-03-31 02:10:03'),
(5, 'PHP & Web Development Fundamentals', 'Core concepts of backend development and secure coding practices.', '2026-03-31 02:10:03'),
(6, 'Applied Cryptography', 'Study of secure communication techniques and encryption algorithms.', '2026-03-31 02:10:03'),
(7, 'Cloud Security Architecture', 'Securing infrastructure and data deployments in AWS and GCP.', '2026-03-31 02:10:03'),
(8, 'Galactic Republic Politics & History', 'An analytical look at the Old Republic and its political downfalls.', '2026-03-31 02:10:03'),
(9, 'Sports Analytics & Management Simulation', 'Using statistical models to optimize tactical decisions and team management.', '2026-03-31 02:10:03'),
(10, 'Data Structures and Algorithms', 'Core algorithms, complexity analysis, and efficient data handling.', '2026-03-31 02:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `student_id`, `course_id`, `enrolled_at`) VALUES
(1, 1, 2, '2026-03-31 02:10:03'),
(2, 1, 3, '2026-03-31 02:10:03'),
(3, 1, 5, '2026-03-31 02:10:03'),
(4, 1, 7, '2026-03-31 02:10:03'),
(5, 2, 1, '2026-03-31 02:10:03'),
(6, 2, 4, '2026-03-31 02:10:03'),
(7, 2, 6, '2026-03-31 02:10:03'),
(8, 3, 3, '2026-03-31 02:10:03'),
(9, 3, 8, '2026-03-31 02:10:03'),
(10, 3, 10, '2026-03-31 02:10:03'),
(11, 4, 1, '2026-03-31 02:10:03'),
(12, 4, 2, '2026-03-31 02:10:03'),
(13, 4, 5, '2026-03-31 02:10:03'),
(14, 5, 4, '2026-03-31 02:10:03'),
(15, 5, 5, '2026-03-31 02:10:03'),
(16, 5, 9, '2026-03-31 02:10:03'),
(17, 6, 6, '2026-03-31 02:10:03'),
(18, 6, 7, '2026-03-31 02:10:03'),
(19, 7, 2, '2026-03-31 02:10:03'),
(20, 7, 10, '2026-03-31 02:10:03'),
(21, 8, 1, '2026-03-31 02:10:03'),
(22, 8, 4, '2026-03-31 02:10:03'),
(23, 8, 8, '2026-03-31 02:10:03'),
(24, 9, 3, '2026-03-31 02:10:03'),
(25, 9, 7, '2026-03-31 02:10:03'),
(26, 9, 9, '2026-03-31 02:10:03'),
(27, 10, 5, '2026-03-31 02:10:03'),
(28, 10, 6, '2026-03-31 02:10:03'),
(29, 11, 2, '2026-03-31 02:10:03'),
(30, 11, 8, '2026-03-31 02:10:03'),
(31, 11, 10, '2026-03-31 02:10:03'),
(32, 12, 1, '2026-03-31 02:10:03'),
(33, 12, 5, '2026-03-31 02:10:03'),
(34, 13, 3, '2026-03-31 02:10:03'),
(35, 13, 4, '2026-03-31 02:10:03'),
(36, 13, 7, '2026-03-31 02:10:03'),
(37, 14, 8, '2026-03-31 02:10:03'),
(38, 14, 9, '2026-03-31 02:10:03'),
(39, 15, 2, '2026-03-31 02:10:03'),
(40, 15, 6, '2026-03-31 02:10:03'),
(41, 16, 1, '2026-03-31 02:10:03'),
(42, 16, 10, '2026-03-31 02:10:03'),
(43, 17, 4, '2026-03-31 02:10:03'),
(44, 17, 5, '2026-03-31 02:10:03'),
(45, 17, 8, '2026-03-31 02:10:03'),
(46, 18, 3, '2026-03-31 02:10:03'),
(47, 18, 9, '2026-03-31 02:10:03'),
(48, 19, 7, '2026-03-31 02:10:03'),
(49, 19, 10, '2026-03-31 02:10:03'),
(50, 20, 2, '2026-03-31 02:10:03'),
(51, 20, 4, '2026-03-31 02:10:03'),
(52, 21, 1, '2026-03-31 02:10:03'),
(53, 21, 6, '2026-03-31 02:10:03'),
(54, 21, 8, '2026-03-31 02:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `created_at`, `phone`) VALUES
(1, 'Tuấn Nguyễn', 'tuan.nguyen@example.com', '2026-03-31 02:10:03', '0981122334'),
(2, 'Le Thi Lan', 'lan.le@example.com', '2026-03-31 02:10:03', '0902233445'),
(3, 'Tran Van Minh', 'minh.tran@example.com', '2026-03-31 02:10:03', '0913344556'),
(4, 'Pham Quoc Hoang', 'hoang.pham@example.com', '2026-03-31 02:10:03', '0934455667'),
(5, 'Vu Thi Mai', 'mai.vu@example.com', '2026-03-31 02:10:03', '0945566778'),
(6, 'Doan Ha An', 'an.doan@example.com', '2026-03-31 02:10:03', '0976677889'),
(7, 'Hoang Trong Hieu', 'hieu.hoang@example.com', '2026-03-31 02:10:03', '0987788990'),
(8, 'Bui Thi Thuy', 'thuy.bui@example.com', '2026-03-31 02:10:03', '0328899001'),
(9, 'Dang Van Dat', 'dat.dang@example.com', '2026-03-31 02:10:03', '0339900112'),
(10, 'Ngo Kim Ngoc', 'ngoc.ngo@example.com', '2026-03-31 02:10:03', '0340011223'),
(11, 'Truong Tuan Kiet', 'kiet.truong@example.com', '2026-03-31 02:10:03', '0351122334'),
(12, 'Ly Ngoc Han', 'han.ly@example.com', '2026-03-31 02:10:03', '0362233445'),
(13, 'Vuong Dinh Trong', 'trong.vuong@example.com', '2026-03-31 02:10:03', '0373344556'),
(14, 'Phung Thanh Do', 'do.phung@example.com', '2026-03-31 02:10:03', '0384455667'),
(15, 'Dinh Ngoc Diep', 'diep.dinh@example.com', '2026-03-31 02:10:03', '0395566778'),
(16, 'Mai Phuong Thuy', 'thuy.mai@example.com', '2026-03-31 02:10:03', '0706677889'),
(17, 'Chu Bao Long', 'long.chu@example.com', '2026-03-31 02:10:03', '0797788990'),
(18, 'Lam Kieu Oanh', 'oanh.lam@example.com', '2026-03-31 02:10:03', '0778899001'),
(19, 'Phan Binh Minh', 'minh.phan@example.com', '2026-03-31 02:10:03', '0769900112'),
(20, 'Duong Thu Trang', 'trang.duong@example.com', '2026-03-31 02:10:03', '0780011223'),
(21, 'Trinh Xuan Thanh', 'thanh.trinh@example.com', '2026-03-31 02:10:03', '0891122334');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `email`, `phone`, `created_at`) VALUES
(1, 'Nguyễn Văn An', 'an.nguyen@school.edu.vn', '0981234567', '2026-04-16 19:54:21'),
(2, 'Trần Thị Bích', 'bich.tran@school.edu.vn', '0345678901', '2026-04-16 19:54:21'),
(3, 'Lê Hoàng Cường', 'cuong.le@school.edu.vn', NULL, '2026-04-16 19:54:21'),
(4, 'Phạm Thu Dung', 'dung.pham@school.edu.vn', '0812345678', '2026-04-16 19:54:21'),
(5, 'Hoàng Minh Đức', 'duc.hoang@school.edu.vn', '0912345678', '2026-04-16 19:54:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_enroll` (`student_id`,`course_id`),
  ADD KEY `fk_enroll_course` (`course_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `fk_enroll_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_enroll_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
