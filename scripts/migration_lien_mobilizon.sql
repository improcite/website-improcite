SET @sql = IF(
    EXISTS(
        SELECT 1
        FROM information_schema.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME = 'impro_evenements'
          AND COLUMN_NAME = 'lien_mobilizon'
    ),
    'SELECT 1',
    'ALTER TABLE impro_evenements ADD COLUMN lien_mobilizon VARCHAR(255) DEFAULT NULL'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
