-- Connect to the chuka database
USE chuka;

-- Create the login table
CREATE TABLE login (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Registration VARCHAR(50) NOT NULL,
    Faculty VARCHAR(100) NOT NULL,
    IDNo VARCHAR(20) NOT NULL,
    Name VARCHAR(20) ,
    SubmissionDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   
);

-- Insert sample data into the login table (if needed)
INSERT INTO login (Registration, Faculty, IDNo,Name) 
VALUES ('SampleRegNo', 'SampleFaculty', 'SampleIDNo','Macharia');





CREATE TABLE admins (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(40) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data into the admins table
-- Passwords are hashed using bcrypt (placeholders below)
INSERT INTO admins (username, password, phone) VALUES
('admin1', 'Supporting1', '0797105298'),
('admin2', 'Supporting2', '0706134493');



CREATE TABLE candidates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    position VARCHAR(50),
    faculty VARCHAR(50) NULL,
    email VARCHAR(50) NOT NULL,
    description TEXT,
    photo_path VARCHAR(255),
    FOREIGN KEY (email) REFERENCES details(email)
);
INSERT INTO candidates (name, position, faculty,email) VALUES
('Victor Macharia', 'president', NULL),
('Adrian Macharia', 'president', NULL),
('Faith Chepkoril', 'president', NULL),
('Eunice Wanja', 'deputy', NULL),
('Pamela Wanja', 'deputy', NULL),
('Yvone Ngima', 'deputy', NULL),
('Grace Anari', 'faculty-rep', 'Law'),
('Natasha Nyawira', 'faculty-rep', 'Law'),
('Linet Nyawira', 'faculty-rep', 'Business'),
('David Maina', 'faculty-rep', 'Engineering'),
('Erastus Mugo', 'residence-rep', NULL),
('Edna Muthoni', 'residence-rep', NULL),
('Maureen Wambui', 'non-resident-rep', NULL),
('Evans Bet', 'non-resident-rep', NULL),
('Precious Njeri', 'environment-rep', NULL),
('Moses Lengaresi', 'environment-rep', NULL),
('Safari Lokolonyei', 'sports-rep', NULL),
('CAtherine Mulwa', 'sports-rep', NULL);



CREATE TABLE votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    position VARCHAR(255) NOT NULL,
    candidate_id INT NOT NULL,
    vote_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES login(id),
    FOREIGN KEY (candidate_id) REFERENCES candidates(id)
);


CREATE TABLE details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    Registration VARCHAR(50) NOT NULL,
    IDNo VARCHAR(50) NOT NULL,
    UNIQUE (email, Registration, IDNo)
);

-- Insert sample data
INSERT INTO details (email, Registration, IDNo) VALUES
('candidate1@example.com', 'CAND001', '12345678'),
('candidate2@example.com', 'CAND002', '87654321');

CREATE TABLE announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    announcement TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
