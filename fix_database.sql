-- Fix Database Schema for TUBESPEMWEB
-- Run this file to fix missing columns

USE `tubespemweb_toko`;

-- Check current status
SHOW COLUMNS FROM `pesanan_item`;

-- Add produk_id column if it doesn't exist
SET @var_if_not_exists := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_NAME = 'pesanan_item' AND COLUMN_NAME = 'produk_id' AND TABLE_SCHEMA = 'tubespemweb_toko');

SET @sql := IF(@var_if_not_exists = 0, 
    'ALTER TABLE `pesanan_item` ADD COLUMN `produk_id` BIGINT UNSIGNED NULL AFTER `pesanan_id`',
    'SELECT "Column produk_id already exists"'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Verify column was added
SHOW COLUMNS FROM `pesanan_item`;

-- Try to add foreign key (will ignore if already exists)
ALTER TABLE `pesanan_item` ADD CONSTRAINT `fk_pesanan_item_produk` FOREIGN KEY (`produk_id`) REFERENCES `produk`(`id`) ON DELETE RESTRICT;
