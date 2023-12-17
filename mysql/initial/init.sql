-- Create a new database if it doesn't exist
CREATE DATABASE IF NOT EXISTS project;

-- Switch to the new database
USE project;

-- Create a new user
CREATE USER 'example'@'%' IDENTIFIED BY 'example';

-- Grant privileges to the user on the database
GRANT ALL PRIVILEGES ON project.* TO 'example'@'%';

-- Flush privileges to apply changes
FLUSH PRIVILEGES;
