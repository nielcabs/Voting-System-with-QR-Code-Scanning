-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2023 at 04:09 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dhvsuevo_voting`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_candidates`
--

CREATE TABLE `tbl_candidates` (
  `rec_id` int(11) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `vote_count` int(11) NOT NULL,
  `platform` text NOT NULL,
  `party_name` varchar(200) NOT NULL,
  `election_id` varchar(100) NOT NULL,
  `dept_id` varchar(100) NOT NULL,
  `election_status` varchar(100) NOT NULL,
  `year` varchar(100) NOT NULL,
  `profile_pic` varchar(200) NOT NULL,
  `added_by` varchar(100) NOT NULL,
  `date_added` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `date_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE `tbl_department` (
  `rec_id` int(11) NOT NULL,
  `dept_id` varchar(150) NOT NULL,
  `department` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`rec_id`, `dept_id`, `department`) VALUES
(1, 'COE', 'College of Education'),
(2, 'CBS', 'College of Business Studies'),
(3, 'CSSP', 'College of Social Science and Philosophy'),
(4, 'CHM', 'College of Hospitality Management'),
(5, 'CIT', 'College of Industrial Technology'),
(6, 'CAS', 'College of Arts and Sciences'),
(7, 'LHS', 'Laboratory High School'),
(8, 'SHS', 'Senior High School'),
(9, 'CCS', 'College of Computing Studies'),
(10, 'CEA', 'College of Engineering and Architecture');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_election`
--

CREATE TABLE `tbl_election` (
  `rec_id` int(11) NOT NULL,
  `election_id` varchar(100) NOT NULL,
  `election_name` varchar(250) NOT NULL,
  `department` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'N',
  `date_started` varchar(100) NOT NULL,
  `date_start_time` varchar(100) NOT NULL,
  `date_end` varchar(100) NOT NULL,
  `date_end_time` varchar(100) NOT NULL,
  `dmo` varchar(2) NOT NULL,
  `dyear` varchar(4) NOT NULL,
  `date_created` varchar(100) NOT NULL,
  `added_by` varchar(100) NOT NULL,
  `date_updated` varchar(100) NOT NULL,
  `updated_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_election_type`
--

CREATE TABLE `tbl_election_type` (
  `rec_id` int(11) NOT NULL,
  `election_type` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_election_type`
--

INSERT INTO `tbl_election_type` (`rec_id`, `election_type`, `description`) VALUES
(1, 'FCE', 'Faculty Election'),
(2, 'USC', 'University Student Council'),
(3, 'LDSC', 'Local/Department Student Council');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_party`
--

CREATE TABLE `tbl_party` (
  `rec_id` int(11) NOT NULL,
  `party_name` varchar(250) NOT NULL,
  `election_type` varchar(250) NOT NULL,
  `dept_id` varchar(250) NOT NULL,
  `election_id` varchar(100) NOT NULL,
  `election_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_position`
--

CREATE TABLE `tbl_position` (
  `rec_id` int(11) NOT NULL,
  `election_type` varchar(100) NOT NULL,
  `position_id` varchar(100) NOT NULL,
  `position_name` varchar(100) NOT NULL,
  `added_by` varchar(100) NOT NULL,
  `date_added` varchar(100) NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `date_updated` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_position`
--

INSERT INTO `tbl_position` (`rec_id`, `election_type`, `position_id`, `position_name`, `added_by`, `date_added`, `updated_by`, `date_updated`) VALUES
(1, 'USC', 'PD', 'President', '', '', '', ''),
(2, 'USC', 'VP', 'Vice-President', '', '', '', ''),
(3, 'USC', 'SR', 'Senator on Records', '', '', '', ''),
(4, 'USC', 'SF', 'Senator on Finance', '', '', '', ''),
(5, 'USC', 'SA', 'Senator on Audit', '', '', '', ''),
(6, 'USC', 'SPI', 'Senator on Public Information', '', '', '', ''),
(7, 'USC', 'SBA', 'Senator on Business Affair', '', '', '', ''),
(8, 'USC', 'SSA', 'Senator on Student Affair', '', '', '', ''),
(9, 'USC', 'SSR', 'Senator on Student Services', '', '', '', ''),
(10, 'USC', 'SGD', 'Senator on Gender & Development', '', '', '', ''),
(11, 'LDSC', 'GV', 'Governor', '', '', '', ''),
(12, 'LDSC', 'VG', 'Vice-Governor', '', '', '', ''),
(13, 'LDSC', 'BMR', 'Board Member on Records', '', '', '', ''),
(14, 'LDSC', 'BMF', 'Board Member on Finance', '', '', '', ''),
(15, 'LDSC', 'BMA', 'Board Member on Audit', '', '', '', ''),
(16, 'LDSC', 'BBA', 'Board Member on Business Affair', '', '', '', ''),
(17, 'LDSC', 'BMSA', 'Board Member on Student Affair', '', '', '', ''),
(18, 'LDSC', 'BMSS', 'Board Member on Student Services', '', '', '', ''),
(19, 'LDSC', 'BMPI', 'Board Member on Public Information', '', '', '', ''),
(20, 'LDSC', 'BMGD', 'Board Member on Gender and Development', '', '', '', ''),
(21, 'FCE', 'PD', 'President', '', '', '', ''),
(22, 'FCE', 'VP', 'Vice-President', '', '', '', ''),
(23, 'FCE', 'SC', 'Secretary', '', '', '', ''),
(24, 'FCE', 'TRE', 'Treasury', '', '', '', ''),
(25, 'FCE', 'AUD', 'Auditor', '', '', '', ''),
(26, 'FCE', 'PRO', 'PRO', '', '', '', ''),
(27, 'FCE', 'SGA', 'Sergeant and Arms', '', '', '', ''),
(28, 'FCE', 'BM', 'Business Manager', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `rec_id` int(11) NOT NULL,
  `username_id` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dept_id` varchar(100) NOT NULL,
  `year` varchar(100) NOT NULL,
  `std_class` varchar(100) NOT NULL,
  `section` varchar(100) NOT NULL,
  `access_rights` varchar(100) NOT NULL,
  `tag_to_vote` varchar(1) NOT NULL DEFAULT 'N',
  `vote_status` varchar(1) NOT NULL DEFAULT 'N',
  `active` varchar(1) NOT NULL DEFAULT 'Y',
  `profile_pic` varchar(200) NOT NULL,
  `chg_password` varchar(1) NOT NULL DEFAULT 'N',
  `auth_login` varchar(1) NOT NULL DEFAULT 'Y',
  `change_date` varchar(100) NOT NULL,
  `added_by` varchar(100) NOT NULL,
  `date_added` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `date_updated` datetime NOT NULL,
  `last_login` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`rec_id`, `username_id`, `user_password`, `code`, `first_name`, `middle_name`, `last_name`, `email`, `dept_id`, `year`, `std_class`, `section`, `access_rights`, `tag_to_vote`, `vote_status`, `active`, `profile_pic`, `chg_password`, `auth_login`, `change_date`, `added_by`, `date_added`, `updated_by`, `date_updated`, `last_login`) VALUES
(1, '10896', '21460e212aeb4175', '', 'Juan', 'D.', 'Dela Cruz', 'sample@gmail.com', 'ADM', '0', '', '', 'SUPERADMIN', 'N', 'N', 'Y', '', 'N', 'N', '', '', '2022-10-14 21:28:52', '', '2022-10-14 15:28:52', '2022-10-14 15:28:52'),
(2, '10897', '21460e212aeb4175', '', 'Kayla', 'B.', 'Layug', 'it.kaylablayug@gmail.com', 'CHM', '4', '', '4A', 'std_admin', 'N', 'N', 'Y', 'profile_pic/10897-ac845c4cea7e9db2e8d009e4483cf64f.jpg', 'N', 'N', '2022-11-28 10:21:04', '10896', '2022-10-15 11:46:17', 'Kayla B. Layug', '2023-01-06 11:02:42', '0000-00-00 00:00:00'),
(25, '10895', '21460e212aeb4175', '', 'Tricia', 'P.', 'Gueco', 'tricia@gmail.com', 'CHM', '', '', '', 'faculty_admin', 'N', 'N', 'Y', 'profile_pic/10895-photo-1534528741775-53994a69daeb.jpg', 'N', 'N', '2022-11-01 15:43:44', '10896', '2022-10-15 22:01:40', 'Tricia P. Gueco', '2022-11-30 16:48:27', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_access`
--

CREATE TABLE `tbl_user_access` (
  `rec_id` int(11) NOT NULL,
  `access_rights` varchar(15) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user_access`
--

INSERT INTO `tbl_user_access` (`rec_id`, `access_rights`, `description`) VALUES
(1, 'SUPERADMIN', 'Full Access Administrator'),
(2, 'std_voter', 'Student Voter'),
(3, 'faculty_admin', 'Faculty Administrator'),
(4, 'faculty_voter', 'Faculty Voter'),
(5, 'std_admin', 'Student Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_voter_status`
--

CREATE TABLE `tbl_voter_status` (
  `rec_id` int(11) NOT NULL,
  `student_id_voter` varchar(250) DEFAULT NULL,
  `election_id` varchar(250) DEFAULT NULL,
  `status_vote` varchar(1) DEFAULT NULL,
  `verification_code` varchar(100) NOT NULL,
  `date_added` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_voter_status`
--

INSERT INTO `tbl_voter_status` (`rec_id`, `student_id_voter`, `election_id`, `status_vote`, `verification_code`, `date_added`) VALUES
(1, '20221213', 'LDSC-CCS-20221214-001', 'Y', '424990-0001', '2022-12-13 07:48:19'),
(2, '2021050', 'LDSC-CHM-20221214-001', 'Y', '267809-0001', '2022-12-15 08:22:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_votes`
--

CREATE TABLE `tbl_votes` (
  `rec_id` int(11) NOT NULL,
  `student_id_voter` varchar(250) NOT NULL,
  `candidate_id` varchar(250) NOT NULL,
  `candidate_pos` varchar(250) NOT NULL,
  `election_id` varchar(250) NOT NULL,
  `date_added` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_votes`
--

INSERT INTO `tbl_votes` (`rec_id`, `student_id_voter`, `candidate_id`, `candidate_pos`, `election_id`, `date_added`) VALUES
(1, '20221213', '208', 'GV', 'LDSC-CCS-20221214-001', '2022-12-13 07:48:19'),
(2, '20221213', '209', 'VG', 'LDSC-CCS-20221214-001', '2022-12-13 07:48:19'),
(3, '20221213', '210', 'BMR', 'LDSC-CCS-20221214-001', '2022-12-13 07:48:19'),
(4, '20221213', '211', 'BMF', 'LDSC-CCS-20221214-001', '2022-12-13 07:48:19'),
(5, '20221213', '212', 'BMA', 'LDSC-CCS-20221214-001', '2022-12-13 07:48:19'),
(6, '20221213', '213', 'BBA', 'LDSC-CCS-20221214-001', '2022-12-13 07:48:19'),
(7, '20221213', '214', 'BMSA', 'LDSC-CCS-20221214-001', '2022-12-13 07:48:19'),
(8, '20221213', '215', 'BMSS', 'LDSC-CCS-20221214-001', '2022-12-13 07:48:19'),
(9, '20221213', '216', 'BMPI', 'LDSC-CCS-20221214-001', '2022-12-13 07:48:19'),
(10, '20221213', '217', 'BMGD', 'LDSC-CCS-20221214-001', '2022-12-13 07:48:19'),
(11, '2021050', '222', 'GV', 'LDSC-CHM-20221214-001', '2022-12-15 08:22:11'),
(12, '2021050', '223', 'VG', 'LDSC-CHM-20221214-001', '2022-12-15 08:22:11'),
(13, '2021050', '225', 'BMF', 'LDSC-CHM-20221214-001', '2022-12-15 08:22:11'),
(14, '2021050', '226', 'BMA', 'LDSC-CHM-20221214-001', '2022-12-15 08:22:11'),
(15, '2021050', '227', 'BBA', 'LDSC-CHM-20221214-001', '2022-12-15 08:22:11'),
(16, '2021050', '229', 'BMSS', 'LDSC-CHM-20221214-001', '2022-12-15 08:22:11'),
(17, '2021050', '230', 'BMPI', 'LDSC-CHM-20221214-001', '2022-12-15 08:22:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_candidates`
--
ALTER TABLE `tbl_candidates`
  ADD PRIMARY KEY (`rec_id`);

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`rec_id`);

--
-- Indexes for table `tbl_election`
--
ALTER TABLE `tbl_election`
  ADD PRIMARY KEY (`rec_id`);

--
-- Indexes for table `tbl_election_type`
--
ALTER TABLE `tbl_election_type`
  ADD PRIMARY KEY (`rec_id`);

--
-- Indexes for table `tbl_party`
--
ALTER TABLE `tbl_party`
  ADD PRIMARY KEY (`rec_id`);

--
-- Indexes for table `tbl_position`
--
ALTER TABLE `tbl_position`
  ADD PRIMARY KEY (`rec_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`rec_id`);

--
-- Indexes for table `tbl_user_access`
--
ALTER TABLE `tbl_user_access`
  ADD PRIMARY KEY (`rec_id`);

--
-- Indexes for table `tbl_voter_status`
--
ALTER TABLE `tbl_voter_status`
  ADD PRIMARY KEY (`rec_id`);

--
-- Indexes for table `tbl_votes`
--
ALTER TABLE `tbl_votes`
  ADD PRIMARY KEY (`rec_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_candidates`
--
ALTER TABLE `tbl_candidates`
  MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_election`
--
ALTER TABLE `tbl_election`
  MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tbl_election_type`
--
ALTER TABLE `tbl_election_type`
  MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_party`
--
ALTER TABLE `tbl_party`
  MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_position`
--
ALTER TABLE `tbl_position`
  MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1069;

--
-- AUTO_INCREMENT for table `tbl_user_access`
--
ALTER TABLE `tbl_user_access`
  MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_voter_status`
--
ALTER TABLE `tbl_voter_status`
  MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_votes`
--
ALTER TABLE `tbl_votes`
  MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
