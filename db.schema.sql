create database AukAttandance;
use AukAttandance;
CREATE TABLE AcademicLecturer(
	EntryID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(200),
    MiddleName VARCHAR(200),
    LastName VARCHAR(200),
    EmailAddress VARCHAR(200),
    AccountPassword VARCHAR(200),
    CreatedOn datetime default current_timestamp
);

CREATE TABLE Class(
	EntryID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    CourseCode VARCHAR(200),
    CourseTitle VARCHAR(200),
    CourseYear VARCHAR(200),
    CreatedBy INT,
    CreatedOn datetime default current_timestamp
);

CREATE TABLE Students(
	EntryID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    StudentID VARCHAR(200),
    FullName VARCHAR(200),
    EmailAddress VARCHAR(200),
    CourseID INT,
    CreatedBy INT,
    CreatedOn datetime default current_timestamp
);

CREATE TABLE Tokens(
	EntryID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    TokenStatus tinyint,
    ClassDate date,
    Token VARCHAR(200),
    CourseID INT,
    CreatedBy INT,
    CreatedOn datetime default current_timestamp
);


CREATE TABLE Attendance(
	EntryID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    StudentID int,
    TokenID INT,
    CourseID INT,
    CreatedOn datetime default current_timestamp
);

CREATE VIEW AttendedView AS SELECT 
    t.EntryID TokenID,
    c.EntryID ClassID,
    StudentID,
    ClassDate
FROM
    Attendance a
        JOIN
    Class c ON a.CourseID = c.EntryID
        JOIN
    Tokens t ON t.EntryID = a.TokenID;


DELIMITER $$
CREATE FUNCTION `GetCourseCode`(ID INT) RETURNS text CHARSET utf8mb4
BEGIN
DECLARE rec VARCHAR(200);
SELECT CourseCode INTO rec FROM Class WHERE EntryID LIKE ID LIMIT 0,1;
RETURN rec;
END$$

DELIMITER ;

