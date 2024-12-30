-- Insert users
INSERT INTO users (name, email, password, role) VALUES
('Alice Johnson', 'alice.johnson@example.com', 'hashedpassword1', 'admin'),
('Bob Smith', 'bob.smith@example.com', 'hashedpassword2', 'project_manager'),
('Charlie Brown', 'charlie.brown@example.com', 'hashedpassword3', 'team_member');

-- Insert projects
INSERT INTO projects (name, description, date_commence, date_fin, status, is_public, id_user) VALUES
('Website Redesign', 'Redesign the company website for better UX.', '2024-01-01', '2024-06-01', 'in_progress', TRUE, 2),
('Mobile App Development', 'Develop a mobile app for our services.', '2024-02-15', '2024-08-15', 'not_started', FALSE, 2);

-- Insert categories
INSERT INTO categories (name, description) VALUES
('Design', 'Tasks related to UI/UX design.'),
('Development', 'Tasks involving software development.'),
('Marketing', 'Tasks related to marketing and promotions.');

-- Insert tags
INSERT INTO tags (name) VALUES
('Urgent'),
('Backend'),
('Frontend'),
('SEO');

-- Insert tasks
INSERT INTO tasks (title, description, status, priority, fin_date, category_id, project_id, assigned_to, created_by) VALUES
('Create Homepage Mockup', 'Design a new homepage layout.', 'inProgress', 'high', '2024-02-01', 1, 1, 1, 2),
('Develop API Endpoints', 'Implement backend API endpoints.', 'toDo', 'medium', '2024-03-01', 2, 2, 2, 3),
('SEO Optimization', 'Optimize site for search engines.', 'toDo', 'low', '2024-04-01', 3, 1, 3, 1);

-- Insert assign_task
INSERT INTO assign_task (task_id, user_id) VALUES
(1, 1),
(2, 2),
(3, 3);

-- Insert task_tags
INSERT INTO task_tags (task_id, tag_id) VALUES
(1, 1),
(2, 2),
(2, 3),
(3, 4);

-- Insert project_members
INSERT INTO project_members (project_id, user_id, role) VALUES
(1, 1, 'manager'),
(1, 2, 'member'),
(1, 3, 'member'),
(2, 2, 'manager'),
(2, 3, 'member');
