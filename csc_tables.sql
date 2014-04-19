DROP TABLE IF EXISTS accounts CASCADE;
DROP TABLE IF EXISTS projects CASCADE;
DROP TABLE IF EXISTS user_projects;
DROP TABLE IF EXISTS messages;

CREATE TABLE accounts (
	username VARCHAR(60) PRIMARY KEY DEFAULT 'Account Removed',
	password_hash CHAR(60) NOT NULL,
	first_name VARCHAR(60) NOT NULL,
	last_name VARCHAR(60) NOT NULL
);

--SEE COLABORATORS OPTION
--NUMBER OF COLABORATORS
--RELINQUISH OWNERSHIP? PASS ON OWNERSHIP?

CREATE TABLE projects (
	title VARCHAR(60) PRIMARY KEY,
	description TEXT DEFAULT 'None',
	username VARCHAR(60) REFERENCES accounts(username) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE user_projects (
	username VARCHAR(60) REFERENCES accounts(username) ON UPDATE CASCADE ON DELETE CASCADE,
	title VARCHAR(60) REFERENCES projects(title) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE messages (
	id SERIAL PRIMARY KEY,
	message TEXT NOT NULL,
	time_posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	title VARCHAR(60) REFERENCES projects(title) ON UPDATE CASCADE ON DELETE CASCADE,
	username VARCHAR(60) REFERENCES accounts(username) ON UPDATE CASCADE ON DELETE CASCADE
);

DELETE FROM messages;
DELETE FROM projects;
DELETE FROM user_projects;

INSERT INTO messages (message, title, username)
VALUES
('This is a test message', 'Web', 'tanvirt'),
('This is the second test mesage', 'Web', 'tanvirt'),
('This is another test message', 'Apple', 'tanvirt'),
('This is the final test message', 'Android', 'cs_tim');

INSERT INTO projects (title, username)
VALUES
('Web', 'tanvirt'),
('Android', 'tanvirt'),
('Apple', 'cs_tim'),
('Windows', 'cs_tim');

INSERT INTO user_projects (title, username)
VALUES
('Web', 'tanvirt'),
('Android', 'tanvirt'),
('Apple', 'tanvirt'),
('Android', 'cs_tim'),
('Apple', 'cs_tim'),
('Windows', 'cs_tim');