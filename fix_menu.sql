-- Add missing code column to menu table
ALTER TABLE menu ADD COLUMN code VARCHAR(50) NOT NULL DEFAULT 'default';

-- Create unique index on code
CREATE UNIQUE INDEX idx-menu-code ON menu (code);

-- Update existing menus with proper codes
UPDATE menu SET code = 'main-menu' WHERE id = 1;
UPDATE menu SET code = 'footer-menu' WHERE id = 2;
