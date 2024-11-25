CREATE TABLE user_accounts (
	user_id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255),
	first_name VARCHAR(255),
	last_name VARCHAR(255),
	password TEXT,
	date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	role ENUM('applicant', 'HR') NOT NULL
);

CREATE TABLE applications (
	application_id INT AUTO_INCREMENT PRIMARY KEY,
	address VARCHAR(255),
	first_name VARCHAR(255),
	last_name VARCHAR(255),
	email VARCHAR(255),
	gender VARCHAR(255),
	state VARCHAR(255),
	nationality VARCHAR(255),
	specialty VARCHAR(255),
	date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	added_by VARCHAR(255),
	last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	last_updated_by VARCHAR(255),
	status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending';
	resume_path VARCHAR(255) NOT NULL;
);

CREATE TABLE activity_logs (
	activity_log_id INT AUTO_INCREMENT PRIMARY KEY,
	operation VARCHAR(255),
	application_id INT,
	address VARCHAR(255),
	first_name VARCHAR(255),
	last_name VARCHAR (255),
	username VARCHAR(255),
	search_keyword VARCHAR(255) NULL,
	date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);