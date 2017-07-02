--
-- Database: `project_system_db`
--

USE project_system_db;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` VALUES 
(1,'01','MIS','test project','2017-03-11','2017-06-30',1,1),
(2,'02','software creation','making a software for projects','2017-03-12','2017-06-03',1,1),
(3,'03','Mobile app','creating a application for android ','2017-03-13','2017-06-17',1,1),
(4,'04','programming','learn to do coding','2017-02-17','2017-05-12',1,1);

-- --------------------------------------------------------

--
-- Dumping data for table `users`
--

INSERT INTO `users` (username, first_name, last_name, email, password, role_id) VALUES
('Pragati_Koirala','Pragati','Koirala','pragatikrl@yahoo.com','mouse123',2),
('Mouse_Rat','Mouse','Rat','mouse@gmail.com','12345',2),
('Isha','isha','rana','isha@gmail.com','gmail',2),
('Jatinder_Singh','Jatinder','Singh','jatinder_singh@yahoo.in','1234',2),
('Jagga_Singh','singh','Jagga','Jagga_Singh@live.in','1234',2),
('Amrendra_Bahubali','Amrendra','Bahubali','Bahubali@gmail.com','1234',2),
('Shivgami_Devi','Shivgami','Devi','Shivgami_Devi@bahubali.in','1234',2),
('Kutappa_singh','Kutappa','Singh','Kutappa_singh@yahoo.in','1234',2),
('chemmasaab','Harman','Chemma','chemmasaab@gmail.com','1234',2),
('Pooja','Pooja','Saini','Pooja@GMAIL.COM','1234',2),
('LoveleenKaur','Loveleen','Kaur','LoveleenKaur@live.com','1234',2),
('pawan_reru','reru','reru','rerupawan@gmail.com','1234',2),
('john_smith','john','smith','smith@gmail.com','1234',2),
('singh_komal','singh','komal','komalsingh@gmail.com','1234',2),
('yad_singh','yad','singh','yad_singh@gmail.com','1234',2);

-- --------------------------------------------------------

--
-- Dumping data for table `project_assigned`
--

INSERT INTO `project_assigned` VALUES 
(1,4,2,2),
(2,2,9,2),
(3,1,13,2),
(4,1,3,2),
(5,3,8,2),
(6,3,15,2),
(7,4,16,2),
(8,2,14,2);

-- --------------------------------------------------------
