UPDATE members SET password = '$2y$10$YdxqXb0g554KyuLEQQupnOO5rt7gGE/LV0Nu8aEEJxfE/xBCh.Ctu' WHERE username = 'admin';
SELECT username, role, LENGTH(password) as pw_len FROM members WHERE username = 'admin';
