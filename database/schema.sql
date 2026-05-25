CREATE DATABASE IF NOT EXISTS edunova;
USE edunova;

-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'admin') DEFAULT 'student',
    profile_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Courses table
CREATE TABLE courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    thumbnail VARCHAR(255),
    category VARCHAR(100),
    instructor VARCHAR(100),
    price DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Lessons table
CREATE TABLE lessons (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT,
    title VARCHAR(200) NOT NULL,
    video_url VARCHAR(500),
    pdf_url VARCHAR(500),
    duration VARCHAR(50),
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Quizzes table
CREATE TABLE quizzes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT,
    question TEXT NOT NULL,
    options JSON,
    correct_answer VARCHAR(10),
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Progress table
CREATE TABLE progress (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    course_id INT,
    lesson_id INT,
    completed BOOLEAN DEFAULT FALSE,
    quiz_score INT DEFAULT 0,
    completion_percentage INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
);

-- Insert admin user (password: admin123)
INSERT INTO users (name, email, password, role) VALUES 
('Admin User', 'admin@edunova.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert sample courses
INSERT INTO courses (title, description, thumbnail, category, instructor) VALUES
('Web Development Bootcamp', 'Complete web development course with HTML, CSS, JavaScript, and PHP', 'https://images.unsplash.com/photo-1498050108023-c5249f4df085', 'Development', 'John Smith'),
('Data Science Fundamentals', 'Learn data analysis, visualization, and machine learning basics', 'https://images.unsplash.com/photo-1551288049-bebda4e38f71', 'Data Science', 'Sarah Johnson'),
('UI/UX Design Mastery', 'Master user interface and user experience design principles', 'https://images.unsplash.com/photo-1561070791-2526d30994b5', 'Design', 'Mike Brown');
