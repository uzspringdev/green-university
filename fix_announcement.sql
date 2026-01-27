-- Add missing published_at column to announcement table
ALTER TABLE announcement ADD COLUMN published_at INTEGER NOT NULL DEFAULT extract(epoch from now())::integer;

-- Create index on published_at for better query performance  
CREATE INDEX idx-announcement-published_at ON announcement (published_at);
