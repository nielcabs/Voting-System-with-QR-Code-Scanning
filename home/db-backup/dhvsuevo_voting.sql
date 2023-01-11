

CREATE TABLE `tbl_candidates` (
  `rec_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`rec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=242 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `tbl_department` (
  `rec_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_id` varchar(150) NOT NULL,
  `department` varchar(150) NOT NULL,
  PRIMARY KEY (`rec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_department VALUES("1","COE","College of Education");
INSERT INTO tbl_department VALUES("2","CBS","College of Business Studies");
INSERT INTO tbl_department VALUES("3","CSSP","College of Social Science and Philosophy");
INSERT INTO tbl_department VALUES("4","CHM","College of Hospitality Management");
INSERT INTO tbl_department VALUES("5","CIT","College of Industrial Technology");
INSERT INTO tbl_department VALUES("6","CAS","College of Arts and Sciences");
INSERT INTO tbl_department VALUES("7","LHS","Laboratory High School");
INSERT INTO tbl_department VALUES("8","SHS","Senior High School");
INSERT INTO tbl_department VALUES("9","CCS","College of Computing Studies");
INSERT INTO tbl_department VALUES("10","CEA","College of Engineering and Architecture");



CREATE TABLE `tbl_election` (
  `rec_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_by` varchar(100) NOT NULL,
  PRIMARY KEY (`rec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `tbl_election_type` (
  `rec_id` int(11) NOT NULL AUTO_INCREMENT,
  `election_type` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`rec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_election_type VALUES("1","FCE","Faculty Election");
INSERT INTO tbl_election_type VALUES("2","USC","University Student Council");
INSERT INTO tbl_election_type VALUES("3","LDSC","Local/Department Student Council");



CREATE TABLE `tbl_party` (
  `rec_id` int(11) NOT NULL AUTO_INCREMENT,
  `party_name` varchar(250) NOT NULL,
  `election_type` varchar(250) NOT NULL,
  `dept_id` varchar(250) NOT NULL,
  `election_id` varchar(100) NOT NULL,
  `election_status` varchar(100) NOT NULL,
  PRIMARY KEY (`rec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `tbl_position` (
  `rec_id` int(11) NOT NULL AUTO_INCREMENT,
  `election_type` varchar(100) NOT NULL,
  `position_id` varchar(100) NOT NULL,
  `position_name` varchar(100) NOT NULL,
  `added_by` varchar(100) NOT NULL,
  `date_added` varchar(100) NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `date_updated` varchar(100) NOT NULL,
  PRIMARY KEY (`rec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_position VALUES("1","USC","PD","President","","","","");
INSERT INTO tbl_position VALUES("2","USC","VP","Vice-President","","","","");
INSERT INTO tbl_position VALUES("3","USC","SR","Senator on Records","","","","");
INSERT INTO tbl_position VALUES("4","USC","SF","Senator on Finance","","","","");
INSERT INTO tbl_position VALUES("5","USC","SA","Senator on Audit","","","","");
INSERT INTO tbl_position VALUES("6","USC","SPI","Senator on Public Information","","","","");
INSERT INTO tbl_position VALUES("7","USC","SBA","Senator on Business Affair","","","","");
INSERT INTO tbl_position VALUES("8","USC","SSA","Senator on Student Affair","","","","");
INSERT INTO tbl_position VALUES("9","USC","SSR","Senator on Student Services","","","","");
INSERT INTO tbl_position VALUES("10","USC","SGD","Senator on Gender & Development","","","","");
INSERT INTO tbl_position VALUES("11","LDSC","GV","Governor","","","","");
INSERT INTO tbl_position VALUES("12","LDSC","VG","Vice-Governor","","","","");
INSERT INTO tbl_position VALUES("13","LDSC","BMR","Board Member on Records","","","","");
INSERT INTO tbl_position VALUES("14","LDSC","BMF","Board Member on Finance","","","","");
INSERT INTO tbl_position VALUES("15","LDSC","BMA","Board Member on Audit","","","","");
INSERT INTO tbl_position VALUES("16","LDSC","BBA","Board Member on Business Affair","","","","");
INSERT INTO tbl_position VALUES("17","LDSC","BMSA","Board Member on Student Affair","","","","");
INSERT INTO tbl_position VALUES("18","LDSC","BMSS","Board Member on Student Services","","","","");
INSERT INTO tbl_position VALUES("19","LDSC","BMPI","Board Member on Public Information","","","","");
INSERT INTO tbl_position VALUES("20","LDSC","BMGD","Board Member on Gender and Development","","","","");
INSERT INTO tbl_position VALUES("21","FCE","PD","President","","","","");
INSERT INTO tbl_position VALUES("22","FCE","VP","Vice-President","","","","");
INSERT INTO tbl_position VALUES("23","FCE","SC","Secretary","","","","");
INSERT INTO tbl_position VALUES("24","FCE","TRE","Treasury","","","","");
INSERT INTO tbl_position VALUES("25","FCE","AUD","Auditor","","","","");
INSERT INTO tbl_position VALUES("26","FCE","PRO","PRO","","","","");
INSERT INTO tbl_position VALUES("27","FCE","SGA","Sergeant and Arms","","","","");
INSERT INTO tbl_position VALUES("28","FCE","BM","Business Manager","","","","");



CREATE TABLE `tbl_user_access` (
  `rec_id` int(11) NOT NULL AUTO_INCREMENT,
  `access_rights` varchar(15) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`rec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_user_access VALUES("1","SUPERADMIN","Full Access Administrator");
INSERT INTO tbl_user_access VALUES("2","std_voter","Student Voter");
INSERT INTO tbl_user_access VALUES("3","faculty_admin","Faculty Administrator");
INSERT INTO tbl_user_access VALUES("4","faculty_voter","Faculty Voter");
INSERT INTO tbl_user_access VALUES("5","std_admin","Student Administrator");



CREATE TABLE `tbl_users` (
  `rec_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `last_login` datetime NOT NULL,
  PRIMARY KEY (`rec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1073 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_users VALUES("1","10896","21460e212aeb4175","","Juan","D.","Dela Cruz","sample@gmail.com","ADM","0","","","SUPERADMIN","N","N","Y","","N","N","","","2022-10-14 21:28:52","","2022-10-14 15:28:52","2022-10-14 15:28:52");
INSERT INTO tbl_users VALUES("2","10897","21460e212aeb4175","","Kayla","B.","Layug","it.kaylablayug@gmail.com","CHM","4","","4A","std_admin","N","N","Y","profile_pic/10897-ac845c4cea7e9db2e8d009e4483cf64f.jpg","N","N","2022-11-28 10:21:04","10896","2022-10-15 11:46:17","Kayla B. Layug","2023-01-06 11:02:42","0000-00-00 00:00:00");
INSERT INTO tbl_users VALUES("25","10895","21460e212aeb4175","","Tricia","P.","Gueco","tricia@gmail.com","CHM","","","","faculty_admin","N","N","Y","profile_pic/10895-photo-1534528741775-53994a69daeb.jpg","N","N","2022-11-01 15:43:44","10896","2022-10-15 22:01:40","Tricia P. Gueco","2022-11-30 16:48:27","0000-00-00 00:00:00");



CREATE TABLE `tbl_voter_status` (
  `rec_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id_voter` varchar(250) DEFAULT NULL,
  `election_id` varchar(250) DEFAULT NULL,
  `status_vote` varchar(1) DEFAULT NULL,
  `verification_code` varchar(100) NOT NULL,
  `date_added` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`rec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_voter_status VALUES("1","20221213","LDSC-CCS-20221214-001","Y","424990-0001","2022-12-13 07:48:19");
INSERT INTO tbl_voter_status VALUES("2","2021050","LDSC-CHM-20221214-001","Y","267809-0001","2022-12-15 08:22:11");



CREATE TABLE `tbl_votes` (
  `rec_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id_voter` varchar(250) NOT NULL,
  `candidate_id` varchar(250) NOT NULL,
  `candidate_pos` varchar(250) NOT NULL,
  `election_id` varchar(250) NOT NULL,
  `date_added` varchar(250) NOT NULL,
  PRIMARY KEY (`rec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_votes VALUES("1","20221213","208","GV","LDSC-CCS-20221214-001","2022-12-13 07:48:19");
INSERT INTO tbl_votes VALUES("2","20221213","209","VG","LDSC-CCS-20221214-001","2022-12-13 07:48:19");
INSERT INTO tbl_votes VALUES("3","20221213","210","BMR","LDSC-CCS-20221214-001","2022-12-13 07:48:19");
INSERT INTO tbl_votes VALUES("4","20221213","211","BMF","LDSC-CCS-20221214-001","2022-12-13 07:48:19");
INSERT INTO tbl_votes VALUES("5","20221213","212","BMA","LDSC-CCS-20221214-001","2022-12-13 07:48:19");
INSERT INTO tbl_votes VALUES("6","20221213","213","BBA","LDSC-CCS-20221214-001","2022-12-13 07:48:19");
INSERT INTO tbl_votes VALUES("7","20221213","214","BMSA","LDSC-CCS-20221214-001","2022-12-13 07:48:19");
INSERT INTO tbl_votes VALUES("8","20221213","215","BMSS","LDSC-CCS-20221214-001","2022-12-13 07:48:19");
INSERT INTO tbl_votes VALUES("9","20221213","216","BMPI","LDSC-CCS-20221214-001","2022-12-13 07:48:19");
INSERT INTO tbl_votes VALUES("10","20221213","217","BMGD","LDSC-CCS-20221214-001","2022-12-13 07:48:19");
INSERT INTO tbl_votes VALUES("11","2021050","222","GV","LDSC-CHM-20221214-001","2022-12-15 08:22:11");
INSERT INTO tbl_votes VALUES("12","2021050","223","VG","LDSC-CHM-20221214-001","2022-12-15 08:22:11");
INSERT INTO tbl_votes VALUES("13","2021050","225","BMF","LDSC-CHM-20221214-001","2022-12-15 08:22:11");
INSERT INTO tbl_votes VALUES("14","2021050","226","BMA","LDSC-CHM-20221214-001","2022-12-15 08:22:11");
INSERT INTO tbl_votes VALUES("15","2021050","227","BBA","LDSC-CHM-20221214-001","2022-12-15 08:22:11");
INSERT INTO tbl_votes VALUES("16","2021050","229","BMSS","LDSC-CHM-20221214-001","2022-12-15 08:22:11");
INSERT INTO tbl_votes VALUES("17","2021050","230","BMPI","LDSC-CHM-20221214-001","2022-12-15 08:22:11");

