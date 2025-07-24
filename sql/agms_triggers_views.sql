-- Create 'artists' table
CREATE TABLE IF NOT EXISTS artists (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

-- Create 'artworks' table
CREATE TABLE IF NOT EXISTS artworks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100) NOT NULL,
  image VARCHAR(255),
  artist_id INT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (artist_id) REFERENCES artists(id)
);

-- Create 'enquiries' table
CREATE TABLE IF NOT EXISTS enquiries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  message TEXT NOT NULL,
  status VARCHAR(50),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Create 'enquiry_log' table
CREATE TABLE IF NOT EXISTS enquiry_log (
  id INT AUTO_INCREMENT PRIMARY KEY,
  enquiry_id INT,
  deleted_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Trigger 1: Set default enquiry status to 'Pending'
DELIMITER //
CREATE TRIGGER trg_set_pending_status
BEFORE INSERT ON tblenquiry
FOR EACH ROW
BEGIN
  SET NEW.status = 'Pending';
END;
//
DELIMITER ;


-- Trigger 2: Log deleted enquiries
DELIMITER //
CREATE TRIGGER trg_log_deleted_enquiry
AFTER DELETE ON tblenquiry
FOR EACH ROW
BEGIN
  INSERT INTO enquiry_log (enquiry_id) VALUES (OLD.id);
END;
//
DELIMITER ;

-- View 1: Pending enquiries
CREATE VIEW view_pending_enquiries AS
SELECT id, name, email, message, created_at
FROM enquiries
WHERE status = 'Pending';

-- View 2: Artworks with artist names
CREATE VIEW view_artwork_with_artist AS
SELECT a.id, a.title, a.image, ar.name AS artist_name, a.created_at
FROM artworks a
JOIN artists ar ON a.artist_id = ar.id;
