#!/bin/bash

echo "---------------------------------------------------------"
echo "Started At : $(date) "
echo "---------------------------------------------------------"

mysql -h rylarge.railyatri.in -u dbmaster -prailyatri_prodb@123 << EOF

use railyatri_production_large_tables;

insert into eta_logs_2728 (select * from eta_logs where date (train_start_date) ='2017-06-27');

EOF

echo "---------------------------------------------------------"
echo "               TASK COMPLETED AT : $(date)"
echo "---------------------------------------------------------"
