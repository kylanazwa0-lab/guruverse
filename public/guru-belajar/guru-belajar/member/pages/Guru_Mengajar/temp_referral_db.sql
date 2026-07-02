-- Cek & tambah kolom referral_code di tabel members
SET @dbname = DATABASE();
SET @tablename = 'members';
SET @columnname = 'referral_code';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD ', @columnname, ' VARCHAR(20) NULL UNIQUE AFTER phone;')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Update existing members with random referral codes if NULL
UPDATE members SET referral_code = CONCAT('GURU-', UPPER(SUBSTRING(MD5(RAND()), 1, 6))) WHERE referral_code IS NULL;

-- Tabel gb_referrals
CREATE TABLE IF NOT EXISTS `gb_referrals` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `referrer_id` INT NOT NULL,
    `referred_id` INT NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`referrer_id`) REFERENCES members(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`referred_id`) REFERENCES members(`id`) ON DELETE CASCADE
);

-- Tabel gb_vouchers
CREATE TABLE IF NOT EXISTS `gb_vouchers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `owner_id` INT NOT NULL,
    `voucher_code` VARCHAR(50) NOT NULL UNIQUE,
    `discount_percent` INT NOT NULL,
    `is_used` TINYINT(1) DEFAULT 0,
    `used_at` DATETIME NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`owner_id`) REFERENCES members(`id`) ON DELETE CASCADE
);
