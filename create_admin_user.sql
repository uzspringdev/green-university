-- Create backend admin user
-- Username: admin
-- Password: admin123

INSERT INTO "user" (username, auth_key, password_hash, email, status, created_at, updated_at)
VALUES (
    'admin',
    'test100key',
    '$2y$13$nJ1WDlBaGcbCdbNC9.tG7eO8/e9o7UUa9h5R2c0sK.fJnNvKxkWsy',  -- admin123
    'admin@greenuniversity.uz',
    10,  -- STATUS_ACTIVE
    extract(epoch from now())::integer,
    extract(epoch from now())::integer
);
