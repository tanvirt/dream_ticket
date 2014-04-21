
DROP TABLE IF EXISTS accounts CASCADE;
DROP TABLE IF EXISTS courses CASCADE;
DROP TABLE IF EXISTS groups CASCADE;
DROP TABLE IF EXISTS user_courses;
DROP TABLE IF EXISTS user_groups;
DROP TABLE IF EXISTS course_messages;
DROP TABLE IF EXISTS group_messages;

CREATE TABLE accounts (
	username VARCHAR(60) PRIMARY KEY,
	password_hash CHAR(60) NOT NULL
);

CREATE TABLE courses (
	course_code CHAR(8) PRIMARY KEY,
	title VARCHAR(60)
);

CREATE TABLE groups (
	group_name VARCHAR(60) PRIMARY KEY,
	description TEXT DEFAULT 'None',
	course_code CHAR(8) REFERENCES courses(course_code) ON UPDATE CASCADE ON DELETE CASCADE,
	owner VARCHAR(60) REFERENCES accounts(username) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE user_courses (
	username VARCHAR(60) REFERENCES accounts(username) ON UPDATE CASCADE ON DELETE CASCADE,
	course_code CHAR(8) REFERENCES courses(course_code) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE user_groups (
	username VARCHAR(60) REFERENCES accounts(username) ON UPDATE CASCADE ON DELETE CASCADE,
	group_name VARCHAR(60) REFERENCES groups(group_name) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE course_messages (
	id SERIAL PRIMARY KEY,
	username VARCHAR(60) REFERENCES accounts(username) ON UPDATE CASCADE ON DELETE CASCADE,
	course_code CHAR(8) REFERENCES courses(course_code) ON UPDATE CASCADE ON DELETE CASCADE,
	message TEXT NOT NULL,
	time_posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE group_messages (
	id SERIAL PRIMARY KEY,
	username VARCHAR(60) REFERENCES accounts(username) ON UPDATE CASCADE ON DELETE CASCADE,
	group_name VARCHAR(60) REFERENCES groups(group_name) ON UPDATE CASCADE ON DELETE CASCADE,
	message TEXT NOT NULL,
	time_posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP INDEX IF EXISTS acc_user_idx;
DROP INDEX IF EXISTS crs_code_idx;
DROP INDEX IF EXISTS crs_title_idx;
DROP INDEX IF EXISTS grp_name_idx;
DROP INDEX IF EXISTS grp_code_idx;
DROP INDEX IF EXISTS grp_owner_idx;
DROP INDEX IF EXISTS u_crs_user_idx;
DROP INDEX IF EXISTS u_crs_code_idx;
DROP INDEX IF EXISTS u_grp_user_idx;
DROP INDEX IF EXISTS u_grp_name_idx;

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

DROP VIEW IF EXISTS course_groups;

CREATE VIEW course_groups AS
SELECT username, course_code, group_name, description
FROM groups NATURAL JOIN user_groups;

DROP FUNCTION IF EXISTS create_add_func();

CREATE OR REPLACE FUNCTION create_add_func() RETURNS TRIGGER AS $$
	BEGIN
		INSERT INTO groups VALUES (NEW.group_name, NEW.description, NEW.course_code, NEW.username);
		INSERT INTO user_groups VALUES (NEW.username, NEW.group_name);
		RETURN NEW;
	END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS create_add_trigger ON course_groups;

CREATE TRIGGER create_add_trigger
INSTEAD OF INSERT ON course_groups
FOR EACH ROW
EXECUTE PROCEDURE create_add_func();

DROP FUNCTION IF EXISTS delete_group_func();

CREATE OR REPLACE FUNCTION delete_group_func() RETURNS TRIGGER AS $$
	BEGIN
		DELETE FROM user_groups
			WHERE username = OLD.username
				AND group_name = OLD.group_name;
		DELETE FROM groups
			WHERE owner = OLD.username
				AND group_name = OLD.group_name;
		RETURN NEW;
	END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS delete_group_trigger ON course_groups;

CREATE TRIGGER delete_group_trigger
INSTEAD OF DELETE ON course_groups
FOR EACH ROW
EXECUTE PROCEDURE delete_group_func();
/*
DELETE FROM courses CASCADE;
DELETE FROM groups CASCADE;
DELETE FROM user_courses;
DELETE FROM user_groups;
DELETE FROM course_messages;
DELETE FROM group_messages;

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
('cs_tim', 'Databuds');
*/