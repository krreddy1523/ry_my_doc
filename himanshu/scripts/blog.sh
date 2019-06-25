#!/bin/bash

echo "---------------------------------------------------------"
echo "Started At : $(date)"
echo "---------------------------------------------------------"
#mysqldump -h daxmarktest.cualuo6jrltb.ap-south-1.rds.amazonaws.com -udbmaster -prailyatri_prodb@123 railyatri_production --compact --single-transaction --routines --triggers --verbose | mysql -h daxmark.mysql.database.azure.com -udbmaster@daxmark -prailyatri_prodb@123 railyatri_production
#mysqldump -h daxmarktest.cualuo6jrltb.ap-south-1.rds.amazonaws.com -udbmaster -prailyatri_prodb@123 railyatri_production | gzip -c > /log/railyatri_production.sql.gz
#zcat /log/railyatri_production.sql.gz | mysql -h daxtest.mysql.database.azure.com -udbmaster@daxtest -prailyatri_prodb@123 railyatri_production
#mysqldump -h daxmarktest.cualuo6jrltb.ap-south-1.rds.amazonaws.com -udbmaster -prailyatri_prodb@123 railyatri_production RY_SCHEDULE_MASTER_TEMP | gzip -c > /log/tables/railyatri_production_RY_SCHEDULE_MASTER_TEMP.sql.gz
mysql -h daxmark.railyatri.in -udbmaster -prailyatri_prodb@123 railyatri_production --skip-column-names --batch -e "select * from railyatri_users" | sed 's/\t/","/g;s/^/"/;s/$/"/;s/\n//g' > /log/railaytri_users
echo "---------------------------------------------------------"
echo "               TASK COMPLETED AT : $(date)"
echo "---------------------------------------------------------"
