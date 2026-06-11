CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL UNIQUE,
  -- password VARCHAR(255) NOT NULL, -- removed, was md5 which is not secure
  password_hash VARCHAR(255) DEFAULT NULL, -- bcrypt hash
  avatar VARCHAR(255) DEFAULT 'default.png', -- filename
  admin TINYINT(1) DEFAULT 0, -- 1 if admin, else 0
  suspended TINYINT(1) DEFAULT 0, -- 1 if suspended, else 0
  suspension_reason VARCHAR(255),
  messages INT DEFAULT 0, -- message count in chat
  notes LONGTEXT, -- can be set by user in dashboard
  create_datetime DATETIME NOT NULL,
  INDEX idx_username (username),
  INDEX idx_admin (admin),
  INDEX idx_suspended (suspended)
);

-- for Englon Racing
CREATE TABLE leaderboard (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL,
  lapTime VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_laptime (lapTime),
  INDEX idx_username (username)
);
