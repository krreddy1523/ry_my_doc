#!/bin/bash

echo "---------------------------------------------------------"
echo "Started At : $(date)"
echo "---------------------------------------------------------"

mysql -h daxmark.railyatri.in -u dbmaster -prailyatri_prodb@123 << EOF

use railyatri_production;

delete from sessions where date(created_at) < (CURDATE() -INTERVAL 5 DAY);

EOF

echo "---------------------------------------------------------"
echo "               TASK COMPLETED AT : $(date)"
echo "---------------------------------------------------------"
