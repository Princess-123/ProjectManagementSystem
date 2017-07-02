--
-- Database: `project_system_db`
--

DROP DATABASE IF EXISTS project_system_db;

CREATE DATABASE project_system_db;

USE project_system_db;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE categories (
  id int NOT NULL PRIMARY KEY,
  category varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO categories (id, category) VALUES
(1, 'IT'),
(2, 'Engineering'),
(3, 'Science');

-- --------------------------------------------------------

--
-- Table structure for table `project_assigned_status`
--

CREATE TABLE project_assigned_status (
  id int NOT NULL PRIMARY KEY,
  name varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_assigned_status`
--

INSERT INTO project_assigned_status (id, name) VALUES
(1, 'Requested'),
(2, 'Assigned'),
(3, 'In Progress'),
(4, 'Completed'),
(5, 'Rejected');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE roles (
  id int NOT NULL PRIMARY KEY,
  name varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO roles (id, name) VALUES
(1, 'Admin'),
(2, 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE users (
  id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  username varchar(25) NOT NULL,
  first_name varchar(25) DEFAULT NULL,
  last_name varchar(25) DEFAULT NULL,
  email varchar(50) NOT NULL,
  password varchar(25) NOT NULL,
  role_id int NOT NULL,
  FOREIGN KEY (role_id)
      REFERENCES roles(id)
      ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO users (id, username, first_name, last_name, email, password, role_id) VALUES
(1, 'admin', 'admin', 'admin', 'admin@admin.com', '1234', 1);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE projects (
  id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  code varchar(10) NOT NULL,
  name varchar(50) NOT NULL,
  description text NOT NULL,
  start_date date NOT NULL,
  end_date date NOT NULL,
  created_by int NOT NULL,
  category_id int NOT NULL,
  FOREIGN KEY (created_by)
      REFERENCES users(id)
      ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (category_id)
      REFERENCES categories(id)
      ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_assigned`
--

CREATE TABLE project_assigned (
  id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  project_id int NOT NULL,
  user_id int NOT NULL,
  assigned_status_id int NOT NULL,
  FOREIGN KEY (project_id)
      REFERENCES projects(id)
      ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (user_id)
      REFERENCES users(id)
      ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (assigned_status_id)
      REFERENCES project_assigned_status(id)
      ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE uploads (
  id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  project_assigned_id int NOT NULL,
  file varchar(255) NOT NULL,
  size int DEFAULT NULL,
  FOREIGN KEY (project_assigned_id)
      REFERENCES project_assigned(id)
      ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE notifications (
  id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  notification_text text NOT NULL,
  project_id int NOT NULL,
  sent_by int NOT NULL,
  received_by int NOT NULL,
  date datetime NOT NULL,
  FOREIGN KEY (project_id)
      REFERENCES projects(id)
      ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (sent_by)
      REFERENCES users(id)
      ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (received_by)
      REFERENCES users(id)
      ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_history`
--

CREATE TABLE project_history (
  id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  description text NOT NULL,
  project_id int NOT NULL,
  date datetime NOT NULL,
  FOREIGN KEY (project_id)
      REFERENCES projects(id)
      ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

