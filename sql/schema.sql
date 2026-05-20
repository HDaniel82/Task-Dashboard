-- 1. Create the projects table
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Create the tasks table
CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    status ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

-- 3. Insert seed data so dashboard isn't empty 
INSERT INTO projects (title, description) VALUES 
('Task Tracker Development', 'Managing the development of my full-stack task manager'),
('Dashboard Admin Panel', 'Building the PHP/jQuery CMS backend');

INSERT INTO tasks (project_id, title, status) VALUES 
(1, 'Design MongoDB schema', 'completed'),
(1, 'Write Flask API endpoints', 'completed'),
(2, 'Dockerize local environment', 'completed'),
(2, 'Draft database schema', 'in_progress'),
(2, 'Build jQuery AJAX calls', 'pending');