/*
DROP TABLE IF EXISTS accounts CASCADE;
DROP TABLE IF EXISTS courses CASCADE;
DROP TABLE IF EXISTS groups CASCADE;
DROP TABLE IF EXISTS user_courses;
DROP TABLE IF EXISTS user_groups;
DROP TABLE IF EXISTS course_discussions;
DROP TABLE IF EXISTS group_discussions;
*/
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
	course_code CHAR(7) REFERENCES courses(course_code),
	owner VARCHAR(60) REFERENCES accounts(username)
);

CREATE TABLE user_courses (
	username VARCHAR(60) REFERENCES accounts(username),
	course_code CHAR(7) REFERENCES courses(course_code)
);

CREATE TABLE user_groups (
	username VARCHAR(60) REFERENCES accounts(username),
	group_name VARCHAR(60) REFERENCES groups(group_name)
);

CREATE TABLE course_discussions (
	id SERIAL PRIMARY KEY,
	username VARCHAR(60) REFERENCES accounts(username),
	course_code CHAR(7) REFERENCES courses(course_code),
	post TEXT NOT NULL,
	time_posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE group_discussions (
	id SERIAL PRIMARY KEY,
	username VARCHAR(60) REFERENCES accounts(username),
	group_name VARCHAR(60) REFERENCES groups(group_name),
	post TEXT NOT NULL,
	time_posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
/*
DROP INDEX acc_user_idx;
DROP INDEX crs_code_idx;
DROP INDEX crs_title_idx;
DROP INDEX grp_name_idx;
DROP INDEX grp_code_idx;
DROP INDEX grp_owner_idx;
DROP INDEX u_crs_user_idx;
DROP INDEX u_crs_code_idx;
DROP INDEX u_grp_user_idx;
DROP INDEX u_grp_name_idx;
*/
CREATE INDEX acc_user_idx ON accounts(username);

CREATE INDEX crs_code_idx ON courses(course_code);
CREATE INDEX crs_title_idx ON courses(title);

CREATE INDEX grp_name_idx ON groups(group_name);
CREATE INDEX grp_code_idx ON groups(course_code);
CREATE INDEX grp_owner_idx ON groups(owner);

CREATE INDEX u_crs_user_idx ON user_courses(username);
CREATE INDEX u_crs_code_idx ON user_courses(course_code);

CREATE INDEX u_grp_user_idx ON user_groups(username);
CREATE INDEX u_grp_name_idx ON user_groups(group_name);

--DROP VIEW course_groups;

CREATE VIEW course_groups AS
SELECT username, course_code, group_name, description
FROM groups NATURAL JOIN user_groups;
/*
DELETE FROM courses CASCADE;
DELETE FROM groups CASCADE;
DELETE FROM user_courses;
DELETE FROM user_groups;

INSERT INTO courses (course_code, title)
VALUES
('CIS4301', 'Information and Database Systems 1'),
('CDA3101', 'Introduction to Computer Organization'),
('COP3530', 'Data Structures and Algorithms'),
('EGN4930', 'Sales Seminar'),
('MAS3114', 'Computational Linear Algebra');

INSERT INTO groups (group_name, course_code, owner)
VALUES
('Databuds', 'CIS4301', 'tanvirt'),
('Comporgo', 'CDA3101', 'tanvirt'),
('Cops', 'COP3530', 'tanvirt'),
('Structs', 'COP3530', 'cs_tim'),
('Salespeople', 'EGN4930', 'cs_tim'),
('Linearites', 'MAS3114', 'cs_tim');

INSERT INTO user_courses (username, course_code)
VALUES
('tanvirt', 'CIS4301'),
('tanvirt', 'CDA3101'),
('tanvirt', 'COP3530'),
('tanvirt', 'EGN4930'),
('cs_tim', 'EGN4930'),
('cs_tim', 'MAS3114'),
('cs_tim', 'COP3530'),
('cs_tim', 'CIS4301');

INSERT INTO user_groups (username, group_name)
VALUES
('tanvirt', 'Databuds'),
('tanvirt', 'Comporgo'),
('tanvirt', 'Cops'),
('tanvirt', 'Structs'),
('cs_tim', 'Salespeople'),
('cs_tim', 'Structs'),
('cs_tim', 'CIS4301');
*/