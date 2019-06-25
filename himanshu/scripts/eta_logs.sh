#!/bin/bash

echo "---------------------------------------------------------"
echo "Started At : $(date)          CREATED BY : HIMASNHU BISHT"
echo "---------------------------------------------------------"

mysql -h rylarge.railyatri.in -u dbmaster -prailyatri_prodb@123 << EOF

use railyatri_production_large_tables;

insert into eta_logs_all(select * from eta_logs where date(created_at) < (CURDATE() - INTERVAL 6 DAY));

delete from eta_logs where date(created_at) < (CURDATE() - INTERVAL 6 DAY);

EOF

echo "---------------------------------------------------------"
echo "               TASK COMPLETED AT : $(date)"
echo "---------------------------------------------------------"

