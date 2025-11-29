create database feedback;
use feedback;


CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    feedback TEXT,
    rating INT,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


select * from feedback;