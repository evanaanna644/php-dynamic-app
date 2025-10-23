CREATE DATABASE dynamic_project;
USE dynamic_project;

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `course` varchar(50) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
);

INSERT INTO `students` (`student_id`, `name`, `email`, `phone`, `course`, `gender`, `dob`, `address`) VALUES
(1, 'Nithin', 'nithin@gmail.com', '9876543210', 'CS', 'Male', '2003-06-05', 'Adoor'),
(2, 'Riya', 'riya@gmail.com', '9753135790', 'CS', 'Female', '2003-10-23', 'Nalanchira'),
(3, 'Shreya', 'shreya@gmail.com', '9123456780', 'EC', 'Female', '2004-08-25', 'Kollam');
