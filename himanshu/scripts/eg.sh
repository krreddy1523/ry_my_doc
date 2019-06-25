#!/bin/bash
mysql -u root -ptoor << EOF
use mysql;
DECLARE hello varchar(28) DEFAULT 'today';
DECLARE CMD varchar(1000) DEFAULT 'show tables';
SET hello = CONVERT(VARCHAR(10), GETDATE(), 105);
SET CMD = 'SELECT * INTO [backup_table_' + replace(cast(hello as varchar(11)),' ','_')+'] FROM backup_table';
print CMD;
EOF
#SET @sql = CONCAT('CREATE TABLE backup_table',' LIKE db_backup_date');
#PREPARE statemt FROM @sql;
#EXECUTE statemt;
#DEALLOCATE PREPARE statemt;
