INSERT INTO language (id, code, name, is_default, status, sort_order, created_at, updated_at) 
VALUES 
(1, 'uz', 'Oʻzbekcha', true, 1, 0, extract(epoch from now())::integer, extract(epoch from now())::integer),
(2, 'en', 'English', false, 1, 1, extract(epoch from now())::integer, extract(epoch from now())::integer),
(3, 'ru', 'Русский', false, 1, 2, extract(epoch from now())::integer, extract(epoch from now())::integer);
