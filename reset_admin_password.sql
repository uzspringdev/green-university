-- Update admin user password to: Admin123!
UPDATE "user" 
SET password_hash = '$2y$13$5xkfEXGt8jEBqD8JNbqRBuYd7N2q5fBZL8S8v3nJ0Y7xZ8Km9pO4S',
    auth_key = 'newkey123'
WHERE username = 'admin';
