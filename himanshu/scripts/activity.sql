SET @tablename = 'user_activity_logs';
SET @tablename1 = 'user_activity_logs_new';

SELECT  @max := (SELECT MAX(id) FROM user_activity_logs );

SELECT @query4 := CONCAT('ALTER TABLE ',  @tablename1, ' AUTO_INCREMENT', '=', @max+1,'');
PREPARE STMT3 FROM @query4; 

SELECT @query1 := CONCAT('CREATE TABLE ', 'user_activity_logs_new', ' LIKE ', @tablename,'');
PREPARE STMT1 FROM @query1;

SELECT @query := CONCAT('RENAME TABLE ', @tablename, ' TO `', @tablename, '_', DATE_FORMAT(NOW(), '%d%m%Y'),'`');
PREPARE STMT FROM @query;
EXECUTE STMT1;
EXECUTE STMT3;
EXECUTE STMT;


SELECT @query2 := CONCAT('RENAME TABLE ', @tablename1, ' TO ', @tablename,'');
PREPARE STMT2 FROM @query2;
EXECUTE STMT2;

