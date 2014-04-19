DROP TABLE IF EXISTS accounts CASCADE;
DROP TABLE IF EXISTS courses CASCADE;
DROP TABLE IF EXISTS groups CASCADE;
DROP TABLE IF EXISTS user_courses;
DROP TABLE IF EXISTS user_groups;
DROP TABLE IF EXISTS course_discussions;
DROP TABLE IF EXISTS group_discussions;

CREATE TABLE accounts (
	username VARCHAR(60) PRIMARY KEY,
	password_hash CHAR(60) NOT NULL,
	first_name VARCHAR(60) NOT NULL,
	last_name VARCHAR(60) NOT NULL
);

CREATE TABLE courses (
	course_code CHAR(7) PRIMARY KEY,
	title VARCHAR(60)
);

CREATE TABLE groups (
	group_name VARCHAR(60) PRIMARY KEY,
	description TEXT DEFAULT 'None',
	course_code CHAR(7) REFERENCES courses(course_code)
);
/*
DROP TABLE IF EXISTS instructors CASCADE;
CREATE TABLE instructors (
	name VARCHAR(60) PRIMARY KEY
);
*/
CREATE TABLE user_courses (
	username VARCHAR(60) REFERENCES accounts(username),
	course_code CHAR(7) REFERENCES courses(course_code)
);

CREATE TABLE user_groups (
	username VARCHAR(60) REFERENCES accounts(username),
	group_name VARCHAR(60) REFERENCES groups(group_name)
);
/*
DROP TABLE IF EXISTS instructor_courses;
CREATE TABLE instructor_courses (
	instructor_name VARCHAR(60) REFERENCES instructors(name),
	course_code CHAR(7) REFERENCES courses(course_code)
);
*/
CREATE TABLE course_discussions (
	id SERIAL PRIMARY KEY,
	username VARCHAR(60) REFERENCES accounts(username),
	course_code CHAR(7) REFERENCES courses(course_code),
	--topic VARCHAR(60) NOT NULL,
	post TEXT NOT NULL,
	time_posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE group_discussions (
	id SERIAL PRIMARY KEY,
	username VARCHAR(60) REFERENCES accounts(username),
	group_name VARCHAR(60) REFERENCES groups(group_name),
	--topic VARCHAR(60) NOT NULL,
	post TEXT NOT NULL,
	time_posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO courses (course_code, title)
VALUES
('CIS4301', 'Information and Database Systems 1'),
('CDA3101', 'Introduction to Computer Organization'),
('COP3530', 'Data Structures and Algorithms'),
('EGN4930', 'Sales Seminar'),
('MAS3114', 'Computational Linear Algebra');

INSERT INTO groups (group_name, course_code)
VALUES
('Databuds', 'CIS4301'),
('Comporgo', 'CDA3101'),
('Cops', 'COP3530'),
('Structs', 'COP3530'),
('Salespeople', 'EGN4930'),
('Linearites', 'MAS3114');

INSERT INTO user_courses (username, course_code)
VALUES
('tanvirt', 'CIS4301'),
('tanvirt', 'CDA3101'),
('tanvirt', 'COP3530');

INSERT INTO user_groups (username, group_name)
VALUES
('tanvirt', 'Databuds'),
('tanvirt', 'Cops'),
('tanvirt', 'Structs');