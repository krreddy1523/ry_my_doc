#!/bin/bash

echo "---------------------------------------------------------"
echo "Started At : $(date)"
echo "---------------------------------------------------------"

mysql -h daxmark.railyatri.in -u dbmaster -prailyatri_prodb@123 << EOF

use railyatri_production;

insert into bus_responses_all (select * from bus_responses where date(created_at) < (CURDATE() - INTERVAL 2 DAY));

delete from bus_responses where date(created_at) < (CURDATE() - INTERVAL 2 DAY);

EOF

echo "---------------------------------------------------------"
echo "               TASK COMPLETED AT : $(date)"
echo "---------------------------------------------------------"
