SET @tablename = 'eta_log_with_nulls';
SET @tablename1 = 'eta_log_with_nulls_new';

SELECT  @max := (SELECT MAX(id) FROM eta_log_with_nulls );

SELECT @query1 := CONCAT('CREATE TABLE ', 'eta_log_with_nulls_new', ' LIKE ', @tablename,'');
PREPARE STMT1 FROM @query1;
EXECUTE STMT1;

SELECT @query4 := CONCAT('ALTER TABLE ',  @tablename1, ' AUTO_INCREMENT', '=', @max+1,'');
PREPARE STMT3 FROM @query4;
EXECUTE STMT3;

SELECT @query := CONCAT('RENAME TABLE ', @tablename, ' TO `', @tablename, '_', DATE_FORMAT(NOW(), '%d%m%Y'),'`');
PREPARE STMT FROM @query;
EXECUTE STMT;

SELECT @query2 := CONCAT('RENAME TABLE ', @tablename1, ' TO ', @tablename,'');
PREPARE STMT2 FROM @query2;
EXECUTE STMT2;

